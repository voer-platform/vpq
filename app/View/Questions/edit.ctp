<div class="questions form">
<?php echo $this->Form->create('Question'); ?>
	<fieldset>
		<legend><?php echo __('Edit Question'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('content', array('type' => 'textarea', 'id' => 'question-content'));
		echo $this->Form->input('difficulty');
		echo $this->Form->input('Subcategory');
		echo $this->Form->input('Test');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Question.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Question.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Questions'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Answers'), array('controller' => 'answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Subcategories'), array('controller' => 'subcategories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subcategory'), array('controller' => 'subcategories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tests'), array('controller' => 'tests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Test'), array('controller' => 'tests', 'action' => 'add')); ?> </li>
	</ul>
</div>

<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script type="text/javascript">
	$('input').addClass('form-control');
	$('select').addClass('form-control');
	tinymce.init({
    	selector : '#question-content',
    	plugins : 'code',
    	relative_urls: false,
    	toolbar: 'code image',
    	menubar : '',
    	extended_valid_elements: 'figure,figcaption,maction,maligngroup,malignmark,math,menclose,merror,mfenced,mfrac,mglyph,mi,mlabeledtr,mlongdiv,mmultiscripts,mn,mo,mover,mpadded,mphantom,mroot,mrow,ms,mscarries,mscarry,msgroup,msline,mspace,msqrt,msrow,mstack,mstyle,msubsup,msup,mtable,mtd,mtext,mtr,munder,munderover,semantics,sub,mfrac,sup,annotation', 
    });
</script>