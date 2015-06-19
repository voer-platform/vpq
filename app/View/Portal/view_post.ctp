<div class="row">
	<div class="col-md-9">
		<br/>
		<?=$this->element('../portal/breadcrumb');?>
		<h1 class="fs-25"><?=$newsletter['Newsletter']['title'];?></h1>
		<p><?=__('Post time:');?> <?=date('d/m/Y h:i', strtotime($newsletter['Newsletter']['created']));?>, <?=__('Category:');?>  <?=$newsletter['NewsletterCategory']['name'];?></p>
		<hr/>
		<?=$newsletter['Newsletter']['content'];?>
	</div>
	<div class="col-md-3">
		<?=$this->element('../portal/sidebar');?>
	</div>
</div>