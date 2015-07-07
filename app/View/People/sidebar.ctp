<div class="panel panel-default" style="border: solid 2px #428BCA;">
	<div class="panel-body">
		<div class="user-overview">
			<img class="avatar" src="<?=$user['image'];?>" />
			<div class="info-overview">
				<b><?=$user['fullname'];?></b><br/>
				<span class="fs-12"><a href="javascript:void(0);" class="hasDetail" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="<b>Điểm kinh nghiệm (Exp)</b><br/>là điểm bạn nhận được khi làm bài hoặc tham gia các sự kiện"><span class="glyphicon glyphicon-question-sign"></span></a> Exp: <?=$data_user['exp'];?></span><br/>
				<span class="fs-12 hasDetail" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="<b>Xu</b><br/>nhận được bằng cách nạp thẻ hoặc tham gia sự kiện, sử dụng để mua bài kiểm tra"><?=$this->Html->image('coin.png', array('style="width:12px;margin-bottom:3px;"'));?> Xu: <?=$data_user['coin'];?></span>
			</div>
		</div>	
		<hr class="mgb-10" />
		Việc học sẽ vui hơn khi có bạn bè. Hãy rủ bạn tham gia ngay nhé!
		<div class="row mgt-10">
			<div class="col-md-6 pdr-5">
				<a class='btn btn-primary ib fw' href="javascript:void(0);" onclick="FBShare()"><span class='glyphicon glyphicon-share-alt'></span>&nbsp;&nbsp;<?php echo __('Share'); ?></a>
			</div>	
			<div class="col-md-6 pdl-5">
				<a class='btn btn-success ib fw' href="javascript:void(0);" onclick="FBInvite()"><span class='glyphicon glyphicon-send'></span>&nbsp;&nbsp;<?php echo __('Invite'); ?></a>
			</div>	
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