<div class='upload'>
	<label><?php echo __('Description'); ?></label>
	<p class ='description'><?php echo __('Upload a file with following format: doc/docx file. each question is seperated by a blank line'); ?></p>
	<ol>
		<li>question content</li>
		<li>"a." + answer content </li>
		<li>"b." + answer content</li>
		<li>"c." + answer content</li>
		<li>"d." + answer content</li>
		<li>"z." + correct answer(i.e: a)</li>
	</ol>
	<?php echo $this->Form->create('File', array('type' => 'file')); ?>
		<label>File doc/docx</label>
		<?php  echo $this->Form->imput('file', array('type' => 'file', 'class' => 'form-control'));?>
	<?php echo $this->Form->end(__('Submit')); ?>
</div>