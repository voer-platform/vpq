<div class="newsletters form">
<?php echo $this->Form->create('Newsletter'); ?>
	<fieldset>
		<legend><?php echo __('Add Newsletter'); ?></legend>
	<?php
		echo $this->Form->input('newsletter_category_id');
		echo $this->Form->input('title');
		echo $this->Form->input('content');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Newsletters'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Newsletter Categories'), array('controller' => 'newsletter_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Newsletter Category'), array('controller' => 'newsletter_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
