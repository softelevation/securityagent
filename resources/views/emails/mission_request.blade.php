<!DOCTYPE html>
<html>
<head>
	<title>Be On Time</title>
	<style type="text/css">
		.table{
			width: 100%; 
			border: solid 1px #ccc; 
			border-collapse: collapse;
			font-family: sans-serif;
		}
		.table td{
			padding: 8px 15px;
		}
	</style>
</head>
<body>
	<div style="width: 100%; text-align: center;">
		<center>
			<div style="width: 500px;">
				<h4 style="font-family: sans-serif; background: #ffc107; margin: 0; text-transform: uppercase; padding: 11px; font-weight: 600;">Contact Form Details</h4>
				<table style="width: 100%; border: solid 1px #ccc; border-collapse: collapse; font-family: sans-serif;" border="1">
					<tr>
						<td style="padding: 8px 15px;">{{__('dashboard.customer_name')}}</td><td style="padding: 8px 15px;">{{$data['customer_name']}}</td>
					</tr>
					<tr>
						<td style="padding: 8px 15px;" width="50%">{{__('frontend.mission_request.request_title_object')}}</td><td style="padding: 8px 15px;">{{$data['title']}}</td>
					</tr>
					<tr>
						<td style="padding: 8px 15px;">{{__('frontend.mission_request.request_location')}}</td><td style="padding: 8px 15px;">{{$data['location']}}</td>
					</tr>
					<tr>
						<td style="padding: 8px 15px;">{{__('frontend.mission_request.request_description')}}</td><td style="padding: 8px 15px;">{{$data['description']}}</td>
					</tr>
					<tr>
						<td style="padding: 8px 15px;">{{__('dashboard.agents.type')}}</td><td style="padding: 8px 15px;">{{$data['agent_type']}}</td>
					</tr>
					<tr>
						<td style="padding: 8px 15px;">{{__('dashboard.mission.hours_req')}}</td><td style="padding: 8px 15px;">{{$data['total_hours']}}</td>
					</tr>
					<tr>
						<td style="padding: 8px 15px;">{{__('frontend.mission_request.how_many_agents')}}</td><td style="padding: 8px 15px;">{{$data['agent_count']}}</td>
					</tr>
					<tr>
						<td style="padding: 8px 15px;">{{__('dashboard.mission.from_when_start')}}</td><td style="padding: 8px 15px;">{{ ($data['quick_book']) ? __('dashboard.now') : __('dashboard.mission.later') }}</td>
					</tr>
					<tr>
						<td style="padding: 8px 15px;">{{__('frontend.mission_request.mission_date')}}</td><td style="padding: 8px 15px;">{{$data['start_date_time']}}</td>
					</tr>
					<tr>
						<td style="padding: 8px 15px;">{{__('dashboard.mission.agent_vehicle')}}</td><td style="padding: 8px 15px;">{{ ($data['vehicle_required'] == '1') ? __('dashboard.yes') : ($data['vehicle_required'] == '2') ? __('dashboard.no') : __('dashboard.mission.not_matter') }}</td>
					</tr>
				</table>
				<h5 style="font-family: sans-serif; background: #ffc107; margin: 0;  padding: 10px; font-weight: 600;">Be On Time</h5>
			</div>
	</center>
	</div>
</body>
</html>