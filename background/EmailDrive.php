<?php
	function findEmails($fname, $lname, $company)
	{
		require_once 'guessEmail.php';
		require_once 'DoWork.php';
		$domain = findDomain($company);
		return acceptedDomain($domain) ? toofr($fname, $lname, $domain) : '';
	}
	
	function excludeList()
	{
		return "-site:linkedin.com+-site:youtube.com" .
			"-site:freedictionary.com+-site:facebook.com+-site:wikipedia.org+-site:gimpsy.com".
			"+-site:imdb.com";
	}
	
	function acceptedDomain($domain)
	{
		$dbc = mysqli_connect('localhost', 'root', 'Avancos1', 'Companies')
			or die('Cannot Connect to Database ' . mysqli_error($dbc));
			$sql = "Select * From BadDomains Where Domain Like '$domain' ";
			$sql = mysqli_real_escape_string($dbc, $sql);
			$results = mysqli_query($dbc, $sql);
			while($row = mysqli_fetch_array($results))
			{
				return false;
			}
			mysqli_close($dbc);
			return true;
	}
?>