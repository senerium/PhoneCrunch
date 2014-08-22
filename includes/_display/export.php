<div class="divexport" id="divexport">
	<button name="btnexport" id="btnexport" onClick='location.href="?btnexport=1"'>Export</button><br />
	<button name="btndelete" id="btndelete" onClick='location.href="?btndelete=1"'>Delete</button>
</div>
<?php
	if($_GET['btnexport'])
	{
		require_once ABS_PATH . '/Classes/PHPExcel.php';
		$OBJPHPExcel = new PHPExcel();
		$Sheet1 = $OBJPHPExcel->getSheet(0);
		$Sheet1->setCellValue('A1', 'First Name');
		$Sheet1->setCellValue('B1', 'Last Name');
		$Sheet1->setCellValue('C1', 'City');
		$Sheet1->setCellValue('D1', 'State');
		$Sheet1->setCellValue('E1', 'Company');
		$Sheet1->setCellValue('F1', 'Estimated Phone');
		$Sheet1->setCellValue('G1', 'Estimated Email');
		$Sheet1->setCellValue('H1', 'Status');
		$Sheet1->setCellValue('I1', 'Key');
		$x = 2;
		$dbc = mysqli_connect(SQL_SERVER, SQL_USER, SQL_Password, SQL_DB)
			or die("Could Not Contact Database in Export.php");
		$sql = 'Select * FROM email';
		$results = mysqli_query($dbc, $sql)
			or die("Could Not Query Database in Export.php ". mysqli_error($dbc));
		while($row = mysqli_fetch_array($results))
		{
			$Sheet1->setCellValue('A' . $x, legitstart($row['firstname']));
			$Sheet1->setCellValue('B' . $x, legitstart($row['lastname']));
			$Sheet1->setCellValue('C' . $x, legitstart($row['city']));
			$Sheet1->setCellValue('D' . $x, legitstart($row['state']));
			$Sheet1->setCellValue('E' . $x, legitstart($row['company']));
			$Sheet1->setCellValue('F' . $x, legitstart($row['number']));
			$Sheet1->setCellValue('G' . $x, legitstart($row['estimatedemail']));
			$Sheet1->setCellValue('H' . $x, legitstart($row['status']));
			$Sheet1->setCellValue('I' . $x, legitstart($row['externalkey']));
			$x++;
		}
		mysqli_close($dbc);
		$filename = 'Export.xlsx';
		$write = new PHPExcel_Writer_Excel2007($OBJPHPExcel);
		$write->save(ABS_PATH . '/download/' . $filename);?>
		<div class="exportedlink" id="exportedlink">
			<a id="exported" href="./download/<?php echo $filename;?>">Here is the File</a><br />
		</div>
		<?php
	}
	else if($_GET['btndelete'])
	{
		$dbc = mysqli_connect(SQL_SERVER, SQL_USER, SQL_Password, SQL_DB)
			or die("Could Not Contact Database in Export.php");
		$sql = 'DELETE from email';
		mysqli_query($dbc, $sql)
			or die("Could Not Query Database in Export.php ". mysqli_error($dbc));
		mysqli_close($dbc);
	}
	
	function legitstart($string)
	{
		$returned = (substr($string, 0, 1) == '=' ? substr($string, 1) : $string);
		return $returned;
	}