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
 
class AlertShell extends Shell
{
	protected $alertModel;
	protected $logEntry;
	
	
	function startup() 
	{
		App::import('Component', 'Email');
		$this->alertModel = ClassRegistry::init('Alert');
		$this->logEntry = ClassRegistry::init('LogEntry');
	}
	
  public function main()
  {
    $alerts = $this->alertModel->find('all', array('limit' => 999999999999999));
    
    foreach ($alerts as $al)
    {
    	$al = $al['Alert'];

	    switch ($al['method'])
	    {
	      case Alert::METHOD_EMAIL:
	        $this->processAlertEmail($al);
	        break;
	    }
	  }
  }
  
  protected function processAlertEmail($alert)
  {
  	// first check time constraints
  	$now = time();
  	
  	if ($alert['time_constraint'] && isset($alert['last_sent']) && $alert['last_sent'])
  	{
  		if ($alert['last_sent'] + $alert['time_constraint'] > $now)
  		{
  			// we are within time constraint, so skip this alert
  			return false;
  		}
  	}
    // select all relevant entries
  	$query = $this->buildQuery($alert);
  	
  	$result = $this->logEntry->find('all', $query);
  	
  	// if no log entries found return
  	if (!$result) return 0;
  	
  	$entries = $this->structureEntries($result);
  	$this->sendMail($alert, $entries);
  }
  
  protected function buildQuery($alert)
  {
  	$query = array(
  	  'conditions' => array(),
  	  'limit' => 99999999999999999
  	);
  	
  	if (isset($alert['last_sent']) && ($last = $alert['last_sent']))
  	{
  		$query['conditions']['time'] = array('$gt' => $last->sec);
  	}
  	
  	$filters = $alert['filters'];
  	
  	if ($filters['minimum_severity'])
  	{
  		$query['conditions']['severity'] = array('$in' => LogEntry::getSeverities($filters['minimum_severity']));
  	}
  	unset ($filters['minimum_severity']);
  	
  	foreach ($filters as $field => $value)
  	{
  		if ($value) $query['conditions'][$field] = $value;
  	}
  	
  	return $query;
  }
  
  protected function structureEntries($entries)
  {
  	$structured = array();
  	
  	foreach ($entries as $entry)
  	{
  		$entry = $entry['LogEntry'];
  		
  		$project = $entry['project'] ? $entry['project'] : 'No Project';
  		$severity = $entry['severity'] ? $entry['severity'] : LogEntry::OTHER;

  		if (!isset($structured[$project])) $structured[$project] = array();
  		if (!isset($structured[$project][$severity])) $structured[$project][$severity] = array();
  		
  		$structured[$project][$severity][] = $entry;
  	}
  	
  	return $structured;
  }
  
  protected function sendMail($alert, $entries)
  {
  	static $email;
  	if (!$email)
  	{
  		$email = new EmailComponent();
  	}
  	$body = $this->renderBody($entries);
  	
  	$email->from = 'Spector <noreply@spector.com>';
  	$email->to = '<' . $alert['target'] . '>';
  	$email->subject = 'Spector: ' .  $alert['name'];
  	$flag = $email->send($body);
  	
  	$email->reset();
  }
  
  protected function renderBody($entries)
  {
  	$body = 'Log entries grouped by project and severity:' . PHP_EOL ;
  	
  	foreach ($entries as $project => $severities)
  	{
  		$body .= 'Project: ' . $project . PHP_EOL . PHP_EOL;
  		
  		foreach ($severities as $severity => $items)
  		{
        $body .= '  Severity: ' . $severity . PHP_EOL . PHP_EOL;

        foreach ($items as $item)
        {
        	$date = date('Y-m-d H:i:s', $item['time']->sec) . ': ';
        	$bucket = $item['bucket'] ? "(Bucket: {$item['bucket']})" : '';
        	$env = $item['environment'] ? "(Env: {$item['environment']})" : '';
        	
        	$body .= '    ' . $env . $bucket . $date . $item['message'] . PHP_EOL;
        }
        $body .= PHP_EOL . PHP_EOL;
  		}
  		$body .= PHP_EOL . PHP_EOL;
  	}
  	
  	return $body;
  }
}

