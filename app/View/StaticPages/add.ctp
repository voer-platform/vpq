<div class="staticPages form">
<?php echo $this->Form->create('StaticPage'); ?>
	<fieldset>
		<legend><?php echo __('Add Static Page'); ?></legend>
	<?php
		echo $this->Form->input('name', array('type' => 'text', 'class' => 'form-control'));
		echo $this->Form->input('content', array('type' => 'textarea', 'class' => 'edit-tinymce'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Static Pages'), array('action' => 'index')); ?></li>
	</ul>
</div>

<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script type="text/javascript">
	tinymce.init({
		mode : "specific_textareas",
		editor_selector:'edit-tinymce',
		height: 400,
		plugins: 'code',
	});
</script>