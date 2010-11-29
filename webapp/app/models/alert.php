<?php 

class LogEntry extends AppModel 
{
	
	public $name = 'LogEntry';
//	public $actAs = array('Schemaless');
	
	//var $useDbConfig = 'mongo';
	var $mongoSchema = array(
			'project' => array('type'=>'string'),
			'environment'=>array('type'=>'string'),
			'type'=>array('type'=>'string'),
			'bucket'=>array('type'=>'string'),
			'severity'=>array('type'=>'string'),
			'message'=>array('type'=>'string'),
			'data'=>array('type'=>'string'),
			'time'=>array('type'=>'date'),
			);	

}