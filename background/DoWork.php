<?php
	function findDomain($company)
	{		
		require_once 'chrunchbase.php';
		require_once 'googleDomain.php';
		require_once 'DB.php';
		require_once 'guessEmail.php';
		
		//$company = 'Accenture';
		$found = checkDB($company);
		//$found =  ($found ? $found : crunchBase($company));
		$found =  ($found ? $found : googleDomain($company));
		return $found;
	}
?>