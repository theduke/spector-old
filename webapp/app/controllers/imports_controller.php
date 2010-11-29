<?php

class ImportsController extends AppController
{
	public $name = 'Imports';
	public $uses = array('Import', 'LogEntry');
	
//	public $paginate = array(
//		'LogEntry' => array(
//			'conditions' => array('project' => 'test'),
//			'limit' => 20,        
//			'order' => array(            
//				'LogEntry.time' => 'desc')
//	));
	
	public function index() {
		$params = array(
			'order' => array('_id' => -1),
			'limit' => 20,
			'page' => 1,
		);
		
		$results = $this->Import->find('all', $params);
		if (!$results) $results = array();
		
		$this->set(compact('results'));
	}

	public function add() {
		if (!empty($this->data)) {
			$this->Import->create();
			if ($this->Import->save($this->data)) {
				$this->flash(__('Import saved.', true), array('action' => 'index'));
			} else {
			}
		}
		
		$this->set('filterData', LogEntry::buildFilterFormData($this->data));
	}

	public function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Import', true), array('action' => 'index'));
		}
		if (!empty($this->data)) {

			if ($this->Import->save($this->data)) {
				$this->flash(__('The Import has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Import->read(null, $id);
		}
		
		$project = isset($this->data['Import']['project']) ? $this->data['Import']['project'] : null;
		$this->set('filterData', LogEntry::buildFilterFormData($project));
	}

	public function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Import', true), array('action' => 'index'));
		}
		if ($this->Import->delete($id)) {
			$this->flash(__('Import deleted', true), array('action' => 'index'));
		} else {
			$this->flash(__('Import deleted Fail', true), array('action' => 'index'));
		}
	}		
}