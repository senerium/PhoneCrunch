<?php

	//Define('MYSQL_USER', 'root');
	//Define('MYSQL_SERVER', 'localhost');
	//Define('MYSQL_PASS', 'Avancos1');
	//Define('MYSQL_COMPANY', 'Companies');
	
	function getdbcphone()
	{
		return mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_COMPANY);
	}
	
	function checkDBPhone($company)
	{
		$Record = getDBInfo($company);
		return ((date('Y-m-d h:m:s', strtotime('today')) - $Record['Date_Created']) > 1 ? false : $Record['Phone']);
	}
	
	function addToDBPhone($company, $phone, $city, $state)
	{
		$exists = getDBPhoneInfo($company);
		$myDBC = getdbcphone();
		$company = mysqli_real_escape_string($myDBC, $company);
		$city = mysqli_real_escape_string($myDBC, $city);
		$state = mysqli_real_escape_string($myDBC, $state);
		if ($exists)
		{
			if ($exists['Phone'] == $phone)
			{
				$query= "Update Company Set Date_Created = Now() " .
				"Where Company_Name Like '$company'";
			}
			else
			{
				//update Change Domain to new Domain
				$query = "Update Company set Phone = '$phone' " .
				"Where Company_Name Like '$company'";
			}
		}
		else
		{
			$query = "Insert INTO Company (Company_Name, Phone, City, State) " .
			"Values ('$company', '$phone', '$city', '$state')";
		}
		
		//$query = mysqli_real_escape_string($myDBC, $query);
		$company = $company;
		mysqli_query($myDBC, $query)
			or die();
		mysql_close($myDBC);
	}
	
	function getDBPhoneInfo($company)
	{
		//returns Array if Company Exists False otherwise
		$myDBC = getdbcphone()
			or die('Could not Connect to DB ' . mysqli_error($myDBC));
		$company = mysqli_real_escape_string($myDBC, $company);
		$query = "Select * From Company Where " .
				"Company_Name Like '$company'";
		//$query = mysqli_real_escape_string($myDBC, $query);
		$results = mysqli_query($myDBC, $query)
			or die('Could not Select from DB ' . mysqli_error($myDBC));
		while($row = mysqli_fetch_array($results))
		{
			$foundArray = Array(
					'Number' => $row['Phone'], 
					'Company' => $row['Company_Name'],
					'Date_Created' => $row['Date_Created']);
		}
		return $foundArray ? $foundArray : false;
	}
?>