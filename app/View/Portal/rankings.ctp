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
    <ul class="ranking-list" id="ranking-list">
	<?php foreach($rankings AS $entry){ ?>
		<li class="ranking-item">
			<div class="ranking-entry">
				<img src="<?=$entry['Person']['image'];?>" />
				<p>
					<b><a href="<?=$this->HTML->url(array('controller'=>'People', 'action'=>'view', $entry['Person']['id']));?>"><?=$entry['Person']['fullname'];?></a></b>
					<span class="ranking-xp"><?=$entry['Exp']['exp'];?>xp</span>
					<br/>
					<span class="ranking-meta">Tỷ lệ đúng <?=floor($entry['Exp']['correct']/($entry['Exp']['correct']+$entry['Exp']['wrong'])*100);?>%</span>
					
				</p>
			</div>
		</li>
	<?php } ?>
	</ul>
	<div class="panel-footer center"><a href="<?=$this->HTML->url(array('controller'=>'ranking', 'action'=>'index'));?>"><span class="glyphicon glyphicon-fire"></span> Xem Top 100 <span class="glyphicon glyphicon-fire"></span></a></div>
  </div>
</div>
<script type="text/javascript">
	$('#ranking-filter').change(function(){
		$('#ranking-list').load('/Ajax/portalRankings?subject='+$(this).val());
	});
</script>