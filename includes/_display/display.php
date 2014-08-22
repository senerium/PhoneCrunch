<?php 
	$dbc = mysqli_connect(SQL_SERVER, SQL_USER, SQL_Password, SQL_DB)
		or die("Could Not Contact Database in Display.php");
	$sql = "Select * From email";
	$results = mysqli_query($dbc, $sql)
		or die("Could Not Query Database in Display.php ". mysqli_error($dbc));
?>
<div id="displaytable" class="displaytable">
	<table class="sortable">
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>City</th>
			<th>State</th>
			<th>Company</th>
			<th>Phone</th>
			<th>EstimatedEmail</th>
			<th>Status</th>
			<th>Key</th>
		</tr>
		<?php 
			while($row = mysqli_fetch_array($results))
			{
				echo "<tr>\n";
				echo "<td>" . $row['firstname'] . "</td>\n";
				echo "<td>" . $row['lastname'] . "</td>\n";
				echo "<td>" . $row['city'] . "</td>\n";
				echo "<td>" . $row['state'] . "</td>\n";
				echo "<td>" . $row['company'] . "</td>\n";
				echo "<td>" . $row['number'] . "</td>\n";
				echo "<td>" . $row['estimatedemail'] . "</td>\n";
				echo "<td>" . ($row['status'] ? 'Guessed' : 'Haven\'t Guessed Yet') . "</td>\n";
				echo "<td>" . $row['externalkey'] . "</td>\n"; 
				echo "</tr>\n";
			}
			mysqli_close($dbc);
		?>
	</table>
</div>