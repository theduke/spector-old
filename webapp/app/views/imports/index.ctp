
<?php echo $html->link('Add Import', 'add'); ?>
<br>
<br>
<?php foreach($results as $result): ?>
	<div>
	  <b><?= $result['Import']['name']?></b>
	  [<?php echo $html->link('edit','edit/'.$result['Import']['_id']); ?>] [<?php echo $html->link('delete','delete/'.$result['Import']['_id']); ?>]
	</div>
<?php endforeach; ?>

