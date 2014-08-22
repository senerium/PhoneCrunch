<?php
//namespace Bc\BackgroundProcess;

class BackgroundProcess
{
	private $command;
	private $pid;

	public function __construct($command)
	{
		$this->command = $command;
	}

public function run($outputFile = '/dev/null')
    {
        $spid =  sprintf('%s > %s 2>&1 & echo $! | at',
            $this->command,
            $outputFile
        );
        $this->pid = shell_exec($spid);
    }

	public function isRunning()
	{
		try {
			$result = shell_exec(sprintf('ps %d', $this->pid));
			if(count(preg_split("/\n/", $result)) > 2) {
				return true;
			}
		} catch(Exception $e) {
		}

		return false;
	}

	public function getPid()
	{
		return $this->pid;
	}
}
?>