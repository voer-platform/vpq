<div class="people form">
<?php echo $this->Form->create('Person'); ?>
	<fieldset>
		<legend><?php echo __('Edit Person'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('password');
		echo $this->Form->input('grade', 'type' => 'select', 
			'options' => array('10' => '10', '11' => '11', '12' => '12')));
		echo $this->Form->input('date_created');
		echo $this->Form->input('role', array(
			'type' => 'select', 
			'options' => array('admin' => 'admin', 'user' => 'user', 'editor' => 'editor')));
		echo $this->Form->input('facebook');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Person.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Person.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List People'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Progresses'), array('controller' => 'progresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Progress'), array('controller' => 'progresses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Scores'), array('controller' => 'scores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Score'), array('controller' => 'scores', 'action' => 'add')); ?> </li>
	</ul>
</div>

<script type="text/javascript">
	$('input').addClass('form-control');	
</script>
