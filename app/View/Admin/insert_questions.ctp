<?php echo $this->Html->css('insert-questions-admin.css'); ?>

<div class='admin-insert-questions'>
	<!-- left nav -->
	<?php echo $this->element('admin-left-nav'); ?>

	<!-- right nav -->
	<div class='col-lg-10'>
		<!-- visible form -->
		<div>	
			<legend><?php echo __('Add question content'); ?></legend>
			<?php echo $this->Form->create('Question', array('type' => 'file')); ?>
				<div class='row'>
					<div class='col-lg-8'>
						<!-- question content -->
						<p><?php echo __('Type in content of question, if there is a math equation. Click on \'<>\' icon and paste in MathML code.'); ?></p>
						<?php echo $this->Form->input('content', array('label' => __('Content'), 'type' => 'textarea', 'class' => 'tinymce-content')); ?>
					</div>
					<div class='col-lg-4'>

						<!-- difficulty and subcategories -->
						<?php
							$diff_oftions = array(1,2,3,4,5); 
							echo $this->Form->input('difficulty', array ('label' => __('Difficulty'), 'class'=> 'form-control', 'options' => $diff_oftions)); ?>
						<?php echo $this->Form->input('Subcategory', array ('label' => __('Content'), 'class'=> 'form-control', 'id' => 'select-subcategory'));?>
					</div>
				</div>
				<!-- add answers for the questions -->
				<legend><?php echo __('Add answers for question'); ?></legend>
				<p><?php echo __('4 answers for each question. Check the checkbox on the right if the answer is correct'); ?></p>
				<?php for($i = 0; $i < 4; $i++): ?>
					<div class='row'>
						<div class='col-lg-4'>
							<?php echo $this->Form->input('Answer.'.$i.'.content', array ('label' => __('Answer').' '.($i+1), 'type' => 'textarea', 'class'=> 'answer-row answer-content tinymce-answer', 'required' => 'false')); ?>
						</div>
						<div class='col-lg-3'>
							<?php echo $this->Form->input('Answer.'.$i.'.correctness', array ('label' => __('Correctness'), 'title' => 'correctness', 'type' => 'checkbox', 'class'=> 'answer-row answer-correct')); ?>
						</div>
					</div>
				<?php endfor; ?>

				<!-- attachments for question -->
				<div id='attachments-container'>
					<h3><?php echo __('Attachments') ?></h3>
					<p id='attachments-description'><?php echo __('Attachments file for the question. Click on the button to add'); ?></p>
					<div id='attachments'>
					</div>
					<button type='button' id='btn-add-attachments'><?php echo __('Add attachments'); ?></button>
				</div>	
				<hr>
			<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-primary btn-md') ); ?>
		</div>
	</div>
	
</div>

<!-- elf file manager -->
<?php $this->TinymceElfinder->defineElfinderBrowser()?>

<!-- script -->
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>
	var i = 0;
	// tinyMCE
    tinymce.init({
    	selector : '.tinymce-content',
    	plugins : 'code',
    	relative_urls: false,
    	toolbar: 'code image',
    	menubar : '',
    	file_browser_callback : elFinderBrowser
    });

    tinymce.init({
    	selector: '.tinymce-answer',
    	height: 50,
    	width: 300,
    	plugins : 'code',
    	relative_urls: false,
    	toolbar: 'code',
    	menubar : ''
    });

    // disable multiple correct question
    $(".answer-correct").each(function()
	{
	    $(this).change(function()
	    {
	        $(".answer-correct").prop('checked',false);
	        $(this).prop('checked',true);
	    });
	});

    // add more attachments
    $('#btn-add-attachments').click(function(){
    	i++;
    	$('#attachments').append("<input type='file' name='data[Attachment][" + i + "]' class='form-control' id='QuestionAttachment-" + i + "'>");
    	$('#btn-add-attachments').text("<?php echo __('More attachments'); ?>");
    	$('#attachments-description').text("<?php echo __('Click button to add more'); ?>");
    });

</script>