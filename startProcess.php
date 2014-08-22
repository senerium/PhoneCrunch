<?php 
	require_once 'constants.php';
	include_once 'includes/_header/header.php';
	require_once ABS_PATH . '/background/backgroundprocess.php';
	$process = new BackgroundProcess('php -f ' . ABS_PATH . '/background/driveit.php');
	$running = shell_exec('ps | grep "php"');
	if(isset($_GET['btnprocessstart']))
	{
		$process->run();
		$running = shell_exec('ps | grep "php"');
		if($running)
		{
			echo "The process is Now Running.<br />";
		}
	}
	else if($running)
	{
		echo "The process is Now Running.<br />";
	}
	else
	{
		?>
		<button name="btnprocessstart" id="btnprocessstart" onClick='location.href="?btnprocessstart=1"'>Start Process</button>
		<?php 
	}
	include_once 'includes/_footer/footer.php';