<?php $this->start('meta'); ?>
<meta property="og:url" content="<?php echo Router::url( $this->here, true ); ?>" /> 
<meta property="og:title" content="<?php echo __('PLS - Hệ thống cá nhân hóa học tập'); ?>" />
<meta property="og:description" content="<?php echo __('Ôn thi đại học theo cách của bạn'); ?>" /> 
<meta property="og:image" content="<?php echo $this->Html->url(Router::url($this->here, true).'img/share4.jpg'); ?>" />
<?php $this->end(); ?>
<?php echo $this->Html->css('home.css');?>
<style>
	.content.container {
		width:100%!important;
		padding:0!important;
	}
	
	.advantages-image {
		display: inline-block;
		width: 120px;
		height: 120px;
		border-radius: 150px;
		position: absolute;
		left: 25px;
		top:0;
		overflow: hidden;
	}
	.advantages-image img {
		width:100%;
	}
	.advantages-container {
		padding-left:140px;
		height: 120px;
	}
	.advantages-text {
	  padding-top: 10px;
	}
	.section-heading {
		background: #FFF4D7;
		color:#08ADB1;
		padding: 20px;
		margin-top: 50px;
		margin-bottom: 30px;
	}	
	#banner {
		background: url('img/home4.png');
		height:400px;
		color: rgb(255, 255, 255);
		text-shadow: 3px 1px 3px #6B6B6B;
		background-size:cover;
	}
	#banner .banner-overlay {
		width: 100%;
		height: 400px;
		/*background: rgba(0, 0, 0, 0.05);*/
		position: absolute;
		left: 0;
	}

	.facebook-btn {
		max-width:350px;
		margin-left: -5px;
	}
	.intro-img img {
		width:100%;
	}
	.faq-container {
		
		display:none;
	}
	.counter {
		list-style:none;
	}
	.counter {
		list-style:none;
		padding-left: 0px;
	}
	.counter li {
		display:inline-block;
		padding:0 20px;
		font-size: 16px;
		text-align:center;
		border-right: 1px solid rgba(255, 255, 255, 0.21);
	}
	.counter li:last-child {
		border:none;
	}
	.counter li b {
			font-size: 26px;
	}
	.btn-facebook {
	  color: #fff;
	  background-color: #49639f;
	  border-color: #374D81;
	} 
	.f-icon {
		position: relative;
		padding-right: 25px;
	}
	.btn-facebook:hover, .btn-facebook:focus, .btn-facebook:active {
		color:#fff!important;
	}

	.btn-facebook .f-icon b {
		position: absolute;
	  font-size: 18px;
	  top: -4px;
	  border-right: solid 1px #314B89;
	  padding-right: 9px;
	 } 
	 .btn.btn-orange {
		color:#fff;
		background-color: #F47920;
		border-color: #F47920;
	}
	.btn.btn-orange:hover {
		background-color:#FF6B00;
	}
	.news-list-item {
	  position: relative;
	  padding-left: 85px;
	  padding-bottom: 10px;
	  border-bottom: dotted 1px #E8E8E8;
	  margin-top: 15px;
	}
	.news-list-item:first-child {
		margin-top:0;
	}
	.news-list-item:last-child {
		border-bottom:0;
	}
	.news-img {
	  position: absolute;
	  left: 0;
	  top: 0;
	}
	h5.news-title {
	  margin-bottom: 5px;
	}
	p.news-time {
	  font-size: 12px;
	  margin-bottom: 2px;
	  color: #ABABAB;
	  font-style: italic;
	}
	p.news-excerpt {
	  font-size: 12px;
	  margin-bottom: 0;
	} 
