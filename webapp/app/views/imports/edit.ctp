<div class="Subdocuments form">
<?php echo $form->create('Import' , array( 'type' => 'post' ));?>
	<fieldset>
 		<legend><?php __('Edit Import');?></legend>
	<?php
		echo $form->hidden('_id');

		echo $form->input('Import.name');
		
		echo $form->label('Type');
		echo $form->select('Import.type', array('file' => 'file'));
		
		echo $form->label('Format');
		echo $form->select('Import.format', array('csv' => 'csv', 'serialized' => 'serialized', 'php' => 'php'));
		
		echo $this->Form->label('Project');
		echo $this->Form->select('Import.project', $filterData['projects']);
		
		echo $this->Form->label('Type');
		echo $this->Form->select('Import.type', $filterData['types']);
		
		echo $this->Form->label('Environment');
		echo $this->Form->select('Import.environment', $filterData['environments']);

		echo $this->Form->label('Bucket');
		echo $this->Form->select('Import.bucket', $filterData['buckets']);
		
		
		echo $form->input('Import.remote.host');
		echo $form->input('Import.remote.port');
		echo $form->input('Import.remote.user');
		echo $form->input('Import.remote.password');
		echo $form->input('Import.remote.path');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Subdocuments', true), array('action'=>'index'));?></li>
	</ul>
</div>


