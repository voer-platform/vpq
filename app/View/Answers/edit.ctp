<div class="answers form">
<?php echo $this->Form->create('Answer'); ?>
	<fieldset>
		<legend><?php echo __('Edit Answer'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('question_id');
		echo $this->Form->input('content');
		echo $this->Form->input('correctness');
		echo $this->Form->input('Score');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Answer.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Answer.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Answers'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Scores'), array('controller' => 'scores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Score'), array('controller' => 'scores', 'action' => 'add')); ?> </li>
	</ul>
</div>
