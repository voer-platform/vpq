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
						<p>
							<?php echo __('Type in content of question, if there is a math equation. Click on \'<>\' icon and paste in MathML code.'); ?>
							<?php echo __('Using this online editor to get mathml code:').' '.$this->Html->link(__('Editor'), 'http://www.wiris.com/editor/demo/en/mathml-latex.html', array('target' => '_blank')); ?>
						</p>
						<?php echo $this->Form->input('content', array('label' => __('Content'), 'type' => 'textarea', 'class' => 'tinymce-content')); ?>
					</div>
					<div class='col-lg-4'>

						<!-- difficulty and subcategories -->
						<?php
							$diff_oftions = array(1 => __('Easy'), 2 => __('Quite easy'), 3 => __('Normal'), 4 => __('Hard'), 5 => __('Insane'), ); 
							echo $this->Form->input('difficulty', array ('label' => __('Difficulty'), 'class'=> 'form-control', 'options' => $diff_oftions, 'selected' => 3)); ?>
						<?php echo $this->Form->input('Subcategory', array ('label' => __('Content'), 'class'=> 'form-control', 'id' => 'select-subcategory', 'selected' => 0));?>
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
<?php //$this->TinymceElfinder->defineElfinderBrowser()?>
<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

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
    	extended_valid_elements: 'figure,figcaption,maction,maligngroup,malignmark,math,menclose,merror,mfenced,mfrac,mglyph,mi,mlabeledtr,mlongdiv,mmultiscripts,mn,mo,mover,mpadded,mphantom,mroot,mrow,ms,mscarries,mscarry,msgroup,msline,mspace,msqrt,msrow,mstack,mstyle,msubsup,msup,mtable,mtd,mtext,mtr,munder,munderover,semantics,sub,mfrac,sup,annotation', 
    	file_browser_callback : elFinderBrowser
    });

    tinymce.init({
    	selector: '.tinymce-answer',
    	height: 50,
    	width: 300,
    	plugins : 'code',
    	relative_urls: false,
    	toolbar: 'code',
    	extended_valid_elements: 'figure,figcaption,maction,maligngroup,malignmark,math,menclose,merror,mfenced,mfrac,mglyph,mi,mlabeledtr,mlongdiv,mmultiscripts,mn,mo,mover,mpadded,mphantom,mroot,mrow,ms,mscarries,mscarry,msgroup,msline,mspace,msqrt,msrow,mstack,mstyle,msubsup,msup,mtable,mtd,mtext,mtr,munder,munderover,semantics,sub,mfrac,sup,annotation', 
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