<?php
	include_once 'phonedrive.php';
	include_once 'EmailDrive.php';
	require_once('backgroundprocess.php');
	$keepgoing = true;
	while($keepgoing)
	{
		$dbc = mysqli_connect('localhost', 'root', 'Avancos1', 'Emails')
		or die("Could Not Contact Database in Driveit.php");
		$sql = 'Select * From email Where Status=0 AND company IS NOT NULL';
		$results = mysqli_query($dbc, $sql)
		or die("Could Not Query Database in Driveit.php ". mysqli_error($dbc));
		while($row = mysqli_fetch_array($results))
		{
			$email = findEmails($row['firstname'], $row['lastname'], $row['company']);
			if($email)
			{
				inputRecord($email, $row['emailID']);
			}
			$number = guessnumber($row['Company'], $row['City'], $row['State']);
			if($number)
			{
				inputPhoneRecord($number, $row['emailID']);
			}
			updateRecord($row['emailID']);
			sleep(1);
		}
		mysqli_close($dbc);
		sleep(60);
	}
	
	function inputRecord($email, $ID)
	{
		$dbc2 = mysqli_connect('localhost', 'root', 'Avancos1', 'Emails')
		or die("Could Not Contact Database in Driveit.php");
		$sql = "Update email SET estimatedemail='$email',status=1 WHERE emailID=$ID";
		mysqli_query($dbc2, $sql)
		or die("Could Not Query Database in Driveit.php ". mysqli_error($dbc));
		mysqli_close($dbc2);
	}
	
	function updateRecord($ID)
	{
		$dbc2 = mysqli_connect('localhost', 'root', 'Avancos1', 'Emails')
		or die("Could Not Contact Database in Driveit.php");
		$sql = "Update email SET status=1 WHERE emailID=$ID";
		mysqli_query($dbc2, $sql)
		or die("Could Not Query Database in Driveit.php ". mysqli_error($dbc));
		mysqli_close($dbc2);
	}
	
	function inputPhoneRecord($number, $ID)
	{
		$dbc2 = mysqli_connect('localhost', 'root', 'Avancos1', 'Emails')
		or die("Could Not Contact Database in Driveit.php");
		$sql = "Update email SET Number='$number',status=1 WHERE emailID=$ID";
		mysqli_query($dbc2, $sql)
		or die("Could Not Query Database in Driveit.php ". mysqli_error($dbc2));
		mysqli_close($dbc2);
	}
?>