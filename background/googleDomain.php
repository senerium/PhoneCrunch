<?php
	function googleDomain($company)
	{
		require_once 'google-api-php-client/src/Google_Client.php';
		require_once 'google-api-php-client/src/contrib/Google_CustomsearchService.php';
		require_once 'DB.php';
		require_once 'linkCleanUp.php';
		
		session_start();
		
		$company = str_replace(" ", "+", $company);
		//$company = $company . "-site:linkedin.com+-site:youtube.com" .
		//	"-site:freedictionary.com+-site:facebook.com+-site:wikipedia.org+-site:gimpsy.com";
		/**
		$dbc = mysqli_connect('localhost', 'root', 'Avancos1', 'Companies')
			or die('Cannot Connect to Database ' . mysqli_error($dbc));
		$sql = "Select * From BadDomains";
		$results = mysqli_query($dbc, $sql);
		While($row = mysqli_fetch_Array($results)
		{
			$company = $ company. "+-site:" . $row['domain'];
		}
		mysqli_close($dbc);
		 */
		$client = new Google_Client();
		$client->setApplicationName('Avancos-Global');
		$client->setDeveloperKey('AIzaSyCwnEGzz26suMeVRt3Rod15gKAQsAAIxvU');
		$search = new Google_CustomsearchService($client);
		$answer = $search->cse->listCse($company, array('cx' => '015959586263014972910:gfesnqnhewg'));
		
		if (isset($_GET['code']))
		{
			$client->authenticate();
			$_SESSION['token'] = $client->getAccessToken();
			$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
		}
		
		if (isset($_SESSION['token']))
		{
			$client->setAccessToken($_SESSION['token']);
		}
		
		if ($client->getAccessToken())
		{
			$activities = $search->activites->listActivites('me', 'public');
			print 'Your Activites: <pre>' . print_r($activites, true) . '</pre>';
		
			$_SESSION['token'] = $client->getAccessToken();
		}
		else
		{
			$authUrl = $client->createAuthUrl();
		}
		
		//$domain = cleanLink($answer['items'][0]['displayLink']);
		foreach($answer['items'] as $thing)
		{
			$check = cleanLink($thing['displayLink']);	
			$dbc = mysqli_connect('localhost', 'root', 'Avancos1', 'Companies')
				or die('Cannot Connect to Database ' . mysqli_error($dbc));
			$sql = "Select * From BadDomains Where Domain Like '" . $check . "'";
			$results = mysqli_query($dbc, $sql);
			$good = TRUE;
			While($row = mysqli_fetch_Array($results))
			{
				$good = false;                    
			}
			mysqli_close($dbc);
			if($good)
			{
				$good = true;
				$domain = $check;
				break;
			}
		}
		if($domain)
		{
			$company = str_replace('+', ' ', $company);
			$company = explode("-", $company);
			$company = $company[0];
			$domain ? addToDB($company, $domain) : false;
			return $domain;
		}
	}
?>