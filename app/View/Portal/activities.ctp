<div class="panel panel-primary">
  <div class="panel-heading pd10"><span class="glyphicon glyphicon-refresh"></span> &nbsp;Hoạt động gần gây</div>
  <div class="panel-body pd0">
    <ul class="activity-list">
	<?php $i=0; foreach($activities AS $entry){ ?>
		<li class="activity-item" <?php if($i>5){ ?>style="display:none;"<?php }?>>
			<div class="activity-entry">
				<?php echo $this->Html->image('avatars/'.$entry['Person']['image'], array('class' => 'avatar', 'title' => $entry['Person']['fullname'], 'alt' => $entry['Person']['fullname'])); ?>
				<p><b><a href="<?=$this->Html->url('/thanh-vien/'.$entry['Person']['id'], true);?>"><?=$entry['Person']['fullname'];?></a></b> vừa làm bài kiểm tra <?=$entry['Test']['time_limit'];?> phút môn <?=$entry['Subject']['name'];?></p>
			</div>
		</li>
	<?php $i++; } ?>
	</ul>
  </div>
</div>
<script>
	(function activityLoop() {
		activityTime = Math.floor((Math.random() * 10000) + 5000);
		setTimeout(function() {
			$('.activity-item:visible').eq(5).slideUp();
			$('.activity-item:last-child').prependTo('.activity-list').slideDown();
			activityLoop();
		}, activityTime);
	}());	
</script>