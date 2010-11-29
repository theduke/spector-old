<?php 

class Import extends AppModel 
{
	public $name = 'Import';
	
	const FORMAT_PHP = 'php';
	const FORMAT_CSV = 'csv';
	const FORMAT_SERIALIZED = 'serialized';
	
	const TYPE_FILE = 'file';
	const TYPE_REMOTE_FILE = 'remote-file';
	
	var $mongoSchema = array(
	
			'name' => array('type'=>'string'),
	
			// options: "remote-file", "file"
			'type' => array('type'=>'string'),
	
			// options: "csv", "serialized", "php"
			'format'=>array('type'=>'string'),

			// defaults
			'defaults' => array(
				'project' => array('type'=>'string'),
				'environment' => array('type'=>'string'),
				'type'=>array('type'=>'string'),
				'bucket'=>array('type'=>'string')
	     ),
			
			'remote' => array(
				'host' => array('type'=>'string'),
				'port' => array('type'=>'string'),
				'user' => array('type'=>'string'),
				'password' => array('type'=>'string'),
				'path' => array('type'=>'string')
			)
		);	

}