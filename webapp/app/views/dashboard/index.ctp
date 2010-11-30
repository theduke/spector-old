<?php 

foreach ($logData as $severity => $entries)
{
	if (!count($entries)) continue;
	
	echo '<div><h3>' . $severity . '</h3>';
	
	foreach ($entries as $entry)
	{
		$entry = $entry['LogEntry'];

		$project = $entry['project'] ? 'Project: ' . $entry['project'] . ' |' : '';
		$bucket = $entry['bucket'] ? 'Bucket: ' . $entry['bucket'] . ' |'  : '';
		$env = $entry['environment'] ? 'Env: ' . $entry['environment'] . ' |'  : '';
		$type = $entry['type'] ? 'Type: ' . $entry['type'] : '';
		$date = date('Y-m-d H:i:s', $entry['time']->sec);
		$message = $entry['message'];
		
		echo "<div class=\"logentry logentry-$severity\">$project $bucket $env $type<br />$date: $message";
	}
	
	echo '</div>';
}