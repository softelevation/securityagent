<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Validators\MissionValidator;
use App\Traits\ResponseTrait;
use App\Traits\PaymentTrait;
use App\Mission;
use App\UserPaymentHistory;
use App\Customer;
use App\CardDetail;
use App\UploadInvoice;
use App\Agent;
use Carbon\Carbon;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Session;
use App\Traits\MissionTrait;
use Auth;
use DB;
use App\Notifications\MissionCreated;
use App\Notifications\MissionCancelled;
use App\Notifications\PaymentDone;
use App\Helpers\PlivoSms;
use Redirect;

class MissionController extends Controller
{
    use MissionValidator, ResponseTrait, PaymentTrait, MissionTrait;

    private $limit; 

    public function __construct(){
        $this->limit = 10;
    }

	/**
     * @param $request
     * @return mixed
     * @method index
     * @purpose Get Customer Mission's List 
     */
    public function index(Request $request){
        $missionAll = Mission::with('child_missions')->where('parent_id',0)->where('customer_id',\Auth::user()->customer_info->id)->orderBy('id','DESC')->paginate($this->limit,['*'],'all');

        $missionPending = Mission::where('customer_id',\Auth::user()->customer_info->id)->where('status',3)->orderBy('id','DESC')->paginate($this->limit,['*'],'pending');
        $missionInProgress = Mission::where('customer_id',\Auth::user()->customer_info->id)->where('status',4)->orderBy('id','DESC')->paginate($this->limit,['*'],'inprogress');
        $missionCompleted = Mission::with('child_missions')->where('parent_id',0)->where('customer_id',\Auth::user()->customer_info->id)->where('status',5)->orderBy('id','DESC')->paginate($this->limit,['*'],'finished');        
        $statusArr = Helper::getMissionStatus();
        $statusArr = array_flip($statusArr);

        $params = [
            'mission_all' => $missionAll,
            'pending_mission' => $missionPending,
            'inprogress_mission' => $missionInProgress,
            'finished_mission' => $missionCompleted,
            'status_list'=>$statusArr,
            'limit' => $this->limit,
            'page_no' => 1,
            'page_name' => 'all'
        ];
        if($request->isMethod('get')){
            if(isset($request->all)){ 
                $params['page_no'] = $request->all; 
                $params['page_name'] = 'all'; 
            }
            if(isset($request->inprogress)){ 
                $params['page_no'] = $request->inprogress; 
                $params['page_name'] = 'inprogress'; 
            }
            if(isset($request->pending)){ 
                $params['page_no'] = $request->pending; 
                $params['page_name'] = 'pending'; 
            }
            if(isset($request->finished)){ 
                $params['page_no'] = $request->finished; 
                $params['page_name'] = 'finished'; }
        }
        return view('customer.missions',$params);
    }

    /**
     * @param $request
     * @return mixed
     * @method createMission
     * @purpose Create New Mission View 
     */
    public function createMission(){
        return view('customer.create_mission');
    }

