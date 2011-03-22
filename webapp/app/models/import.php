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
	
			// options: "remote-file", "file", "drupal" 
			'fetcher' => array('type'=>'string'),
	
			// options: "csv", "serialized", "php"
			'handler'=>array('type'=>'string'),
	
			'deleteSource'=>array('type'=>'boolean'),
			
			'lastImportIdentifier'=>array('type'=>'string'),
			
			'defaultProject' => array('type'=>'string'),
			'defaultEnvironment' => array('type'=>'string'),
			'defaultType'=>array('type'=>'string'),
			'defaultBucket'=>array('type'=>'string'),
			
			'remote' => array(
				'host' => array('type'=>'string'),
				'port' => array('type'=>'string'),
				'username' => array('type'=>'string'),
				'password' => array('type'=>'string'),
				'resourcePath' => array('type'=>'string')
			)
		);
		
		public function fromImport(\Spector\Import\Import $import)
		{
			$this->set($import->toArray());
		}
		
		public function toArray()
		{
			$a = array();
			
			foreach ($this->mongoSchema as $field => $value)
			{
				$a[$field] = $this->field($field);
			}
			
			return $a;
		}
		
		public function toImport()
		{
			$i = new \Spector\Import\Import();
			$i->fromArray($this->toArray());
			
			return $i;
		}
}