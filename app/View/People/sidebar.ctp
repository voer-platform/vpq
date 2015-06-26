
<div class="panel panel-default" style="border: solid 2px #428BCA;">
	<div class="panel-body">
		<div class="user-overview">
			<img class="avatar" src="<?=$user['image'];?>" />
			<div class="info-overview">
				<b><?=$user['fullname'];?></b><br/>
				<span class="fs-12">Exp: <?=$data_user['exp'];?></span><br/>
				<span class="fs-12">Coin: <?=$data_user['coin'];?></span>
			</div>
		</div>	
		<hr class="mgb-10" />
		Việc học sẽ vui hơn khi có bạn bè. Hãy rủ bạn tham gia ngay nhé!
		<div class="center mgt-10">
			<a class='btn btn-primary ib w-100' href="javascript:void(0);" onclick="FBShare()"><span class='glyphicon glyphicon-share-alt'></span>&nbsp;&nbsp;<?php echo __('Share'); ?></a>
			&nbsp;&nbsp;<a class='btn btn-success ib w-100' href="javascript:void(0);" onclick="FBInvite()"><span class='glyphicon glyphicon-send'></span>&nbsp;&nbsp;<?php echo __('Invite'); ?></a>
		</div>	
	</div>
</div>

<?=$this->element('../Portal/activities');?>
<div class="fb-page" data-href="https://www.facebook.com/plseduvn" data-small-header="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false">
	<div class="fb-xfbml-parse-ignore">
		<blockquote cite="https://www.facebook.com/plseduvn">
			<a href="https://www.facebook.com/plseduvn">PLS Edu</a>
		</blockquote>
	</div>
</div>
<br/><br/>