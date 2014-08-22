<?php
	require_once 'constants.php';
	include_once 'includes/_header/header.php';
	if(isset($_POST['submitImport']))
	{
		if(isset($_FILES['xlsfile']))
		{
			require_once ABS_PATH . '/Classes/PHPExcel.php';
			$filename = $_FILES['xlsfile']['name'];
			$destination = ABS_PATH . '/upload/' . $filename;
			$filemoved = move_uploaded_file($_FILES['xlsfile']['tmp_name'], $destination);
			$objPHPReader = ('xlsx' == end(explode('.', $filename))) ? loadSheet($filename) : loadxls($filename);
			$sheet = $objPHPReader->getSheet(0);
			$x=1;
			$keepgoing = true;
			while ($keepgoing)
			{
				$a1 = $sheet->getCell('A' . $x)->getValue();
				if(strtolower('First Name') == strtolower($a1))
				{
					$rowDatastart = $x;
					$keepgoing = false;
				}
				$x++;
			}
			while('' != $sheet->getCell('A' . $x)->getValue())
			{
				try
				{
					$dbc = mysqli_connect(SQL_SERVER, SQL_USER, SQL_Password, SQL_DB)
					or die("Could Not Contact Database in Import.php");
					$fname = mysqli_real_escape_string($dbc, $sheet->getCell('A' . $x)->getValue());
					$lname = mysqli_real_escape_string($dbc, $sheet->getCell('B' . $x)->getValue());
					$company = mysqli_real_escape_string($dbc, $sheet->getCell('F' . $x)->getValue());
					$external = mysqli_real_escape_string($dbc, $sheet->getCell('P'. $x)->getValue());
					$city = mysqli_real_escape_string($dbc, $sheet->getCell('C'. $x)->getValue());
					$state = mysqli_real_escape_string($dbc, $sheet->getCell('D'. $x)->getValue());
					$sql = "Insert into email (firstname, lastname, company, city, state, externalkey) " .
							"Values ('$fname', '$lname', '$company', '$city', '$state', '$external')";
					mysqli_query($dbc, $sql)
					or die("Could not Insert to Database in import.php " . mysqli_error($dbc));
					mysqli_close($dbc);
				} catch(Exception $e)
				{
					echo $e->getMessage();
				}
				$x++;
			}
			?>
			<p id="goodfile" class="success">File Successfully Uploaded</p>
			<a href="index.php">Return to the Main Page</a>
			<?php 
		}
		else
		{
			?>
			<p id="badfile" class="error">No Valid File Submitted</p>
			<a href="index.php">Return to the Main Page</a>
			<?php 
		}
	}
	include_once 'includes/_footer/footer.php';
	
	function loadSheet($filename)
	{
		//require_once ABS_PATH . 'Classes/PHPExcel.php';
		$data = new PHPExcel_Reader_Excel2007();
		$data->setLoadAllSheets(true);
		$objPHPExcelReader = $data->load(ABS_PATH . '/upload/' . $filename);
		return $objPHPExcelReader;
	}
	
	function loadxls($filename)
	{
		//require_once ABS_PATH . 'Classes/PHPExcel.php';
		$data = new PHPExcel_Reader_Excel5();
		$data->setLoadAllSheets(true);
		$objPHPExcelReader = ($filename == '' ? '' : $data->load(dirname(__FILE__) . '/upload/' . $filename));
		return $objPHPExcelReader;
	}