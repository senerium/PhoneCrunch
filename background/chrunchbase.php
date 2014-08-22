<?php 
	require_once 'DB.php';
	require_once 'linkCleanUp.php';
	
	function crunchBase($company)
	{
		$company = str_replace(" ", "+", $company);
		$url="http://api.crunchbase.com/v/1/company/$company.js?" . 
		"api_key=7rxpnwv5y2g4eb7r2arhgrgx";
		$result = file_get_contents($url);
		$json_response = json_decode($result, true);
		$website = $json_response['homepage_url'];
		$domain = cleanLink($website);
		$company = str_replace('+', ' ', $company);
		$domain ? addToDB($company, $domain) : false;
		return $domain;
	}
?>