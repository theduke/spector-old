<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Christoph Herzog <christoph.herzog@theduke.at>
 * @copyright Crevo
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 */
 
class UsersController extends AppController
{
    var $name = 'Users';
 
    /**
     *  The AuthComponent provides the needed functionality
     *  for login, so you can leave this function blank.
     */
    function login() {
    }

    function logout() {
        $this->redirect($this->Auth->logout());
    }
    
    public function index() {
	    $params = array(
	      'order' => array('_id' => -1),
	      'limit' => 20,
	      'page' => 1,
	    );
	    
	    $results = $this->User->find('all', $params);
	    if (!$results) $results = array();
	    
	    $this->set(compact('results'));
	  }
    
    function add() {
	    if ($this->data) {
	        if ($this->data['User']['password'] == $this->Auth->password($this->data['User']['password_confirm'])) {
	            $this->User->create();
	            $this->User->save($this->data);
	            
	            $this->flash("User created.", array('action' => 'index', 'controller' => 'dashbaord'));
	        }
	    }
    }
    
  public function edit($id = null) {
    if (!$id && empty($this->data)) {
      $this->flash(__('Invalid User', true), array('action' => 'index'));
    }
    if (!empty($this->data)) {
	      if ($this->data['User']['password'] == $this->Auth->password($this->data['User']['password_confirm'])) {
	    	  if ($this->User->save($this->data)) {
	        $this->flash(__('The User has been saved.', true), array('action' => 'index'));
	      } else {
	      }
    	 }
    }
    if (empty($this->data)) {
      $this->data = $this->User->read(null, $id);
    }
  }
  
  public function delete($id = null) {
    if (!$id) {
      $this->flash(__('Invalid User', true), array('action' => 'index'));
    }
    if ($this->User->delete($id)) {
      $this->flash(__('User deleted', true), array('action' => 'index'));
    } else {
      $this->flash(__('User deleted Fail', true), array('action' => 'index'));
    }
  }
}