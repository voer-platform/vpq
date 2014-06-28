<div class="progresses form">
<?php echo $this->Form->create('Progress'); ?>
	<fieldset>
		<legend><?php echo __('Edit Progress'); ?></legend>
	<?php
		echo $this->Form->input('person_id');
		echo $this->Form->input('sub_category_id');
		echo $this->Form->input('progress');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Progress.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Progress.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Progresses'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List People'), array('controller' => 'people', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Person'), array('controller' => 'people', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sub Categories'), array('controller' => 'sub_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sub Category'), array('controller' => 'sub_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
