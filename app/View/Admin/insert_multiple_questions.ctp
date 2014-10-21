<!-- nav -->
<?php echo $this->element('admin-left-nav'); ?>

<div class='col-lg-10'>
	<legend><?php echo __('Add multiple questions') ?></legend>

	<?php echo $this->Form->create('Import', array('type' => 'file')); ?>
		<?php echo $this->Form->input('file', array('label' => __('Zip file contains questions'), 'type' => 'file', 'class' => 'form-control') ); ?>
	<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-primary btn-md' )); ?>

	<h3><?php echo __('Info'); ?></h3>
	<?php echo __('Import a pre-formatted zip file contains'); ?>
	<ol>
		<li><?php echo __('Text file contains question text'); ?></li>
		<li><?php echo __('Attachment files for each questions'); ?></li>
	</ol>
	<h3><?php echo __('Format for zip file'); ?></h3>
	<?php echo __('Zip file should follow this format').': '; ?><?php echo $this->Html->link('Demo data', '..'.DS.'demo'.DS.'pls-data.zip', array('fullBase' => true)); ?>	
</div>