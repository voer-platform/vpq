<?php foreach($rankings AS $k=>$entry){ ?>
	<li class="ranking-item">
		<div class="ranking-entry">
			<?php if($limit == 100){ ?>
				<span class="ranking-number"><?=$k+1;?></span>
				<img class="l40" src="<?=$entry['Person']['image'];?>" />
				<p class="mgl-80">
					<b><a href="<?=$this->Html->url(array('controller'=>'People', 'action'=>'view', $entry['Person']['id']));?>"><?=$entry['Person']['fullname'];?></a></b>
					<span class="ranking-xp"><?=$entry['Exp']['exp'];?>xp</span>
					<br/>
					<span class="ranking-meta">Tỷ lệ đúng <?=floor($entry['Exp']['correct']/($entry['Exp']['correct']+$entry['Exp']['wrong'])*100);?>%</span>
					
				</p>
			<?php } else { ?>
				<img src="<?=$entry['Person']['image'];?>" />
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