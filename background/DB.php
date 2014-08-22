<?php

	Define('MYSQL_USER', 'root');
	Define('MYSQL_SERVER', 'localhost');
	Define('MYSQL_PASS', 'Avancos1');
	Define('MYSQL_COMPANY', 'Companies');
	
	function getdbc()
	{
		return mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_COMPANY);
	}
	
	function checkDB($company)
	{
		//Returns Company's Domain false otherwise.
		$Record = getDBInfo($company);
		//$today = date('Y-m-d h:m:s', strtotime('today'));
		//$Record['Date_Created'] = '2011-04-08 13:55:14';
		//$bob = $today - $Record['Date_Created'];
		return ((date('Y-m-d h:m:s', strtotime('today')) - $Record['Date_Created']) > 1 ? false : $Record['Domain']);
	}
	
	function addToDB($company, $domain)
	{
	//if Company info Exists Tests if Information is current
		$exists = getDBInfo($company);
		$myDBC = getdbc();
		$company = mysqli_real_escape_string($myDBC, $company);
		if ($exists)
		{
			if ($exists['Domain'] == $domain)
			{
				$query= "Update Company Set Date_Created = Now() " .
				"Where Company_Name Like '$company'";
			}
			else
			{
				//update Change Domain to new Domain
				$query = "Update Company set Company_Domain = '$domain' " .
				"Where Company_Name Like '$company'";
			}
		}
		else
		{
			$query = "Insert INTO Company (Company_Name, Company_Domain) " .
			"Values ('$company', '$domain')";
		}
		
		
		//$query = mysqli_real_escape_string($myDBC, $query);
		$company = $company;
		mysqli_query($myDBC, $query)
			or die();
		mysql_close($myDBC);
	}
	
	function getDBInfo($company)
	{
		//returns Array if Company Exists False otherwise
		$myDBC = getdbc()
			or die('Could not Connect to DB ' . mysqli_error($myDBC));
		$company = mysqli_real_escape_string($myDBC, $company);
		$query = "Select Company_Name, Company_Domain, Date_Created From Company Where " .
				"Company_Name Like '$company'";
		//$query = mysqli_real_escape_string($myDBC, $query);
		$results = mysqli_query($myDBC, $query)
			or die('Could not Select from DB ' . mysqli_error($myDBC));
		while($row = mysqli_fetch_array($results))
		{
			$foundArray = Array(
					'Domain' => $row['Company_Domain'], 
					'Company_Name' => $row['Company_Name'],
					'Date_Created' => $row['Date_Created']);
		}
		return $foundArray ? $foundArray : false;
	}
?>