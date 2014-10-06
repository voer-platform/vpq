<?php echo $this->Html->css('insert-questions-admin.css'); ?>

<div class='admin-insert-questions'>
	<!-- left nav -->
	<?php echo $this->element('admin-left-nav'); ?>

	<!-- right nav -->
	<div class='col-lg-10'>
		<!-- visible form -->
		<div>	
			<?php echo $this->Form->create('Question'); ?>
				
				<!-- question content -->
				<legend><?php echo __('Add question content'); ?></legend>
				<?php echo $this->Form->input('content', array('label' => __('Content'), 'type' => 'textarea', 'id' => 'my_editor')); ?>
				<?php
					$diff_oftions = array(1,2,3,4,5,6,7,8,9,10); 
					echo $this->Form->input('difficulty', array ('label' => __('Difficulty'), 'class'=> 'form-control', 'options' => $diff_oftions)); ?>
				<?php echo $this->Form->input('Subcategory', array ('label' => __('Content'), 'class'=> 'form-control'));?>

				<!-- add more answers for the questions -->
				<legend><?php echo __('Add answers for question'); ?></legend>
				<?php for($i = 0; $i < 4; $i++): ?>
					<div class='row'>
						<div class='col-lg-3'>
							<?php echo $this->Form->input('Answer.'.$i.'.content', array ('label' => __('Content'), 'class'=> 'answer-row answer-content', 'required' => 'false')); ?>
						</div>
						<div class='col-lg-3'>
							<?php echo $this->Form->input('Answer.'.$i.'.correctness', array ('label' => __('Correctness'), 'title' => 'correctness', 'type' => 'checkbox', 'class'=> 'answer-row answer-correct')); ?>
						</div>
					</div>
				<?php endfor; ?>
			<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-primary btn-lg') ); ?>
		</div>
	</div>
	
</div>

<!-- elf file manager -->
<?php $this->TinymceElfinder->defineElfinderBrowser()?>

<!-- script -->
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>
    tinymce.init({
    	height: 150,
    	width: 800,
    	selector:'textarea',
    	plugins : 'image',
    	relative_urls: false,
    	file_browser_callback : elFinderBrowser
    });
</script>