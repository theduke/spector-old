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
 
class TestController extends AppController
{
    function dbquery()
    {
    	$model = ClassRegistry::init('LogEntry');
    	
    	$time = new MongoDate();
    	$time->sec = 1291037510;
    	
    	$query = array(
    	  'conditions' => array('time' => array('$gt' => $time)),
    	  'limit' => 9999999999999999999999999999999999999999
    	);
    	
    	$result = $model->find('all', $query);
    	
    	var_dump(array(count($result), $result));
    	die();
    }
}