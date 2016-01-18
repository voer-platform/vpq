<div class="panel panel-primary">
  <div class="panel-heading pd10">
	<span class="glyphicon glyphicon-education"></span> &nbsp;Chào Xuân Bính Thân
  </div>
  <div class="panel-body pd0">
    <ul class="ranking-list table-scroll" id="ranking-list">
	<?php foreach($event AS $entry){ ?>
		<li class="ranking-item">
			<div class="ranking-entry">
				<?php echo $this->Html->image('avatars/'.$entry['Person']['image'], array('class' => 'avatar')); ?>
				<p>
					<b><a href="<?=$this->Html->url('/thanh-vien/'.$entry['Person']['id'], true);?>"><?=$entry['Person']['fullname'];?></a></b>
					<span class="ranking-xp"><?=$entry['Exp']['exp'];?>xp</span>
					<br/>
					<span class="ranking-meta">Tỷ lệ đúng <?=floor($entry['Exp']['correct']/($entry['Exp']['correct']+$entry['Exp']['wrong'])*100);?>%</span>
					
				</p>
			</div>
		</li>
	<?php } ?>
	</ul>
  </div>
</div>

<script>
	$(document).ready(function(){
		$('.slimScrollDiv').attr('style','position: relative; overflow: hidden; width: auto; height: 450px;');
		$('#ranking-list').attr('style','height: 250px; overflow: hidden; width: auto;height: 450px;')
	});
</script>