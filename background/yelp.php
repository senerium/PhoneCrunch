<?php
	function yelpnumber($company, $city, $state)
	{
		require_once './oauth.php';
		
		$auth = new OAuthToken('qQaHHZ1q1cXWlR-SWbpLbbbO_1LMLG9x', 'jBMBT-fCzkicanb46Pqm-IWrXRs');
		$url = "http://api.yelp.com/v2/business/" . $company . '-' . $city;
		
		$consumer = new OAuthConsumer('eC_X-WDYZUPYUg_O1WmE-w', '4YN8znT0q4noAKMlnhaT-kuiBDA');
		$signature_method = new OAuthSignatureMethod_HMAC_SHA1();
		$oauthrequest = OAuthRequest::from_consumer_and_token($consumer, $auth,
				'GET', $url);
		$oauthrequest->sign_request($signature_method, $consumer, $auth);
		$signed_url = $oauthrequest->to_url();
		
		$ch = curl_init($signed_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$data = curl_exec($ch);
		curl_close($ch);
		
		$response = json_decode($data);
		
		return $response->display_phone;
	}