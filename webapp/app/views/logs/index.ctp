
<div class="filterbox">
<?php 


echo $this->Form->create(false, array());


echo '<div class="inline-block">';
echo $this->Form->label('Project');
echo $this->Form->select('project', $filterData['projects']);
echo '</div>';

echo '<div class="inline-block">';
echo $this->Form->label('Type');
echo $this->Form->select('type', $filterData['types']);
echo '</div>';

echo '<div class="inline-block">';
echo $this->Form->label('Severity');
echo $this->Form->select('severity', $filterData['severities']);
echo '</div>';

echo '<div class="inline-block">';
echo $this->Form->label('Environment');
echo $this->Form->select('environment', $filterData['environments']);
echo '</div>';

echo '<div class="inline-block">';
echo $this->Form->label('Bucket');
echo $this->Form->select('buck', $filterData['buckets']);
echo '</div>';

echo '<div class="inline-block">';
echo $this->Form->label('Results');
echo $this->Form->select('pagesize', array(20 => 20, 40 => 40, 60 => 60, 100 => 100, 'all' => 'all'), 20);
echo '</div>';

echo '<div class="inline-block">' . $this->Form->end('Update') . '</div>';
?>
</div>

<table class="log-table">
	<tr> 
		<th><?php echo $paginator->sort('Severity', 'severity'); ?></th> 
		<th><?php echo $paginator->sort('Time', 'time'); ?></th> 
		<th><?php echo $paginator->sort('Message', 'message'); ?></th> 
	</tr> 
	   <?php foreach($logEntries as $entry): ?> 
	<tr> 
		<td><?php echo $entry['LogEntry']['severity']; ?> </td> 
		<td><?php echo date('Y-m-d H:i:s', $entry['LogEntry']['time']->sec); ?> </td>
		<td><?php echo $html->link($entry['LogEntry']['message'],'show/'.$entry['LogEntry']['_id']); ?> </td>  
	</tr> 
	<?php endforeach; ?> 
</table>

<!-- Shows the page numbers -->
<!-- Shows the next and previous links -->
<?php
	echo $paginator->prev('« Previous ', null, null, array('class' => 'disabled'));
	echo $paginator->numbers(); 
	echo $paginator->next(' Next »', null, null, array('class' => 'disabled'));
	
?> 
<!-- prints X of Y, where X is current page and Y is number of pages -->
