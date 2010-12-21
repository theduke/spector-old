<?php

class LogsController extends AppController
{
	public $name = 'Logs';
	public $uses = array('LogEntry');
	
	public $paginate = array(
		'LogEntry' => array(
			'conditions' => array(),
			'limit' => 20,        
			'order' => array(            
				'LogEntry.time' => 'desc')
	));
	
	public function index()
	{
		$this->buildPaginate();
		
		//$entries = $this->LogEntry->find('all', $params);
		$entries = $this->paginate('LogEntry');
		
		if (!$entries) $entries = array();

		$this->set('logEntries', $entries);
		
		$project = isset($this->data['project']) ? $this->data['project'] : null;
		$this->set('filterData', LogEntry::buildFilterFormData($project));
		$this->set('params', $this->params);
	}
	
	public function show($id=null)
	{
		if (!$id) return;
		
		$entry = $this->LogEntry->read(null, $id);
    if (!$entry) return;
		
    $this->set('entry', $entry['LogEntry']);
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
	  if (isset($this->data['severity']) && ($severity = $this->data['severity']))
    {
      $this->paginate['LogEntry']['conditions']['severity'] = $severity;
    }
	}
	
	
}