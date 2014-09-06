<div class='admin-insert-questions container'>
	<!-- left nav -->
	<div class='col-lg-2'>
		<ul class="nav nav-pills nav-stacked">
			<li class='active'><?php echo $this->Html->link(__('Add Questions'), array('controller' => 'Admin', 'action' => 'insertQuestions')); ?></li>
			<li><?php echo $this->Html->link(__('Add Subcategories'), array('controller' => 'Admin', 'action' => 'insertQuestions')); ?></li>
			<li><?php echo $this->Html->link(__('Add Categories'), array('controller' => 'Admin', 'action' => 'insertQuestions')); ?></li>
			<li><?php echo $this->Html->link(__('Add Subjects'), array('controller' => 'Admin', 'action' => 'insertQuestions')); ?></li>
		</ul>
	</div>

	<!-- right nav -->
	<div class='col-lg-10'>
		<!-- visible form -->
		<?php echo $this->Form->create('Admin'); ?>
			<?php echo $this->Form->input(__('Content of questions'), array('type' => 'textarea', 'id' => 'my_editor')); ?>
		<?php echo $this->Form->end(array('title' => __('Submit'), 'class' => 'btn btn-primary btn-sm')); ?>
	</div>
	
</div>

<?php $this->TinymceElfinder->defineElfinderBrowser()?>

<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>
        tinymce.init({
        	height: 400,
        	width: 960,
        	selector:'textarea',
        	plugins : 'image',
        	file_browser_callback : elFinderBrowser
        });
</script>