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
		
	}
}