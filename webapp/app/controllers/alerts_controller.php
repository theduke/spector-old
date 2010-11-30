<?php

class AlertsController extends AppController
{
	public $name = 'Alerts';
	public $uses = array('Alert');
	
	public function index()
	{
		$results = $this->Alert->find('all');
    if (!$results) $results = array();
    
    $this->set(compact('results'));
	}
	
	public function add() {
		if (!empty($this->data)) {
			$this->Alert->create();
			if ($this->Alert->save($this->data)) {
				$this->flash(__('Alert saved.', true), array('action' => 'index'));
			} else {
			}
		}
	}

	public function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Alert', true), array('action' => 'index'));
		}
		if (!empty($this->data)) {

			if ($this->Alert->save($this->data)) {
				$this->flash(__('The Alert has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Alert->read(null, $id);
		}
	}

	public function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Alert', true), array('action' => 'index'));
		}
		if ($this->Alert->delete($id)) {
			$this->flash(__('Alert deleted', true), array('action' => 'index'));
		} else {
			$this->flash(__('Alert deleted Fail', true), array('action' => 'index'));
		}
	}
}