</style>
<div class="container">

	<div class="row">
		<div class="col-md-9">
			
			<div class="row">
				<div class="col-md-8">
					<br/>
					<div class="bg-info" style="padding: 10px;color: #206DB0;">
							<div class="ib">
								<p class="mg0 fs-19"><b>PLS - Ôn thi đại học miễn phí</b></p>
								&nbsp;<span class="glyphicon glyphicon-ok"></span>&nbsp; Hơn 10000 câu hỏi có lời giải với 3 môn Lý, Hóa, Sinh
								<br/>
								&nbsp;<span class="glyphicon glyphicon-ok"></span>&nbsp; Phương thức làm bài mềm dẻo, chỉ từ 5 phút mỗi bài
								<br/>
								&nbsp;<span class="glyphicon glyphicon-ok"></span>&nbsp; Tự động đánh giá kết quả chi tiết và chính xác
							</div>	
							<div class="ib pull-right mgt-10">
								<p><button class="btn btn-orange cta-btn" data-toggle="modal" data-target="#login-modal" data-section="menu-top"><span class="glyphicon glyphicon-chevron-right"></span> Bắt đầu ngay</button></p>
								<p>Chỉ mất 3s đăng ký</p>
							</div>
					</div>
					<h3><?=$newsletterCategories[0]['NewsletterCategory']['name'];?></h3>
					<hr class="news-hr" />
					<div class="news-container">
						<?php foreach($newsletterCategories[0]['Newsletters'] AS $news){ ?>
							<div class="news-list-item">
								<a href="<?=$this->html->url(array('controller'=>'portal', 'action'=>'viewPost', $news['Newsletter']['id']));?>">
									<img class="news-img" src="<?=$this->Pls->getImageFromContent($news['Newsletter']['content']);?>" width="70" height="70" />
								</a>
								<a href="<?=$this->html->url(array('controller'=>'portal', 'action'=>'viewPost', $news['Newsletter']['id']));?>">
									<h5 class="news-title"><b><?=$news['Newsletter']['title'];?></b></h5>
								</a>	
								<p class="news-time"><?=date('d/m/Y h:i', strtotime($news['Newsletter']['created']));?></p>
								<p class="news-excerpt"><?=$this->Text->truncate($news['Newsletter']['content'], 150);?></p>
							</div>	
						<?php } ?>
					</div>
				</div>
				<div class="col-md-4">
					<br/>
					
					<?=$this->element('../portal/rankings');?>
				</div>
			</div>
			<!--	
			<hr/>
			<div class="row">
				<div class="col-md-5">
					<div class="fb-page" data-href="https://www.facebook.com/plseduvn" data-small-header="false" data-width="438" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/plseduvn"><a href="https://www.facebook.com/plseduvn">PLS Edu</a></blockquote></div></div>
				</div>	
				<div class="col-md-7">
					<h3 class="mg0"><?=$newsletterCategories[0]['NewsletterCategory']['name'];?></h3>
					<hr class="news-hr" />
					<div class="news-container">
						<?php 
							$firstNew = $newsletterCategories[0]['Newsletters'][0]; 
							unset($newsletterCategories[0]['Newsletters'][0]);
						?>
						<div class="news-list-item">
							<a href="<?=$this->html->url(array('controller'=>'portal', 'action'=>'viewPost', $firstNew['Newsletter']['id']));?>">
								<img class="news-img" src="<?=$this->Pls->getImageFromContent($firstNew['Newsletter']['content']);?>" width="70" height="70" />
							</a>
							<a href="<?=$this->html->url(array('controller'=>'portal', 'action'=>'viewPost', $firstNew['Newsletter']['id']));?>">
								<h5 class="news-title"><b><?=$firstNew['Newsletter']['title'];?></b></h5>
							</a>	
							<p class="news-time"><?=date('d/m/Y h:i', strtotime($firstNew['Newsletter']['created']));?></p>
							<p class="news-excerpt"><?=$this->Text->truncate($firstNew['Newsletter']['content'], 110);?></p>
						</div>	
						<ul class="subnews-container">
						<?php foreach($newsletterCategories[0]['Newsletters'] AS $news){ ?>
							<li>
								<a href="<?=$this->html->url(array('controller'=>'portal', 'action'=>'viewPost', $news['Newsletter']['id']));?>">
									<h5 class="subnews-title"><b><?=$news['Newsletter']['title'];?></b></h5>
								</a>	
							</li>	
						<?php } ?>
						</ul>
					</div>	
				</div>
			</div>	
			-->
		</div>
		<div class="col-md-3">
			<?=$this->element('../portal/sidebar');?>
		</div>
	</div>	

