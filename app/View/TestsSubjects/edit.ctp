<div class="testsSubjects form">
<?php echo $this->Form->create('TestsSubject'); ?>
	<fieldset>
		<legend><?php echo __('Edit Tests Subject'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('test_id');
		echo $this->Form->input('subject_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TestsSubject.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('TestsSubject.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Tests Subjects'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Tests'), array('controller' => 'tests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Test'), array('controller' => 'tests', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Subjects'), array('controller' => 'subjects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subject'), array('controller' => 'subjects', 'action' => 'add')); ?> </li>
	</ul>
</div>
