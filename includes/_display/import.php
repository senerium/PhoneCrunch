<form class="importForm" id="importForm" enctype="multipart/form-data" method="post" action="<?php echo "verify.php";//$_SERVER['PHP_SELF'];?>">
	<label id="lblinsertfile" for="xlsfile">Insert File:</label>
	<input type="file" id="xlsfile" name="xlsfile"><br>
	<input type="submit" name="submitImport" id="inpimportsubmit" value="Submit">
</form>