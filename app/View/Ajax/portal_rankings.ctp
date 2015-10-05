<?php foreach($rankings AS $k=>$entry){ ?>
	<li class="ranking-item">
		<div class="ranking-entry">
			<?php if($limit == 100){ ?>
				<span class="ranking-number"><?=$k+1;?></span>
				<?php echo $this->Html->image('avatars/'.$entry['Person']['image'], array('class' => 'avatar l40')); ?>
				<p class="mgl-80">
					<b><a href="<?=$this->Html->url(array('controller'=>'People', 'action'=>'view', $entry['Person']['id']));?>"><?=$entry['Person']['fullname'];?></a></b>
					<span class="ranking-xp"><?=$entry['Exp']['exp'];?>xp</span>
					<br/>
					<span class="ranking-meta">Tỷ lệ đúng <?=floor($entry['Exp']['correct']/($entry['Exp']['correct']+$entry['Exp']['wrong'])*100);?>%</span>
					
				</p>
			<?php } else { ?>
				<?php echo $this->Html->image('avatars/'.$entry['Person']['image']); ?>
				<p>
					<b><a href="<?=$this->Html->url(array('controller'=>'People', 'action'=>'view', $entry['Person']['id']));?>"><?=$entry['Person']['fullname'];?></a></b>
					<span class="ranking-xp"><?=$entry['Exp']['exp'];?>xp</span>
					<br/>
					<span class="ranking-meta">Tỷ lệ đúng <?=floor($entry['Exp']['correct']/($entry['Exp']['correct']+$entry['Exp']['wrong'])*100);?>%</span>
					
				</p>
			<?php } ?>	
		</div>
	</li>
<?php } ?>