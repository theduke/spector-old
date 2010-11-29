<?php

class ImportTask
{
	public function run()
	{
		App::import('Model', 'LogEntry');
		$importModel = ClassRegistry::init('Import');
				
		$imports = $importModel->find('all', array('limit' => 10000000000000));
		
		foreach ($imports as $import)
		{
			$this->doImport($import['Import']);
		}
	}
	
	protected function doImport($import)
	{
		$remote = $import['remote'];
	 
		$data = null;
		
		switch ($import['type'])
		{
			case Import::TYPE_FILE:
				$data = $this->getFileData($remote['path']);
				break;
			case Import::TYPE_REMOTE_FILE:
				$data = $this->getRemoteFile($remote['host'], $remote['port'], $remote['user'], $remote['password'], $remote['path']);
				break;
		}
		
		switch ($import['format'])
		{
			case Import::FORMAT_PHP:
				$this->importLogPHP($data, $import);
				break;
		}
	}
	
	protected function importLogPHP($fileContent, $import)
	{
		$messages = explode(PHP_EOL, $fileContent);
		$defaults = $import['defaults'];
		
		foreach ($messages as $message)
		{
			$pattern = '/\[(.*?)\]\sPHP (.*?)\:\s+(.*)/';
			$matches = array();
			
			preg_match($pattern, $message, $matches);
			
			if (count($matches) !== 4) continue;
			
			switch ($matches[2])
			{
				case 'Warning':
				case 'Notice':
					$severity = 'WARNING';
					break;
				case 'Fatal error':
				case 'Parse error':
					$severity = 'ERROR';
					break;
				case 'Strict Standards':
				case 'Deprecated':
					$severity = 'DEBUG';
					break;
				default:
					$matches[3] = $matches[2]. ': ' . $matches[3];
					$severity = 'OTHER';
					break;
			}
			
			$entry = new LogEntry();
			
			$time = new MongoDate();
			$time->sec = strtotime($matches[1]);
			
			$entry->set(array(
				'message' => $matches[3],
				'time' => $time,
				'severity' => $severity,
			
				'project' => $defaults['project'],
				'type' => 'php',
				'environment' => $defaults['environment'],
				'bucket' => $defaults['bucket']
			));
			
			$flag = $entry->save();
		}
	}
	
	protected function getFileData($path)
	{
		$data = file_get_contents($path);
		
		if ($data === false) throw new Exception('Could not read file: ' . $path);
		
    // delete data
    file_put_contents($path, '');
    
    return $data;
	}
	
	protected function getRemoteFile($host, $port, $user, $password, $path)
	{
		$handle = ssh2_connect($host, (float)$port);
		
		if (!$handle) 
			throw new Exception("Could not connect to server $host on port $port");
		
		if (!ssh2_auth_password($handle, $user, $password))
			throw new Exception("Could not login. Invalid ahtentication details.");
			
		$localPath = '/tmp/spector';
		if (!is_dir($localPath))
		{
			$flag = mkdir($localPath, 0777, true);
			if (!$flag) throw new Exception("Tmp directory $localPath does not exist and could not be created.");
		}
		
		$localPath .= basename($path);
		
		$flag = ssh2_scp_recv($handle, $path, $localPath);
		
		if (!$flag) throw new Exception("Could not copy file from $host:$path to $localPath");
		
		$content = file_get_contents($localPath);
		
		file_put_contents($localPath, '');
		
		ssh2_scp_send($handle, $localPath, $path, 0777);
		
		return $content;
	}
}