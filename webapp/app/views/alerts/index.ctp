
<?php echo $html->link('Add Alert', 'add'); ?>
<br>
<br>
<?php foreach($results as $result): ?>
	<div>
	  <b><?= $result['Alert']['name']?></b>
	  [<?php echo $html->link('edit','edit/'.$result['Alert']['_id']); ?>] [<?php echo $html->link('delete','delete/'.$result['Alert']['_id']); ?>]
	</div>
<?php endforeach; ?>

