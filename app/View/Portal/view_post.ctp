<?php $this->start('meta'); ?>
<meta name="description" content="<?=str_replace(array("\r", "\n"), "", substr(trim(strip_tags($newsletter['Newsletter']['content'])), 0, 350));?>">
<?php $this->end(); ?>
<div class="row">
	<div class="col-md-9">
		<?=$this->element('../Portal/breadcrumb');?>
		<h1 class="fs-25"><?=$newsletter['Newsletter']['title'];?></h1>
		<p><?=__('Post time:');?> <?=date('d/m/Y h:i', strtotime($newsletter['Newsletter']['created']));?>, <?=__('Category:');?>  <?=$newsletter['NewsletterCategory']['name'];?></p>
		<hr/>
		<?php preg_match('/<body>(.*)<\/body>/s', $newsletter['Newsletter']['content'], $matches); echo $matches[1]; ?>
	</div>
	<div class="col-md-3">
		<?=$this->element('../Portal/sidebar');?>
	</div>
</div>