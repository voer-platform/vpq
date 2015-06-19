<ol class="breadcrumb">
	<li><a href="<?=$this->html->url('/');?>"><?=__('Home');?></a></li>
	<?php foreach($breadcrumbs AS $item){ ?>
	<li><a href="<?=$item['url'];?>"><?=$item['text'];?></a></li>
	<?php } ?>
</ol>