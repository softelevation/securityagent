<?php

namespace App\Traits;

trait ResponseTrait
{
    /**
     * @param   : $validation
     * @rresponse
     * @method  : getValidationsErrors
     * @purpose : Response while validation errors occurs
     */
    public function getValidationsErrors($validation){
        $response['success'] = false;
        $response['error'] = true;
        $response['validation'] = false;
        $response['message'] = $validation['errors'];
        $response['delayTime'] = 5000;
        return $response;
    }

    /**
     * @param   : $message
     * @rresponse
     * @method  : getSuccessResponse
     * @purpose : Response on success
     */
    public function getSuccessResponse($response){
        $response['success']  = true;
        $response['error']    = false;
        $response['delayTime'] = 2000;
        return $response;
    }

    /**
     * @param   : $message
     * @rresponse
     * @method  : getErrorResponse
     * @purpose : Response on Error
     */
    public function getErrorResponse($message='Something went wrong. Try again later !'){
        $response['success'] = false;
        $response['error'] = true;
        $response['message'] = $message;
        $response['delayTime'] = 4000;
        return $response;
    }
}
