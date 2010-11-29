<?php 

class LogEntry extends AppModel 
{
	
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
		$db = ConnectionManager::getDataSource('default')->getDb();
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
			$types = $environments = $buckets = array('values' => array());
		}
		
		
		$data = array(
		  'projects' => $projects,
		  'environments' => $environments,
		  'types' => $types,
		  'buckets' => $buckets
		);
		
		return $data;		
	}
}