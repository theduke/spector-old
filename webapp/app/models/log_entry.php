<?php 

class LogEntry extends AppModel 
{
	
	const EMERGENCY = 'EMERGENCY';
  const CRITICAL = 'CRITICAL';
  const ERROR = 'ERROR';
  const WARNING = 'WARNING';
  const NOTICE = 'NOTICE';
  const INFO = 'INFO';
  const DEBUG = 'DEBUG';
  const OTHER = 'OTHER';
	
	public $name = 'LogEntry';
//	public $actAs = array('Schemaless');
	
	//var $useDbConfig = 'mongo';
	var $mongoSchema = array(
			'project' => array('type'=>'string'),
			'environment'=>array('type'=>'string'),
			'type' => array('type'=>'string'),
			'bucket'=>array('type'=>'string'),
			'severity'=>array('type'=>'string'),
			'message'=>array('type'=>'string'),
			'data'=>array('type'=>'string'),
			'time'=>array('type'=>'date'),
			);	
	
			
	public static function getDb()
	{
		$source = ConnectionManager::getDataSource('default');
		if (!$source->isConnected()) $source->connect();
		
		$db = $source->getDb();
		
		return $db;
	}
	
	public static function getCollection()
	{
		self::getDb()->LogEntry;
	}
	
	public static function getDistinct($field, $query=array())
	{
		$db = self::getDb();
		
		$result = $db->command(array('distinct' => 'log_entries', 'key' => $field, 'query' => $query));
		$result = $result['values'];
		
		return $result;
	}
	
	public static function getSeverities($minimum = null)
	{
		$severities = array(
       'EMERGENCY',
       'CRITICAL',
       'ERROR',
       'WARNING',
       'NOTICE',
       'INFO',
       'DEBUG',
       'OTHER'
    );
    
    if ($minimum)
    {
    	$minimum = strtoupper($minimum);
    	
    	$severities = array_reverse($severities);
    	
    	$i = 0;
    	foreach ($severities as $sev)
    	{
    		if ($sev === $minimum)
    		{
    			$severities = array_splice($severities, $i);
    		}
    		++$i;
    	}
    }
    
    return $severities;
	}
	
	public static function buildFilterFormData($project=null)
	{
		$db = ConnectionManager::getDataSource('default')->getDb();
		
		$projects = LogEntry::getDistinct('project');
		if (count($projects)) $projects = array_combine($projects, $projects);
		
		if ($project)
		{
			$types = LogEntry::getDistinct('type', array('project' => $project));
			if (count($types)) $types = array_combine($types, $types);
			
			$environments = LogEntry::getDistinct('environment', array('project' => $project));
			if (count($environments)) $environments = array_combine($environments, $environments);
			
			$buckets = LogEntry::getDistinct('bucket', array('project' => $project));
			if (count($buckets)) $buckets = array_combine($buckets, $buckets);
			
		} else {
			$types = $environments = $buckets = array();
		}
		
		$severities = array(
		   'EMERGENCY',
		   'CRITICAL',
		   'ERROR',
		   'WARNING',
		   'NOTICE',
		   'INFO',
		   'DEBUG',
		   'OTHER'
		);
		
		$severities = array_combine($severities, $severities);
		
		$data = array(
		  'projects' => $projects,
		  'environments' => $environments,
		  'types' => $types,
		  'buckets' => $buckets,
		  'severities' => $severities
		);
		
		return $data;		
	}
}