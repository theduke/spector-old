<?php 

class Import extends AppModel 
{
	public $name = 'Import';
	
	const FORMAT_PHP = 'php';
	const FORMAT_CSV = 'csv';
	const FORMAT_SERIALIZED = 'serialized';
	
	var $mongoSchema = array(
	
			'name' => array('type'=>'string'),
	
			// options: "file"
			'type' => array('type'=>'string'),
	
			// options: "csv", "serialized", "php"
			'format'=>array('type'=>'string'),

			// defaults
			'project' => array('type'=>'string'),
			'environment' => array('type'=>'string'),
			'type'=>array('type'=>'string'),
			'bucket'=>array('type'=>'string'),
			
			'remote' => array(
				'host' => array('type'=>'string'),
				'port' => array('type'=>'string'),
				'user' => array('type'=>'string'),
				'password' => array('type'=>'string'),
				'path' => array('type'=>'string')
			));	

}