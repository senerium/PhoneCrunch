<?php
	function googlenumber($company)
	{
		require_once 'google-api-php-client/src/Google_Client.php';
		require_once 'google-api-php-client/src/contrib/Google_CustomsearchService.php';
		require_once 'DB.php';
		require_once 'linkCleanUp.php';
		
		session_start();
		
		$company = str_replace(" ", "+", $company);
		$company = $company . "+contact";
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
		
		foreach($answer['items'] as $thing)
		{
			$check = $thing['link'];
			$ch = curl_init($check);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			$data = curl_exec($ch);
			curl_close($ch);
			$response = explode("\n", $data);
			foreach ($response as $code)
			{
				$regex = '/[(]{0,1}[0-9]{3}[)]{0,1}[-,., ]{1}[0-9]{3}[-,., ]{1}[0-9]{4}/';
				$found = preg_match($regex, $code, $match);
				if($found)
				{
					$number = $match[0];
					$number = str_replace('(', '', $number);
					$number = str_replace(')', '', $number);
					$number = str_replace(' ', '-', $number);
					$number = str_replace('.', '-', $number);
					return $number;
				}
			}
		}
	}
?>