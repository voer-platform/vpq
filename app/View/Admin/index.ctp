<div class='admin index'>
	<!-- visible form -->
	<?php echo $this->Form->create('Admin'); ?>
		<?php echo $this->Form->input('content', array('type' => 'textarea', 'id' => 'my_editor')); ?>
	<?php echo $this->Form->end(array('title' => __('Submit'), 'class' => 'btn btn-primary btn-sm')); ?>

	<!-- upload image form -->
	<iframe id="file_form_target" name="form_target"></iframe>
	<?php echo $this->Form->create('file', array( 'url' => array('controller' => 'Admin', 'action' => 'uploadFile'), 'id' => 'file_form', 'target' => 'file_form_target', 'enctype' => 'multipart/form-data') ); ?>
		<?php echo $this->Form->input('image', array('type' => 'file', 'onchange' => '$(\'#file_form\').submit();this.value=\'\';')); ?>
	<?php echo $this->Form->end(); ?>
</div>

<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>
	tinymce.init({
		selector:'textarea',
		plugins: ["image"],
	    file_browser_callback: function(field_name, url, type, win) {
	        if(type=='image') $('#file_form input').click();
	    }
	});
</script>

<style type="text/css">
	#file_form{
		width:0px;
		height:0; 
		overflow:hidden;
	}
	#file_form_target {
		display: none;
	}
</style>