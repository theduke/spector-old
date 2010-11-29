<div class="Subdocuments form">
<?php echo $form->create('Import' , array( 'type' => 'post' ));?>
	<fieldset>
 		<legend><?php __('Edit Import');?></legend>
	<?php
		echo $form->hidden('_id');

		echo $form->input('Import.name');
    
    echo $form->label('Type');
    echo $form->select('Import.type', array('remote-file' => 'remote-file', 'file' => 'file'));
    
    echo $form->label('Format');
    echo $form->select('Import.format', array('csv' => 'csv', 'serialized' => 'serialized', 'php' => 'php'));
    
    echo $form->input('Import.defaults.project');
    echo $form->input('Import.defaults.type');
    echo $form->input('Import.defaults.environment');
    echo $form->input('Import.defaults.bucket');

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


