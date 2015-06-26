
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-danger">
				<div class="panel-heading pd10">
					<span class="glyphicon glyphicon-certificate"></span> &nbsp;Top Cao Thủ
				</div>
				<div class="panel-body pd0">
					<ul class="ranking-list" id="permanent-ranking-list">
					<?php foreach($rankings AS $k=>$entry){ ?>
						<li class="ranking-item">
							<div class="ranking-entry">
								<span class="ranking-number"><?=$k+1;?></span>
								<img class="l40" src="<?=$entry['Person']['image'];?>" />
								<p class="mgl-80">
									<b><a href="<?=$this->Html->url(array('controller'=>'People', 'action'=>'view', $entry['Person']['id']));?>"><?=$entry['Person']['fullname'];?></a></b>
									<span class="ranking-xp"><?=$entry['Person']['exp'];?>xp</span>
									<br/>
									<span class="ranking-meta"><?=$entry['Province']['name'];?></span>
									
								</p>
							</div>
						</li>
					<?php } ?>
					</ul>
				</div>
				</div>

		</div>
		<div class="col-md-4">
			<div class="panel panel-success">
				<div class="panel-heading pd10">
					<span class="glyphicon glyphicon-star"></span> &nbsp;Top Cao Điểm
					<select class="pull-right ranking-filter ranking-filter-green" id="score-ranking-filter">
						<?php foreach($subjects AS $id=>$subject){ ?>
							<option value="<?=$id;?>"><?=$subject;?></option>
						<?php } ?>
					</select>
				</div>
				<div class="panel-body pd0">
					<div>
					<ul class="ranking-list" id="score-ranking-list">
					<?php foreach($scoreRankings AS $k=>$entry){ ?>
						<li class="ranking-item">
							<div class="ranking-entry">
								<span class="ranking-number"><?=$k+1;?></span>
								<img class="l40" src="<?=$entry['Person']['image'];?>" />
								<p class="mgl-80">
									<b><a href="<?=$this->Html->url(array('controller'=>'People', 'action'=>'view', $entry['Person']['id']));?>"><?=$entry['Person']['fullname'];?></a></b>
									<span class="ranking-xp"><?=$entry['Ranking']['score'];?>đ</span>
									<br/>
									<span class="ranking-meta"><?=$entry['Province']['name'];?></span>
									
								</p>
							</div>
						</li>
					<?php } ?>
					</ul>
					</div>
				</div>
				</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading pd10">
					<span class="glyphicon glyphicon-education"></span> &nbsp;Xếp hạng tháng <?=ltrim(date('m'), '0');?>
					<select class="pull-right ranking-filter" id="ranking-filter">
						<option value="">Tất cả</option>
						<?php foreach($subjects AS $id=>$subject){ ?>
							<option value="<?=$id;?>"><?=$subject;?></option>
						<?php } ?>
					</select>
				</div>
				<div class="panel-body pd0">
					<div>
					<ul class="ranking-list" id="ranking-list">
					<?php foreach($monthRankings AS $k=>$entry){ ?>
						<li class="ranking-item">
							<div class="ranking-entry">
								<span class="ranking-number"><?=$k+1;?></span>
								<img class="l40" src="<?=$entry['Person']['image'];?>" />
								<p class="mgl-80">
									<b><a href="<?=$this->Html->url(array('controller'=>'People', 'action'=>'view', $entry['Person']['id']));?>"><?=$entry['Person']['fullname'];?></a></b>
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
				</div>
		</div>
	</div>
<script type="text/javascript">
	$('#ranking-filter').change(function(){
		$('#ranking-list').load('/Ajax/portalRankings?subject='+$(this).val()+'&limit=100');
		$('#ranking-list').parent().slimScroll({height: 440});
	});
	$('#score-ranking-filter').change(function(){
		$('#score-ranking-list').load('/Ajax/scoreRankings?subject='+$(this).val()+'&limit=100');
		$('#score-ranking-list').parent().slimScroll({height: 440});
	});
	$('.ranking-list').slimScroll({
        height: 440,
		opacity: 0
    }).mouseover(function() {
		$(this).next('.slimScrollBar').css('opacity', 0.4);
	});
</script>