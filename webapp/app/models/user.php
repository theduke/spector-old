<?php 

class User extends AppModel 
{
	public $name = 'User';
	public $useTable = 'users';
	
	var $mongoSchema = array(
	
			'username' => array('type'=>'string'),
	
			// options: "remote-file", "file"
			'password' => array('type'=>'string'),
	
	    'email' => array('type'=>'string'),
	    'alerts' => array()
		);
}