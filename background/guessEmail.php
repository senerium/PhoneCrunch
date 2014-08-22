<?php
	function toofr($fname, $lname, $domain)
	{
		//$domain = substr($domain, 1);
		//$firstName = "joe";
		//$lastName = "Burgess";
		$url = "http://toofr.com/api/make?key=dadde3c0699e4f3200a4e6ee31e4bcfe" .
			"&domain=$domain&first=$fname&last=$lname";
		$result = file_get_contents($url);
		$json_response = json_decode($result, true);
		$email = $json_response['response']['email'];
		return $email;
	}
?>