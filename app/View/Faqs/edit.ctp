<div class="faqs form">
<?php echo $this->Form->create('Faq'); ?>
	<fieldset>
		<legend><?php echo __('Edit Faq'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('content');
		echo $this->Form->input('person_id');
		echo $this->Form->input('answer');
		echo $this->Form->input('status', array(
			'type' => 'select', 
			'options' => array('unanswered' => 'unanswered', 'answered' => 'answered', 'pending' => 'pending')));
		echo $this->Form->input('date_created');
		echo $this->Form->input('date_answered');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Faq.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Faq.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Faqs'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List People'), array('controller' => 'people', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Person'), array('controller' => 'people', 'action' => 'add')); ?> </li>
	</ul>
</div>

<script type="text/javascript">
	$('input').addClass('form-control');
</script>
