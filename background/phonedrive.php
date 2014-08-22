<?php
	function guessnumber($company, $city, $state)
	{
		//require_once 'googleDomain.php';
		require_once 'yelp.php';
		require_once 'DBphone.php';
		require_once 'googlephone.php';
		//$number = getDBPhoneInfo($company);
		//$number = $number['Number'];
		//$addtoDBPhone = ($number ? false : true);
		$number = ($number ? $number : yelpnumber($company, $city, $state));
		$number = ($number ? $number : googlenumber($company, $city, $state));
		//if($addtoDBPhone)
		//{
		//	addToDBPhone($company, $number, $city, $state);
		//}
		return ($number ? $number : false);
	}