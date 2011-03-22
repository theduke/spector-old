<?php

use Spector\Import;

class ImportTask
{
	const SERIALIZE_SEPERATOR = '-|-|-|-|-|-|-|-|-|-|-|-|-';
	
	protected $_importModel;
	
	/**
	 * Enter description here ...
	 * 
	 * @var Spector\Import\Importer
	 */
	protected $_importer;
	
	public function run()
	{
		$this->_importer = new Import\Importer();
		
		App::import('Model', 'LogEntry');
		$importModel = $this->_importModel = ClassRegistry::init('Import');
				
		$imports = $importModel->find('all', array('limit' => 10000000000000));
		
		foreach ($imports as $import)
		{
			$this->doImport($import['Import']);
			
			echo "Import " . $import['Import']['name'] . ' finished.';
		}
	}
	
	protected function doImport($data)
	{
		$model = $this->_import;
		$model->read(null, $data['_id']);
		
		$import = $model->toImport();
		
		$this->_importer->doImport($import);
	}
	
}