    /**
     * @param $request
     * @return mixed
     * @method saveMission
     * @purpose Create New Mission View 
     */
    public function saveMission(Request $request){
        // try{
            $validation = $this->quickMissionValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }
            if(!(isset($request->latitude) && trim($request->latitude)!='' && isset($request->longitude) && trim($request->longitude)!='')){
                return response($this->getErrorResponse(trans('messages.invalid_lat_log')));    
            }
            $data = array_except($request->all(),['_token']);
            if($data['quick_book']==0){
                $date = $data['start_date_time'];
                $dt = explode(' ',$date);
                $date = date('Y-m-d',strtotime($dt[0]));
                $time = $dt[1];
                $startDateTime = $date.' '.$time;
                $data['start_date_time'] = $startDateTime;
                $mission_id = $this->saveQuickMissionDetails($data);
                if($mission_id){
                    $mission_id = Helper::encrypt($mission_id);
                    $response['message'] = trans('messages.mission_saved');
                    $response['delayTime'] = 2000;
                    $response['url'] = url('customer/find-mission-agent/'.$mission_id);
                    return $this->getSuccessResponse($response);
                }
            }
            // Check if any agent available 
            $agent_type_needed = $data['agent_type'];
            // Get nearest agent
            $agent = Agent::whereHas('types',function($q) use($agent_type_needed){
                $q->where('agent_type',$agent_type_needed);
            })->where('status',1)->where('available',1)->select(DB::raw("*, 111.111 *
                    DEGREES(ACOS(LEAST(1.0, COS(RADIANS(".$request->latitude."))
                    * COS(RADIANS(work_location_latitude))
                    * COS(RADIANS(".$request->longitude." - work_location_longitude))
                    + SIN(RADIANS(".$request->latitude."))
                    * SIN(RADIANS(work_location_latitude))))) AS distance_in_km"))->having('distance_in_km', '<', 100)->orderBy('distance_in_km','ASC')->first();   
            if($agent){
                $data['agent_id'] = $agent->id;
                $data['customer_id'] = \Auth::user()->customer_info->id;
                $data['created_at'] = Carbon::now();
                $data['updated_at'] = Carbon::now();
                $data['step'] = 1;
                // If customer dont know, then set 8 hours default
                if($data['total_hours']==0){
                    $data['total_hours'] = 8;
                }
                $baseRate = Helper::get_agent_rate($data['agent_type'],$data['quick_book']);
				if($data['intervention'] == 'Guard_service'){
					if($data['total_hours'] > 4){
						$data['amount'] = $data['total_hours']*$baseRate;
					}else{
						$data['amount'] = 4*$baseRate;
					}
				}else if($data['intervention'] == 'Intervention'){
					$data['amount'] = $data['total_hours'] * Helper::get_agent_rate(8,1);
				}else if($data['intervention'] == 'Security_patrol'){
					$data['amount'] = $data['total_hours'] * Helper::get_agent_rate(9,1);
				}else{
					$data['amount'] = $data['total_hours']*$baseRate;
				}
				
                // If distance is greater than 50 KM, add travel fee per km
                $agentDistance = round($agent->distance_in_km);
                if($agentDistance > 50){
                    $data['amount'] = $data['amount']+(0.5*$agentDistance);
                }
                // Calculate VAT
                $vat = Helper::VAT_PERCENTAGE;
                $vatAmount = ($data['amount']*$vat)/100;
                $data['amount'] = $data['amount']+$vatAmount;
                
                if(isset($data['record_id']) && $data['record_id']!=''){
                    $record_id = Helper::decrypt($data['record_id']);
                    unset($data['record_id'],$data['created_at']);
                    $result = Mission::where('id',$record_id)->update($data);
                    $missionID = $record_id;
                }else{
                    $missionID = Mission::insertGetId($data);
                }
                if($missionID){
                    $missionID = Helper::encrypt($missionID);
                    $response['message'] = trans('messages.mission_saved');
                    $response['delayTime'] = 5000;
                    $response['url'] = url('customer/find-mission-agent/'.$missionID);
                    return $this->getSuccessResponse($response);
                }else{
                    $response['message'] = trans('messages.error');
                    $response['delayTime'] = 5000;
                    return $this->getErrorResponse($response);
                }
            }else{
                return response($this->getErrorResponse(trans('messages.agent_not_available')));
            }                       

            // $agents = $agents->toArray();
            // // Get Nearest Agent
            // $originLocation = $data['latitude'].', '.$data['longitude'];
            // $destinationLocation = implode("|",$agents);
            // $response = \GoogleMaps::load('distancematrix')->setParam ([
            //                 'origins' =>$originLocation, 
            //                 'destinations' =>$destinationLocation
            //             ])->get();
            // $response = json_decode($response,TRUE);
            // $agentsIDs = array_keys($agents);
            // $_distArr = [];
            // foreach($response['rows'] as $row){ 
            //     foreach($row['elements'] as $key=>$destination){
            //         if(trim(strtolower($destination['status']))=='ok'){
            //             $_distArr[] = $destination['distance']['value'];
            //         }
            //     }
            // }
            // if(empty($_distArr)){
            //     return response($this->getErrorResponse('No agent available for this location at the moment. Please try again later!'));
            // }
            // $key = array_keys($_distArr, min($_distArr)); 
            
        // }catch(\Exception $e){
        //     return response($this->getErrorResponse($e->getMessage()));
        // }
    }

    /**
     * @param $request
     * @return mixed
     * @method createMission
     * @purpose Create New Mission View 
     */
    public function quickCreateMission(){
        return view('customer.quick_create_mission');
    }

    /**
     * @param $request
     * @return mixed
     * @method getMissionQuote
     * @purpose Get mission quote
     */
    public function findMissionAgent($id){
        $id = Helper::decrypt($id);
        $mission = Mission::where('id',$id)->first();
        $agent = Agent::where('id',$mission->agent_id)->first();
        $chargeAmount = $mission->amount;
        if($mission->quick_book==0){
            $chargeAmount = ($mission->amount*Helper::MISSION_ADVANCE_PERCENTAGE)/100;
        }
        $data['mission'] = $mission;
        $data['agent'] = $agent;
        $data['charge_amount'] = $chargeAmount;
        return view('customer.find_mission_agent',$data);
    }

    /**
     * @param $id
     * @return mixed
     * @method proceedToPayment
     * @purpose View Payment and Mission Details
     */
    public function proceedToPayment($id){
        try{
            $mission_id = Helper::decrypt($id);
            $mission = Mission::where('id',$mission_id)->first();
			$data['cards'] = array();
            $data['mission'] = $mission;
            $chargeAmount = $mission->amount;
            if($mission->quick_book==0){
                $chargeAmount = ($mission->amount*Helper::MISSION_ADVANCE_PERCENTAGE)/100;
            }
			$data['cards'] = CardDetail::where('user_id',Auth::user()->id)->get();
            $data['charge_amount'] = $chargeAmount;
            $data['customer_type'] = $mission->customer_details->customer_type;
            $data['customer_add_bank'] = $mission->customer_details->add_bank;
			
            // if(!isset($mission->customer_details->customer_stripe_id) || $mission->customer_details->customer_stripe_id==null){
                // Create customer on stripe
                $user_email = $mission->customer_details->user->email;
                $customer = $this->createCustomer($user_email);
                $cus_stripe_id = $customer['id'];
                Customer::where('id',$mission->customer_details->id)->update(['customer_stripe_id'=>$cus_stripe_id]);
            // }else{
                // $addedCards = $this->getCardsList($mission->customer_details->customer_stripe_id);
                
                // $data['cards'] = $addedCards;
            // }
            return view('customer.mission_payment_view',$data);
        }catch(\Exception $e){
            $res = $this->getErrorResponse($e->getMessage());
            if($res['error']){
                return Redirect::back()->withErrors(['Something went wrong with customer id!']);
            }
           // $res =  response($this->getErrorResponse($e->getMessage()));
          
        }
    }
	
	public function savePdfProceedToPayment($id){
		try{
			
			$mission_id = Helper::decrypt($id);
            $mission = Mission::where('id',$mission_id)->first();
			$email = Auth::user()->email;
			$data = Customer::where('user_id',Auth::user()->id)->first();
			// return view('pdf.save_pdf_proceed',['mission'=>$mission,'data'=>$data,'email'=>$email]);
			$pdf = \PDF::loadView('pdf.save_pdf_proceed', ['mission'=>$mission,'data'=>$data,'email'=>$email]);
			return $pdf->download('invoice.pdf');
		}catch(\Exception $e){
            return $this->getErrorResponse($e->getMessage());
        }
	}
	
	public function cardDelete($id){
		try{
			$CardDetail = CardDetail::find($id);
			if($CardDetail){
				$CardDetail->delete();
				$response['status'] = true;
				$response['delayTime'] = 2000;
                $response['message'] = trans('messages.card_deleted');
                return $this->getSuccessResponse($response);
            }else{
                return $this->getErrorResponse('Something went wrong !');
            }
		}catch(\Exception $e){
            return $this->getErrorResponse($e->getMessage());
        }
		
	}

    /**
     * @param $request
     * @return mixed
     * @method makeMissionPayment
     * @purpose Add new card and make payment
     */
	 
	public function uploadInvoice($id){
        return view('customer.upload_invoice')->with('id',$id);
	}
	
	
	public function uploadInvoicePost(Request $request){
		try{
			$validation = $this->quickUploadInvoiceMissionValidations($request);
			if($validation['status']==false){
					return response($this->getValidationsErrors($validation));
			}
			$post = array();
			$post['user_id'] = Auth::user()->id;
			$post['mission_id'] = $request->mission_id;
			$mission = Mission::find($post['mission_id']);
			if(isset($request->upload_invoice) && $request->upload_invoice!=""){
                $image = $request->file('upload_invoice');   
                $fileName = time().$image->getClientOriginalName();
                $filePath = public_path('upload_invoices');
                $uploadStatus = $image->move($filePath,$fileName);
                $post['invoice'] = $fileName;
            }
			UploadInvoice::updateOrCreate(array('mission_id'=>$post['mission_id']),$post);
			
			$response['message'] = trans('messages.upload_invoice');
			$response['delayTime'] = 5000;
			$response['url'] = url('customer/mission-details/view/'.Helper::encrypt($request->mission_id));
			return $this->getSuccessResponse($response);
			
		}catch(\Exception $e){
            return $this->getErrorResponse($e->getMessage());
        }
	}
	
    public function makeMissionPayment(Request $request){
        try{
			if($request->form_type && $request->form_type == 'bank_transfer')
			  {
				$validation = $this->quickBankMissionValidations($request);
				if($validation['status']==false){
						return response($this->getValidationsErrors($validation));
				}
				$amount = Helper::decrypt($request->amount);
				$mission_id = Helper::decrypt($request->mission_id);
				$mission = Mission::where('id',$mission_id)->first();
				$chargeAmount = $mission->amount;
				if($mission->quick_book==0){
					$chargeAmount = ($mission->amount*Helper::MISSION_ADVANCE_PERCENTAGE)/100;
				}
				
				$mailContent = [
                    'name' => ucfirst($mission->customer_details->first_name),
                    'message' => trans('messages.payment_done_message',['amount'=>$chargeAmount]), 
                    'url' => url('customer/billing-details') 
                ];
                $mission->customer_details->user->notify(new PaymentDone($mailContent));
				$agentNumber = $mission->agent_details->phone;
				PlivoSms::sendSms(['phoneNumber' => $agentNumber, 'msg' => trans('messages.plivo_customer_mission_created', ['missionId'=> $mission_id])]);
				Mission::where('id',$mission_id)->update(['payment_status'=>2]);
				$paymentDetails = [
                    'amount'      => $amount,
                    'status'      => 'awiting payment',  
                    'charge_id'   => 'bank transfer',
                    'mission_id'  => $mission_id,
                    'customer_id' => $mission->customer_details->id,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now()
                ];
				UserPaymentHistory::insert($paymentDetails);
				$response['message'] = trans('messages.payment_completed');
                $response['delayTime'] = 5000;
                $response['url'] = url('customer/missions');
                return $this->getSuccessResponse($response);
			  }else{
            $amount = Helper::decrypt($request->amount);
            $mission_id = Helper::decrypt($request->mission_id);
            $mission = Mission::where('id',$mission_id)->first();
            $chargeAmount = $mission->amount;
            if($mission->quick_book==0){
                $chargeAmount = ($mission->amount*Helper::MISSION_ADVANCE_PERCENTAGE)/100;
            }
            $customer_stripe_id = $mission->customer_details->customer_stripe_id;
            $last4digit = substr($request->card_number, -4);
            // Get added card's list
            $addedCards = $this->getCardsList($customer_stripe_id);
           
            if(isset($addedCards) && isset($addedCards['data'])){
                foreach($addedCards['data'] as $card){
                    // If entered card is already been added
                    if($card['last4']==$last4digit){
                        return $this->getErrorResponse(trans('messages.card_already_added'));
                    }
                } 
            }
          
            // Add New Card
            $cardData = [
                'number'    => $request->card_number,
                'exp_month' => $request->expire_month,
                'cvc'       => $request->cvc,
                'exp_year'  => $request->expire_year,
            ];
            $card = $this->addNewCard($cardData,$customer_stripe_id);
            // Make Charge Payment
            $chargeData = [
                'customer' => $customer_stripe_id,
                'currency' => config('services.stripe.currency'),
                'amount'   => $chargeAmount,
                'description' => 'Mission Charge Amount'
            ];

            $charge = $this->createCharge($chargeData);
            if($charge['status']=='succeeded'){
                // Save data to payment history
                $paymentDetails = [
                    'amount'      => $chargeAmount,
                    'status'      => $charge['status'],  
                    'charge_id'   => $charge['id'],
                    'mission_id'  => $mission_id,
                    'customer_id' => $mission->customer_details->id,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now() 
                ];
                UserPaymentHistory::insert($paymentDetails);
				if($request->save_card_deail && $request->save_card_deail == 1){
					CardDetail::updateOrCreate(array('user_id'=>Auth::user()->id,'card_number'=>$request->card_number),array('user_id'=>Auth::user()->id,'name'=>$request->name,'card_number'=>$request->card_number,'expire_month'=>$request->expire_month,'expire_year'=>$request->expire_year));
				}
                // Update Mission Data
                Mission::where('id',$mission_id)->update(['payment_status'=>1]);
                /*----Customer Notification-----*/
                $mailContent = [
                    'name' => ucfirst($mission->customer_details->first_name),
                    'message' => trans('messages.mission_created'), 
                    'url' => url('customer/mission-details/view').'/'.$request->mission_id 
                ];
                $mission->customer_details->user->notify(new MissionCreated($mailContent));
                /*--------------*/
                /*----Payment Notification-----*/
                $mailContent = [
                    'name' => ucfirst($mission->customer_details->first_name),
                    'message' => trans('messages.payment_done_message',['amount'=>$chargeAmount]), 
                    'url' => url('customer/billing-details') 
                ];
                $mission->customer_details->user->notify(new PaymentDone($mailContent));
                /*--------------*/  
                /*----Agent Notification-----*/
                if(isset($mission->agent_details)){
                    $mailContent = [
                        'name' => ucfirst($mission->agent_details->first_name),
                        'message' => trans('messages.agent_new_mission_notification'), 
                        'url' => url('agent/mission-details/view').'/'.$request->mission_id 
                    ];
                    $mission->agent_details->user->notify(new MissionCreated($mailContent));
                }
                /*--------------*/
                $response['message'] = trans('messages.payment_completed');
                $response['delayTime'] = 5000;
                $response['url'] = url('customer/missions');
                return $this->getSuccessResponse($response);
            }else{
                $response['message'] = trans('messages.error');
                $response['delayTime'] = 2000;
                $response['url'] = url('customer/missions');
                $response['data'] = $charge;
                return $this->getErrorResponse($response);
            }
			  }
        }catch(\Exception $e){
            return $this->getErrorResponse($e->getMessage());
        }
    }

    /**
     * @param $request, $id
     * @return mixed
     * @method editQuickMission
     * @purpose Edit mission details
     */
    public function editQuickMission(Request $request, $id){
        $mission_id = Helper::decrypt($id);
        $mission = Mission::where('id',$mission_id)->first();
        $data['mission'] = $mission;
        return view('customer.quick_create_mission',$data);

    }

    /**
     * @param $mission_id
     * @return mixed
     * @method viewMissionDetails
     * @purpose View mission details
     */
    public function viewMissionDetails($mission_id){
        $dec_mission_id = Helper::decrypt($mission_id);
        $data['mission'] = Mission::where('id',$dec_mission_id)->first();
        $data['mission_id'] = $mission_id;
        return view('customer.view_mission_details',$data);
    }

    /**
     * @param $request
     * @return mixed
     * @method makeCardPayment
     * @purpose Make payment from added cards
     */
    public function makeCardPayment(Request $request){      
        try{

            $card_id = $request->card_id;
            $mission_id = Helper::decrypt($request->mission_id);

            $mission = Mission::with('agent_details')->where('id',$mission_id)->first();
      
            $agentNumber = $mission->agent_details->phone;
       
            $chargeAmount = $mission->amount;
            if($mission->quick_book==0){
                $chargeAmount = ($mission->amount*Helper::MISSION_ADVANCE_PERCENTAGE)/100;
            }
            // Make Charge Payment
            $customer_stripe_id = $mission->customer_details->customer_stripe_id;
            $chargeData = [
                'customer' => $customer_stripe_id,
                'currency' => config('services.stripe.currency'),
                'amount'   => $chargeAmount,
                'description' => 'Mission Charge Amount',
                'source'    => $card_id
            ];
            $charge = $this->createCharge($chargeData);
            if($charge['status']=='succeeded'){
                // Save data to payment history
                $paymentDetails = [
                    'amount'      => $chargeAmount,
                    'status'      => $charge['status'],  
                    'charge_id'   => $charge['id'],
                    'mission_id'  => $mission_id,
                    'customer_id' => $mission->customer_details->id,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now() 
                ];
                UserPaymentHistory::insert($paymentDetails);
                // Update Mission Data
                Mission::where('id',$mission_id)->update(['payment_status'=>1]);

                /*--------------*/

                /*----Customer Notification-----*/
                $mailContent = [
                    'name' => ucfirst($mission->customer_details->first_name),
                    'message' => trans('messages.mission_created'), 
                    'url' => url('customer/mission-details/view').'/'.$request->mission_id 
                ];
                $mission->customer_details->user->notify(new MissionCreated($mailContent));
                /*--------------*/
                /*----Payment Notification-----*/
                $mailContent = [
                    'name' => ucfirst($mission->customer_details->first_name),
                    'message' => trans('messages.payment_done_message',['amount'=>$chargeAmount]), 
                    'url' => url('customer/billing-details') 
                ];
                $mission->customer_details->user->notify(new PaymentDone($mailContent));
                /*--------------*/ 
                /*----Agent Notification-----*/
                if(isset($mission->agent_details)){
                    $mailContent = [
                        'name' => ucfirst($mission->agent_details->first_name),
                        'message' => trans('messages.agent_new_mission_notification'), 
                        'url' => url('agent/mission-details/view').'/'.$request->mission_id 
                    ];
                    $mission->agent_details->user->notify(new MissionCreated($mailContent));
                }
                /*--------------*/
                
                /*----Customer send phone notification-----*/
                PlivoSms::sendSms(['phoneNumber' => $agentNumber, 'msg' => trans('messages.plivo_customer_mission_created', ['missionId'=> $mission_id])]);
                /*--------------*/
                
                $response['message'] = trans('messages.payment_completed');
                $response['delayTime'] = 5000;
                $response['url'] = url('customer/missions');
                return $this->getSuccessResponse($response);
            }else{
                $response['message'] = trans('messages.error');
                $response['delayTime'] = 2000;
                $response['url'] = url('customer/missions');
                $response['data'] = $charge;
                return $this->getErrorResponse($response);
            }
        }catch(\Plivo\Exceptions\PlivoResponseException $e){
                $response['message'] = trans('messages.payment_completed');
                $response['delayTime'] = 5000;
                $response['url'] = url('customer/missions');
                return $this->getSuccessResponse($response);
        }catch(\Exception $e){
            return $this->getErrorResponse($e->getMessage());
        }
    }

    /**
     * @param $request
     * @return mixed
     * @method saveMissionTemp
     * @purpose Save mission data to session and redirect to map page
     */
    public function saveMissionTemp(Request $request){
        try{
            $validation = $this->quickMissionValidations($request);
            if($validation['status']==false){
                return response($this->getValidationsErrors($validation));
            }
            if(!(isset($request->latitude) && trim($request->latitude)!='' && isset($request->longitude) && trim($request->longitude)!='')){
                return response($this->getErrorResponse(trans('messages.invalid_lat_long')));    
            }
            $data = array_except($request->all(),['_token']);
            if($data['quick_book']==0){
                $date = str_replace('/', '-', $data['start_date_time']);
                $startDateTime = date('Y-m-d H:i:s', strtotime($date));
                $data['start_date_time'] = $startDateTime;
                
                $mission_id = $this->saveQuickMissionDetails($data);
                if($mission_id){
                    $mission_id = Helper::encrypt($mission_id);
                    $response['message'] = trans('messages.redirect_dashboard');
                    $response['delayTime'] = 2000;
                    $response['url'] = url('customer/find-mission-agent/'.$mission_id);
                    return $this->getSuccessResponse($response);
                }
            }
            Session::put('mission',$data);
            $response['message'] = trans('messages.finding_agents');
            $response['delayTime'] = 2000;
            $params = [
                'location'=>$data['location'],
                'latitude'=>$data['latitude'],
                'longitude'=>$data['longitude'],
                'agent_type'=>$data['agent_type']
            ];
			if(!array_key_exists("vehicle_required",$data)){
					$params['is_vehicle'] = 1;
			}else{
				if($data['vehicle_required']==1){
					$params['is_vehicle'] = 1;
				}
				if($data['vehicle_required']==2){
					$params['is_vehicle'] = 0;
				}
			}
            $response['url'] = route('available-agents',$params);
            return $this->getSuccessResponse($response);
        }catch(\Exception $e){
            die($e->getMessage());
        }
    }

    /**
     * @param $request
     * @return mixed
     * @method bookAgent
     * @purpose Book an agent for mission 
     */
    public function bookAgent(Request $request){
        try{
            //Calculate mission start and end times 
            // $add_mission_hours = '+'.$mission->total_hours.' hours';
            // $mission_start_date_time = $mission->start_date_time;
            // $mission_end_date_time = date('Y-m-d H:i:s', strtotime($add_mission_hours, strtotime($mission->start_date_time)));
            // $mission_start_time = date('H:i:s',strtotime($mission_start_date_time));
            // $mission_end_time = date('H:i:s',strtotime($mission_end_date_time));
            // // Check if any agent available 
            // $agent_type_needed = $mission->agent_type;
            // if($mission->quick_book==1){
            //     $start_date = date('Y-m-d');    
            //     if(isset($mission->start_date_time) && $mission->start_date_time!=''){
            //         $start_date = date('Y-m-d',strtotime($mission->start_date_time));
            //     }
            // }else{
            //     $start_date = date('Y-m-d',strtotime($mission->start_date_time));
            // }

            //     $a->whereDoesntHave('missions',function($q) use ($mission_start_date_time,$mission_end_date_time){
            //         $q->whereBetween('start_date_time',[$mission_start_date_time,$mission_end_date_time])->where('status',0);
            //     });
            // }



            $agent_id = Helper::decrypt($request->agent_id);
            if(Session::has('mission')){
                $mission = Session::get('mission');
                //Calculate mission start and end times 
                $add_mission_hours = '+'.$mission['total_hours'].' hours';
                $mission_start_date_time = date('Y-m-d H:i:s');
                $mission_end_date_time = date('Y-m-d H:i:s', strtotime($add_mission_hours, strtotime($mission_start_date_time)));

                $res = Mission::where('agent_id',$agent_id)->whereBetween('start_date_time',[$mission_start_date_time,$mission_end_date_time])->first();
                if($res){
                    $time1 = Carbon::parse($mission_start_date_time);
                    $time2 = Carbon::parse($res->start_date_time);
                    $diffHours = $time1->diff($time2)->format('%H:%I:%S');
                    $msg = trans('frontend.hours_available_msg',['time'=>$diffHours]);
                    return $this->getErrorResponse($msg);
                }
                $mission['agent_id'] = $agent_id;
                $mission['distance'] = $request->distance;
                Session::put('mission',$mission);
                if(Auth::check() && Auth::user()->role_id==1){
                    $mission_id = $this->saveQuickMissionDetails($mission);
                    if($mission_id){
                        Session::forget('mission');
                        $mission_id = Helper::encrypt($mission_id);
                        $response['message'] = trans('messages.redirect_dashboard');
                        $response['delayTime'] = 2000;
                        $response['url'] = url('customer/find-mission-agent/'.$mission_id);
                        return $this->getSuccessResponse($response);
                    }
                }else{
                    $response['message'] = trans('messages.login_first');
                    $response['delayTime'] = 2000;
                    $response['url'] = url('login');
                    return $this->getSuccessResponse($response);
                }
            }else{
                $response['message'] = trans('messages.session_expired');
                $response['delayTime'] = 2000;
                $response['url'] = url('available-agents');
                return $this->getErrorResponse($response);
            }
        }catch(\Exception $e){
            return $this->getErrorResponse($e->getMessage());
        }
    }

    /**
     * @param $request
     * @return mixed
     * @method cancelMission
     * @purpose Cancel a mission 
     */
    public function cancelMission($mission_id){
        try{
            $encMissionId = $mission_id;
            $mission_id = Helper::decrypt($mission_id);
            $cancelled = $this->cancelMissionRequest($mission_id);
            if($cancelled==1){
                $mission = Mission::where('id',$mission_id)->first();
                /*----Agent Notification-----*/
                $mailContent = [
                    'name' => ucfirst($mission->agent_details->first_name),
                    'message' => trans('messages.cancel_mission_notify_agent'), 
                    'url' => url('agent/mission-details/view').'/'.$encMissionId
                ];
                $mission->agent_details->user->notify(new MissionCancelled($mailContent));
                /*--------------*/
                $response['message'] = trans('messages.mission_cancelled');
                $response['url'] = url('customer/missions'); 
                return $this->getSuccessResponse($response);
            }else{
                return $this->getErrorResponse(trans('messages.error'));
            }
        }catch(\Exception $e){
            return $this->getErrorResponse($e->getMessage());
        }
    }

    /**
     * @param $request
     * @return mixed
     * @method deleteMission
     * @purpose Delete a mission 
     */
    public function deleteMission($mission_id){
        try{
            $mission_id = Helper::decrypt($mission_id);
            $deleted = $this->deleteMissionRequest($mission_id);
            if($deleted==1){
                $response['message'] = trans('messages.mission_deleted');
                $response['url'] = url('customer/missions'); 
                return $this->getSuccessResponse($response);
            }else{
                return $this->getErrorResponse('Something went wrong !');
            }
        }catch(\Exception $e){
            return $this->getErrorResponse($e->getMessage());
        }
    }
}
