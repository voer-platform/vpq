<div class="testsQuestions form">
<?php echo $this->Form->create('TestsQuestion'); ?>
	<fieldset>
		<legend><?php echo __('Edit Tests Question'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('test_id');
		echo $this->Form->input('question_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TestsQuestion.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('TestsQuestion.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Tests Questions'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Tests'), array('controller' => 'tests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Test'), array('controller' => 'tests', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
