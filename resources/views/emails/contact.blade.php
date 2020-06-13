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
						<td style="padding: 8px 15px;" width="50%">Name</td><td style="padding: 8px 15px;">{{$data['name']}}</td>
					</tr>
					<tr>
						<td style="padding: 8px 15px;">Email</td><td style="padding: 8px 15px;">{{$data['email']}}</td>
					</tr>
					<tr>
						<td style="padding: 8px 15px;">Phone</td><td style="padding: 8px 15px;">{{$data['phone']}}</td>
					</tr>
					<tr>
						<td style="padding: 8px 15px;">Subject</td><td style="padding: 8px 15px;">{{$data['subject']}}</td>
					</tr>
					<tr>
						<td style="padding: 8px 15px;">Feedback</td><td style="padding: 8px 15px;">{{$data['feedback']}}</td>
					</tr>
				</table>
				<h5 style="font-family: sans-serif; background: #ffc107; margin: 0;  padding: 10px; font-weight: 600;">Be On Time</h5>
			</div>
	</center>
	</div>
</body>
</html>