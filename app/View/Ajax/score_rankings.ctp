<?php foreach($scoreRankings AS $k=>$entry){ ?>
	<li class="ranking-item">
		<div class="ranking-entry">
			<span class="ranking-number"><?=$k+1;?></span>
			<?php echo $this->Html->image('avatars/'.$entry['Person']['image'], array('class' => 'avatar l40')); ?>
			<p class="mgl-80">
				<b><a href="<?=$this->Html->url(array('controller'=>'People', 'action'=>'view', $entry['Person']['id']));?>"><?=$entry['Person']['fullname'];?></a></b>
				<span class="ranking-xp"><?=$entry['Ranking']['score'];?>đ</span>
				<br/>
				<span class="ranking-meta"><?=$entry['Province']['name'];?></span>
				
			</p>
		</div>
	</li>
<?php } ?>