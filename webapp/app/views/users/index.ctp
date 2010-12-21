
<?php echo $html->link('Add User', 'add'); ?>
<br>
<br>
<?php foreach($results as $result): ?>
	<div>
	  <b><?= $result['User']['username']?></b>
	  [<?php echo $html->link('edit','edit/'.$result['User']['_id']); ?>] [<?php echo $html->link('delete','delete/'.$result['User']['_id']); ?>]
	</div>
<?php endforeach; ?>

