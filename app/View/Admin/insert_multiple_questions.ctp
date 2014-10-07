<!-- nav -->
<?php echo $this->element('admin-left-nav'); ?>

<div class='col-lg-10'>
	<?php echo $this->Form->create('MultipleQuestion', array('type' => 'file')); ?>
		<?php echo $this->Form->input('file', array('label' => __('File contains questions'), 'type' => 'file') ); ?>
		<?php echo $this->Form->input('content', array('type' => 'textarea') ); ?>
	<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-primary btn-md' )); ?>
</div>

<?php echo $this->TinyMCE->editor('advanced'); ?>