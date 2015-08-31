<?php $this->start('meta'); ?>
<meta name="description" content="PLS là một website học trực tuyến, giúp cho học viên có thể theo dõi được tiến độ, chất lượng học tập của mình.">
<meta name="keywords" content="hoc truc tuyen, on thi dai hoc, hoc mai, luyen thi, on thi chat luong">
<meta name="robots" content="INDEX,FOLLOW">
<?php $this->end(); ?>	
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
								<img class="l40 avatar" src="<?=$entry['Person']['image'];?>" />
								<p class="mgl-80">
									<b><a href="<?=$this->Html->url('/thanh-vien/'.$entry['Person']['id']);?>"><?=$entry['Person']['fullname'];?></a></b>
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
								<img class="l40 avatar" src="<?=$entry['Person']['image'];?>" />
								<p class="mgl-80">
									<b><a href="<?=$this->Html->url('/thanh-vien/'.$entry['Person']['id'], true);?>"><?=$entry['Person']['fullname'];?></a></b>
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
								<img class="l40 avatar" src="<?=$entry['Person']['image'];?>" />
								<p class="mgl-80">
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
				</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-info">
				<img src="/img/ranking-emoticon.png" style="width: 130px;border-radius: 50%;height: 120px;float: left;margin-right: 30px;">
				<p><b>Những thành viên lười biếng(<i>không thường xuyên làm bài</i>) sẽ không có tên trên bảng xếp hạng này</b><p>
				- Top cao thủ là danh sách 100 người có <u>điểm kinh nghiệm(EXP)</u> cao nhất<br/>
				- Top cao điểm là danh sách 100 người có <u>điểm trung bình</u> cao nhất<br/>
				- Top tháng là danh sách 100 người nhận được nhiều <u>điểm kinh nghiệm(EXP)</u> nhất trong tháng này
			</div>
			<br/>
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