</div>	
<!-- Modal -->
<div class="modal" id="login-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog w-450">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="login-modal-title"><?php echo __('Login'); ?></h4>
		  </div>
      <div class="modal-body">
		<!-- login section -->
		<div id="login-section" style="overflow:hidden;">
			<div class="alert alert-warning">Nếu chưa có tài khoản, bạn hãy đăng nhập bằng Facebook</div>
			<div class="form-group">
				<a href="<?php echo $fb_login_url; ?>" class="btn btn-facebook btn-block mix-login">
					<div><span class="f-icon"><b>f</b></span>Đăng nhập bằng tài khoản Facebook</div>
				</a>
			</div>
			<div class="center" style="position: relative;margin: 20px 0;border-bottom: solid 1px #dedede;">
			  <span class="login-or" style="
				position: absolute;
				width: 100%;
				left: 0;
				top: -10px;
				text-align: center;"><span style="background-color: #fff;color: #C0C0C0;">( or )</span></span>
			</div>
			<div class="alert" id="login-mess" style="display:none;"></div>
			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
				  <input type="text" class="form-control" name="email" id="login-email" placeholder="<?php echo __('Email'); ?>">
				</div>
			</div>
			
			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
				  <input type="password" class="form-control" name="password" id="login-password" placeholder="<?php echo __('Password'); ?>">
				</div>
			</div>	
			<div class="form-group">
				<button class="btn btn-primary btn-block" id="login-btn"><?php echo __('Login'); ?></button>
			</div>	
			
			
			
			<hr/>
			<div class="right">
				<a href="javascript:void(0);" id="show-forgot-form"><?php echo __('Forgot password?'); ?></a>
			</div>
		</div>	
		<!-- forgot section -->
		<div id="forgot-section" style="height:0;overflow:hidden;">
			<div class="alert alert-danger" id="forgot-mess" style="display:none;"></div>
			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
				  <input type="text" class="form-control" name="email" id="forgot-email" placeholder="<?php echo __('Email'); ?>">
				</div>
			</div>
			<div class="form-group">
				<button class="btn btn-primary btn-block" id="forgot-btn"><?php echo __('Reset password'); ?></button>
			</div>	
			<hr/>
			<div class="right">
				<a href="javascript:void(0);" id="show-login-form">Quay về đăng nhập</a>
			</div>
		</div>	
      </div>
    </div>
  </div>
</div>
<script>
	$(document).ready(function(){
		mixpanel.track(
			"Enter Hompage"
		);
		
		var loginSection = '';
		$('.login-open').click(function(){
			loginSection = $(this).attr('data-section');
			console.log(loginSection);
		});
		mixpanel.track_links(".mix-login", "Login", function(e){
			return {"login_section": loginSection, "login_method": "facebook"};
		});	
		
		
		$('#login-btn').click(function(){
			email = $('#login-email').val();
			password = $('#login-password').val();
			if(email && password)
			{
				$.ajax({
					type: 'POST',
					url: '<?php echo $this->Html->url(array('controller'=>'people', 'action'=>'login')); ?>',
					data: {'email': email, 'password': password},
					success: function(response){
						response = JSON.parse(response);
						mess = '';
						if(parseInt(response.code)==1)
						{
							$('#login-mess').removeClass('alert-danger').addClass('alert-success');
							mixpanel.track("Login", {"login_section": loginSection, "login_method": "normal"});
							window.location.href = "/";
						}
						else
						{
							$('#login-mess').removeClass('alert-success').addClass('alert-danger');
						}
						$('#login-mess').html(response.mess).show();
					}
				});
			}
			else
			{
				$('#login-mess').removeClass('alert-success').addClass('alert-danger');
				$('#login-mess').html('<?php echo __('Please complete all field'); ?>').show();
			}
		});
		
		$('#forgot-btn').click(function(){
			email = $('#forgot-email').val();
			if(email)
			{
				$.ajax({
					type: 'POST',
					url: '<?php echo $this->Html->url(array('controller'=>'api', 'action'=>'forgotPassword')); ?>',
					data: {'email': email},
					success: function(response){
						response = JSON.parse(response);
						mess = '';
						if(parseInt(response.code)==1)
						{
							$('#forgot-mess').removeClass('alert-danger').addClass('alert-success');
						}
						else
						{
							$('#forgot-mess').removeClass('alert-success').addClass('alert-danger');
						}
						$('#forgot-mess').html(response.mess).show();
					}
				});
			}
			else
			{
				$('#forgot-mess').removeClass('alert-success').addClass('alert-danger');
				$('#forgot-mess').html('<?php echo __('Please complete all field'); ?>').show();
			}
		});
		
		$('#show-forgot-form, #show-login-form').click(function(){
			if($(this).attr('id')=='show-forgot-form')
			{
				el = $('#forgot-section').clone().appendTo('body');
				autoHeight = el.css('height', 'auto').height();
				el.remove();
				$('#login-section').animate({ height: 0, 'min-height': 0 }, 300);
				$('#forgot-section').animate({'min-height': autoHeight}, 300, function(){
					$(this).css('height', 'auto');
				});
				$('#login-modal-title').text('<?php echo __('Forgot password'); ?>');
			}
			else
			{
				el = $('#login-section').clone().appendTo('body');
				autoHeight = el.css('height', 'auto').height();
				el.remove();
				$('#forgot-section').animate({ height: 0, 'min-height': 0 }, 300);
				$('#login-section').animate({'min-height': autoHeight}, 300, function(){
					$(this).css('height', 'auto');
				});
				$('#login-modal-title').text('<?php echo __('Login'); ?>');
			}
		});
		
		setInterval(function(){
			$(".cta-btn").toggleClass("cta-btn-hover");
		 },1000);
		
	});
	
</script>
