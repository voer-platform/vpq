<?php echo $this->Html->script('/ckeditor/ckeditor.js');?>
<?php echo $this->Html->script('/ckfinder/ckfinder.js');?>
<div class="newsletters form">
<h2><?=__('Edit Newsletter'); ?></h2>
<hr/>
<?php echo $this->Form->create('Newsletter'); ?>
	<?=$this->Form->input('id');?>
	<table class="table table-bordered">
		<tr>
			<td class="w-150"><label class="control-label">Chuyên mục</label></td>
			<td><?=$this->Form->input('newsletter_category_id', array('label'=>false, 'div'=>false, 'class'=>'form-control w-150'));?></td>
		</tr>
		<tr>
			<td><label class="control-label">Tiêu đề</label></td>
			<td><?=$this->Form->input('title', array('label'=>false, 'div'=>false, 'class'=>'form-control'));?></td>
		</tr>
		<tr>
			<td><label class="control-label">Nội dung</label></td>
			<td><?=$this->Form->input('content', array('label'=>false, 'div'=>false, 'class'=>'form-control', 'id'=>'ckeditor'));?></td>
		</tr>
		<tr>
			<td><label class="control-label">Hiển thị</label></td>
			<td><?=$this->Form->input('status', array('label'=>false, 'div'=>false));?></td>
		</tr>
		<tr>
			<td colspan="2"><?php echo $this->Form->end(array('label'=>__('Submit'), 'class'=>'btn btn-primary pull-right')); ?></td>
		</tr>
		
		
	</table>

</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Newsletter.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Newsletter.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Newsletters'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Newsletter Categories'), array('controller' => 'newsletter_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Newsletter Category'), array('controller' => 'newsletter_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
<script>
			var editor = CKEDITOR.replace( 'ckeditor',
				{
					filebrowserBrowseUrl : PLS.ajaxUrl+'app/webroot/ckfinder/ckfinder.html',
					filebrowserImageBrowseUrl : PLS.ajaxUrl+'app/webroot/ckfinder/ckfinder.html?type=Images',
					filebrowserFlashBrowseUrl : PLS.ajaxUrl+'app/webroot/ckfinder/ckfinder.html?type=Flash',
					filebrowserUploadUrl : PLS.ajaxUrl+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
					filebrowserImageUploadUrl : PLS.ajaxUrl+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
					filebrowserFlashUploadUrl : PLS.ajaxUrl+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					fullPage: true,
					allowedContent: true,
				}
				
			);
			CKFinder.setupCKEditor( editor, '../' ) ;
</script>