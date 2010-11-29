<?php

class ImportHandlerShell extends Shell
{
	public function main()
	{
		App::import('Lib', 'ImportTask');
		
		$task = new ImportTask();
		$task->run();
	}
}