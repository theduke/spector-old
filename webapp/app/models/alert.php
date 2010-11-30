<?php 

class Alert extends AppModel 
{
	
	public $name = 'Alert';
	
	const METHOD_EMAIL = 'mail';
	const METHOD_SMS = 'sms';
	const METHOD_TWITTER = 'twitter';
	
	const STYLE_STRUCTURED = 'structured';
	
	//var $useDbConfig = 'mongo';
	var $mongoSchema = array(
	
	    'user' => array('type'=>'string'),
	    'method' => array('type'=>'string'),
	    'style' => array('type'=>'string'),
	    'target' => array('type'=>'string'),

	     'filters' => array(
	        'project' => array('type'=>'string'),
		      'environment'=>array('type'=>'string'),
		      'type'=>array('type'=>'string'),
		      'bucket'=>array('type'=>'string'),
		      'severity'=>array('type'=>'string'),
	        'minimum_severity'=>array('type'=>'string'),
	        'message' => array('type'=>'string')
	     ),
		
			'name'=>array('type'=>'string'),
	     
	     // how many seconds should we wait before re-sending this alert?
			'time_constraint' => array('type'=>'string'),
			'last_sent' => array('type'=>'date'),
	);
}


