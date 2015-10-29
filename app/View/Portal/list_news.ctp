<?php $this->start('meta'); ?>
<meta name="description" content="Theo dõi thông tin mới nhất về học tập, các sự kiện trên PLS.">
<?php $this->end(); ?>
<div class="row">
	<div class="col-md-9">
		<?=$this->element('../Portal/breadcrumb');?>
		<h1 class="fs-25">Tin tức</h1>
		<hr/>
		<div class="category-news-container">
			<?php foreach($newsletters AS $news){ ?>
				<div class="category-news-list-item">
					<a href="<?=$this->Html->url('/tin-tuc/'.$news['Newsletter']['slug'], true);?>">
						<img class="news-img" src="<?=$this->Pls->getImageFromContent($news['Newsletter']['content']);?>" width="70" height="70" />
					</a>
					<a href="<?=$this->Html->url('/tin-tuc/'.$news['Newsletter']['slug'], true);?>">
						<h3 class="news-title"><b><?=$news['Newsletter']['title'];?></b></h3>
					</a>	
					<p class="news-time"><?=date('d/m/Y h:i', strtotime($news['Newsletter']['created']));?></p>
					<p class="news-excerpt"><?=substr(strip_tags($news['Newsletter']['content']), 0, stripos(strip_tags($news['Newsletter']['content']), '.')+1);?></p>
				</div>	
			<?php } ?>
		</div>
		<div class="pagination-container">
			<ul class="pagination mg0 pull-right">
				<?php
					echo $this->Paginator->prev('< ' . __('previous'), array('tag'=>'li'), null, array('tag'=>'li', 'class' => 'disabled', 'disabledTag'=>'a'));
					echo $this->Paginator->numbers(array('separator' => '', 'tag'=>'li', 'currentClass' => 'active', 'currentTag' => 'a'));
					echo $this->Paginator->next(__('next') . ' >', array('tag'=>'li'), null, array('tag'=>'li', 'class' => 'disabled', 'disabledTag'=>'a'));
				?>
			</ul>
		</div>		
	</div>
	<div class="col-md-3">
		<?=$this->element('../Portal/sidebar');?>
	</div>
</div>