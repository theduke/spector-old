<?php

class ImportTask
{
	const SERIALIZE_SEPERATOR = '-|-|-|-|-|-|-|-|-|-|-|-|-';
	
	public function run()
	{
		App::import('Model', 'LogEntry');
		$importModel = ClassRegistry::init('Import');
				
		$imports = $importModel->find('all', array('limit' => 10000000000000));
		
		foreach ($imports as $import)
		{
			$this->doImport($import['Import']);
			
			echo "Import " . $import['Import']['name'] . ' finished.';
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
			case Import::FORMAT_SERIALIZED:
				$this->importLogSerialized($data, $import);
				break;
			default:
				throw new Exception("Unknown import format: {$import['format']}");
		}
	}
	
	protected function importLogSerialized($fileContent, $import) 
	{
		$entries = explode(self::SERIALIZE_SEPERATOR, $fileContent);

		foreach ($entries as $rawEntry) 
		{
			if (!strlen($rawEntry)) continue;
			
			$rawEntry = unserialize($rawEntry);

			if ($rawEntry === false)
			{
				continue;
				/** @todo add logging */
			}
			
			$entry = new LogEntry();
			
			$origTime = $rawEntry['time'];
			
			$time = new MongoDate();
      $time->sec = $origTime->getTimestamp();
			
			$entry->set(array(
        'message' => $rawEntry['message'],
        'time' => $time,
        'severity' => $rawEntry['severity'],
        'data'     => $rawEntry['data'],
			
        'project' => $rawEntry['project'],
        'type' => $rawEntry['type'],
        'environment' => $rawEntry['environment'],
        'bucket' => $rawEntry['bucket']
      ));
      
      $flag = $entry->save();
		}
	}
	
	protected function importLogPHP($fileContent, $import)
	{
		$messages = explode(PHP_EOL, $fileContent);
		$defaults = $import['defaults'];
		
		$lines = count($messages);
		
		if (!$lines) continue;
		
		$entry = null;
		$stackTrace = '';
		
		for ($i=0; $i < $lines; $i++)
		{
			$message = $messages[$i];
			
			$pattern = '/\[(.*?)\]\sPHP (.*?)\:\s+(.*)/';
			$matches = array();
			
			preg_match($pattern, $message, $matches);
			
			if (count($matches) !== 4)
			{
				if (is_string($message)) $stackTrace .= $message;
				
				// set stack and persist if we are at end of file
				if ($i === $lines - 1 && $entry)
				{
					$entry->set(array('data' => $stackTrace));
					$entry->save();
				}
			} else 
			{
				// save previous entry
				if ($entry)
				{
					$entry->set(array('data' => $stackTrace));
					$entry->save();
				}
				
				// create new entry
				$entry = new LogEntry();
				
				$severity = $this->mapPhpType($matches[2]);
			
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
			}
		}
	}
	
	protected function mapPhpType($type)
	{
		$severity = null;
		
		switch ($type)
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
		
		return $severity;
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