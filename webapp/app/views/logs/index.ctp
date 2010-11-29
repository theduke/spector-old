<?php

echo $this->Form->create(false, array());

echo $this->Form->label('Project');
echo $this->Form->select('project', $filterData['projects']);

echo $this->Form->label('Type');
echo $this->Form->select('type', $filterData['types']);

echo $this->Form->label('Environment');
echo $this->Form->select('environment', $filterData['environments']);

echo $this->Form->label('Bucket');
echo $this->Form->select('buck', $filterData['buckets']);

echo $this->Form->label('Results');
echo $this->Form->select('pagesize', array(20 => 20, 40 => 40, 60 => 60, 100 => 100, 'all' => 'all'), 20);

echo $this->Form->end('Update');

?>

<table>
	<tr> 
		<th><?php echo $paginator->sort('Severity', 'severity'); ?></th> 
		<th><?php echo $paginator->sort('Time', 'time'); ?></th> 
		<th><?php echo $paginator->sort('Message', 'message'); ?></th> 
	</tr> 
	   <?php foreach($logEntries as $entry): ?> 
	<tr> 
		<td><?php echo $entry['LogEntry']['severity']; ?> </td> 
		<td><?php echo date('Y-m-d H:i:s', $entry['LogEntry']['time']->sec); ?> </td>
		<td><?php echo $entry['LogEntry']['message']; ?> </td>  
	</tr> 
	<?php endforeach; ?> 
</table>

<!-- Shows the page numbers -->
<?php echo $paginator->numbers(); ?>
<!-- Shows the next and previous links -->
<?php
	echo $paginator->prev('« Previous ', null, null, array('class' => 'disabled'));
	echo $paginator->next(' Next »', null, null, array('class' => 'disabled'));
?> 
<!-- prints X of Y, where X is current page and Y is number of pages -->
<?php echo $paginator->counter(); ?>