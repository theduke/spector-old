<?php

class DashboardController extends AppController
{
	public $name = 'Dashboard';
	public $uses = array('LogEntry');
	
//	public $paginate = array(
//		'LogEntry' => array(
//			'conditions' => array('project' => 'test'),
//			'limit' => 20,        
//			'order' => array(            
//				'LogEntry.time' => 'desc')
//	));
	
	public function index() 
	{
		$this->set('logData', $this->getLogData());
	}
	
	protected function getLogData()
	{
		$data = array();
		
		foreach (array(LogEntry::EMERGENCY, LogEntry::CRITICAL, LogEntry::ERROR) as $sev)
		{
			$params = array(
			  'conditions' => array('severity' => $sev),
			  'limit' => 5,
			  'order' => array(            
          'time' => 'desc')
			);
			
			$entries = $this->LogEntry->find('all', $params);
			
			$data[$sev] = $entries ? $entries : array();
		}
		
		return $data;
	}
}