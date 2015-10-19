<?php echo $this->element('admin-left-nav'); ?>

<div class="col-lg-10 col-md-10">
	<?php echo $this->Form->create('Announcement'); ?>
	<div class="row">
		<div class="col-md-12">
				<?=$this->Form->input('id');?>
				<?=$this->Form->input('content', array('label'=>false, 'div'=>false, 'class'=>'form-control', 'id'=>'ckeditor'));?>
		</div>
	</div>
	<div class="row">
		<br/>
		<div class="col-md-10">
			<label class="pull-right"><?=$this->Form->checkbox('status', array('label'=>false, 'div'=>false));?> Hiển thị thông báo</label>
		</div>
		<div class="col-md-2">
			<?php echo $this->Form->end(array('label'=>__('Update'), 'class'=>'btn btn-primary pull-right')); ?>	
		</div>
	</div>
</div>	