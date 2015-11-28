<?php

$zuser = $_GET['uname'];
$zapi = $_GET['api'];
$zdom = $_GET['subdomain'];

$zurl = "https://".$zdom.".zendesk.com/api/v2";


function curlWrap($url, $json, $action){
	global $zuser, $zapi, $zurl;

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	//TRUE to follow any "Location: " header that the server sends as part of the HTTP header
	
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
	//The maximum amount of HTTP redirections to follow

	curl_setopt($ch, CURLOPT_URL, $zurl.$url);
	//The URL to fetch

	curl_setopt($ch, CURLOPT_USERPWD, $zuser."/token:".$zapi);
	//A username and password formatted as "[username]:[password]" to use for the connection. 

	switch($action){
		case "POST":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			//A custom request method to use instead of "GET" or "HEAD" when doing a HTTP request.

			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			//The full data to post in a HTTP "POST" operation. To post a file, prepend a filename with @ and use the full path. The filetype can be explicitly specified by following the filename with the type in the format ';type=mimetype'. 

			break;
		
		case "GET":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			break;
		
		case "PUT":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			break;
		
		case "DELETE":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			break;
		
		default:
			break;
	}
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 40);

	$output = curl_exec($ch);
	curl_close($ch);	
	return $output;
}

$ticketdata = curlWrap("/tickets.json", null, "GET");
$tickets = json_decode($ticketdata,true);
$tickets = $tickets['tickets'];
$numbtickets = count($tickets);

echo "<h4>Total number of tickets : $numbtickets<br><br></h4>";

foreach ($tickets as $key) {
	$subjectT = $key['subject'];
	$descriptionT = $key['description'];
	echo "<h4>Subject = <strong>$subjectT</strong></h4><p>$descriptionT<br><br><br></p>";
}

?>