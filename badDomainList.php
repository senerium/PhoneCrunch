<?php 
	include_once 'constants.php';
	if(isset($_POST['submit']))
	{
		$dbc = mysqli_connect('localhost', 'root', 'Avancos1', 'Companies')
			or die('Cannot Connect to Database ' . mysqli_error($dbc));
		$sql = 'INSERT INTO BadDomains(Domain) VALUES ("' . $_POST['domain'] . '")';
		mysqli_query($dbc, $sql);
		mysqli_close($dbc);
	}
	$remove = $_GET['domain'];
	if(!empty($remove))
	{
		$dbc = mysqli_connect('localhost', 'root', 'Avancos1', 'Companies')
			or die('Cannot Connect to Database ' . mysqli_error($dbc));
		$sql = "Delete From BadDomains Where Domain='$remove'";
		mysqli_query($dbc, $sql);
		mysqli_close($dbc);
	}
	require_once ABS_PATH . '/includes/_header/header.php';
?><div name="badDomain" class="badDomain" id="badDomain">
		<table>
			<tr>
				<th>Domain</th>
				<th>Deactivate</th>
			</tr>
		<?php 
			$dbc = mysqli_connect('localhost', 'root', 'Avancos1', 'Companies')
			or die('Cannot Connect to Database ' . mysqli_error($dbc));
			$sql = "Select * From BadDomains";
			$results = mysqli_query($dbc, $sql);
			while($row = mysqli_fetch_array($results))
			{
				echo "<tr>\n" .
						"<td>" . $row['Domain'] . "</td>\n" .
						'<td><a href="' . $_SERVER['PHP_SELF'] . '?domain=' .
						$row['Domain'] . '">REMOVE</a></td>' . "\n";
				echo "</tr>";
			}
			mysqli_close($dbc);
		?>
		</table>
		<br>
		<br>
		Add a domain to the list.
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<Label for="domian">Domain: </Label>
			<input type="text" name="domain"><br />
			<input type="submit" name="submit" value="Submit">
		</form>
	</div>
		<?php 
	include_once 'includes/_footer/footer.php';