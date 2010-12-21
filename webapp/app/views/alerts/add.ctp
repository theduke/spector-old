<div class="alerts form">
<?php echo $form->create('Alert' , array( 'type' => 'post' ));?>
	<fieldset>
 		<legend><?php __('Add Alert');?></legend>
	<?php
	  echo $form->input('Alert.name');
	
	  echo $form->label('Method');
    echo $form->select('Alert.method', array('mail' => 'mail', 'sms' => 'sms'));
    
    echo $form->label('Time Constraint');
    echo $form->select('Alert.time_constraint',
      array(
        0 => '0 Seconds', 
        30 => '30 Seconds',
        60 => '1 Minute',
        5*60 => '5 Minutes',
        10*60 => '10 Minutes',
        30*60 => '30 Minutes',
        60*60 => '1 hour',
        2*60*60 => '2 hours',
        6*60*60 => '6 hours',
        12*60*60 => '12 hours',
        24*60*60 => '1 day',
        3*24*60*60 => '3 days',
        7*24*60*60 => '1 week'
      ));
	
		echo $form->input('Alert.target');
		
		echo "<h2>Filters</h2>";
    
		echo $form->input('Alert.filters.project');
		echo $form->input('Alert.filters.type');
		echo $form->input('Alert.filters.environment');
		echo $form->input('Alert.filters.bucket');
		echo $form->input('Alert.filters.severity');
		echo $form->input('Alert.filters.minimum_severity');
		
		echo $form->input('Alert.filters.message');

	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Alerts', true), array('action'=>'index'));?></li>
	</ul>
</div>


