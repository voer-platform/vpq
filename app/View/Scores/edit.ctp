<div class="scores form">
<?php echo $this->Form->create('Score'); ?>
	<fieldset>
		<legend><?php echo __('Edit Score'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('test_id');
		echo $this->Form->input('person_id');
		echo $this->Form->input('score');
		echo $this->Form->input('duration');
		echo $this->Form->input('time_taken');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Score.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Score.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Scores'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Tests'), array('controller' => 'tests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Test'), array('controller' => 'tests', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List People'), array('controller' => 'people', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Person'), array('controller' => 'people', 'action' => 'add')); ?> </li>
	</ul>
</div>
