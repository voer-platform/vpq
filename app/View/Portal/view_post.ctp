<div class="row">
	<div class="col-md-9">
		<?=$this->element('../Portal/breadcrumb');?>
		<h1 class="fs-25"><?=$newsletter['Newsletter']['title'];?></h1>
		<p><?=__('Post time:');?> <?=date('d/m/Y h:i', strtotime($newsletter['Newsletter']['created']));?>, <?=__('Category:');?>  <?=$newsletter['NewsletterCategory']['name'];?></p>
		<hr/>
		<?=$newsletter['Newsletter']['content'];?>
	</div>
	<div class="col-md-3">
		<?=$this->element('../Portal/sidebar');?>
	</div>
</div>