<?php

class LogsController extends AppController
{
	public $name = 'Logs';
	public $uses = array('LogEntry');
	
	public $paginate = array(
		'LogEntry' => array(
			'conditions' => array('project' => 'test'),
			'limit' => 20,        
			'order' => array(            
				'LogEntry.time' => 'desc')
	));
	
	public function index()
	{
		$this->buildFilterFormData();
		$this->buildPaginate();
		
		//$entries = $this->LogEntry->find('all', $params);
		$entries = $this->paginate('LogEntry');
		
		if (!$entries) $entries = array();

		$this->set('logEntries', $entries);
		$this->set('filterData', $this->buildFilterFormData());
		$this->set('params', $this->params);
	}
	
	protected function buildPaginate()
	{
		$pageSize = isset($this->data['pagesize']) ? $this->data['pagesize'] : 20;
		if ($pageSize === 'all') $pageSize = 100000000000000;
		$this->paginate['LogEntry']['limit'] = $pageSize;
		
		if (isset($this->data['project']) && ($project = $this->data['project']))
		{
			$this->paginate['LogEntry']['conditions']['project'] = $project;
		}
		if (isset($this->data['type']) && ($type = $this->data['type']))
		{
			$this->paginate['LogEntry']['conditions']['type'] = $type;
		}
		if (isset($this->data['environment']) && ($environment = $this->data['environment']))
		{
			$this->paginate['LogEntry']['conditions']['environment'] = $environment;
		}
		if (isset($this->data['buck']) && ($bucket = $this->data['buck']))
		{
			$this->paginate['LogEntry']['conditions']['bucket'] = $bucket;
		}
	}
	
	protected function buildFilterFormData()
	{
		$db = ConnectionManager::getDataSource('default')->getDb();
		
		$projects = $db->command(array('distinct' => 'LogEntry', 'key' => 'project'));
		$projects = $projects['values'];
		if (count($projects)) $projects = array_combine($projects, $projects);
			
		
		$project = isset($this->data['project']) ? $this->data['project'] : null;
		
		if ($project)
		{
			$types = $db->command(array('distinct' => 'LogEntry', 'key' => 'type', 'query' => array('project' => $project)));
			$types = $types['values'];
			if (count($types)) $types = array_combine($types, $types);
			
			$environments = $db->command(array('distinct' => 'LogEntry', 'key' => 'environment', 'query' => array('project' => $project)));
			$environments = $environments['values'];
			if (count($environments)) $environments = array_combine($environments, $environments);
			
			$buckets = $db->command(array('distinct' => 'LogEntry', 'key' => 'bucket', 'query' => array('project' => $project)));
			$buckets = $buckets['values'];
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