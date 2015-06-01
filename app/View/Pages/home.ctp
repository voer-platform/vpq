<?php $this->start('meta'); ?>
<meta property="og:url" content="<?php echo Router::url( $this->here, true ); ?>" /> 
<meta property="og:title" content="<?php echo __('Personalized Learning System'); ?>" />
<meta property="og:description" content="<?php echo __('Where you can learn anything!'); ?>" /> 
<meta property="og:image" content="<?php echo $this->Html->url(Router::url($this->here, true).'img/interface.png'); ?>" />
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
		background: url('img/home3.png');
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
	.header .navbar {
		margin-bottom: 0;
		border-bottom: 0;
		box-shadow: 0px 0px 5px rgb(63, 63, 63);
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
</style>
<div id="banner">
	<div class="banner-overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<br/><br/><br/>
				<h1 style="font-size:42px;font-weight:bold;"><strong>PLS</strong> - Học theo cách của bạn</h1>
				<p style="font-size: 20px;">Tham gia vào hệ thống để trải nghiệm nguồn kiến thức vô tận trên nhiều lĩnh vực</p>
				<p style="font-size: 15px;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-ok"></span>&nbsp; Hơn 10000 câu hỏi có lời giải</p>
				<p style="font-size: 15px;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-ok"></span>&nbsp; Phương thức làm bài mềm dẻo, chỉ từ 5 phút mỗi bài</p>
				<p style="font-size: 15px;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-ok"></span>&nbsp; Tự động đánh giá kết quả chi tiết và chính xác</p>
				<br/>
				<a href="javascript:void(0);" class="login-open btn btn-ghost btn-lg" data-toggle="modal" data-target="#login-modal" data-section="home-banner">
					Đăng nhập <span class="glyphicon glyphicon-chevron-right"></span>
				</a>
				<br/><br/><br/><br/>
				<!--<p style="font-size: 16px;">
					<ul class="counter">
						<li>
							<b>18</b><br/>Môn Học
						</li>
						<li>
							<b>758586</b><br/>
							Câu Hỏi
						</li>
						<li>
							<b>467</b><br/>
							Chuyên Đề
						</li>	
					</ul>	
				</p>-->
			</div>
		</div>	
	</div>	
</div>
<br/><br/>
<div class='container'>
    <div class="row">
		<!--
		<div class="col-md-12">
			<h4 class="section-heading" style="background:#F5FAFF; color:#00898C;border-top: solid 5px #428bca;"><span class="glyphicon glyphicon-question-sign"></span> Có gì hot?</h4>
		</div>
		-->
		<div class="col-md-4">
			<div class="advantages-container">
				<div class="advantages-image">
					<?php echo $this->Html->image('statistic.jpg'); ?>
				</div>	
				<div class="advantages-text">
					<p><b>Theo dõi kết quả học tập</b></p>
					<p>Giúp bạn nắm bắt được tình hình và cải tiến chất lượng học tập của mình</p>
				</div>
			</div>	
		</div>
		<div class="col-md-4">
			<div class="advantages-container">
				<div class="advantages-image">
					<?php echo $this->Html->image('responsive.png'); ?>
				</div>	
				<div class="advantages-text">
					<p><b>Học mọi lúc mọi nơi</b></p>
					<p>Hỗ trợ đa nền tảng cho phép bạn có thể làm bài trên bất cứ thiết bị nào và bất cứ nơi đâu</p>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="advantages-container">
				<div class="advantages-image">
					<?php echo $this->Html->image('ask.jpg'); ?>
				</div>	
				<div class="advantages-text">
					<p><b>Cộng đồng hỗ trợ học tập</b></p>
					<p>Kết bạn, trò chuyện và trao đổi bài tập với giáo viên, bạn bè trên hệ thống</p>
				</div>
			</div>
		</div>
	</div>
	<hr/>
	<br/>
	<div class="row">
		<div class="col-md-7 intro-img">
			<?php echo $this->Html->image('interface.jpg'); ?>
			
		</div>
		<div class="col-md-5">
			<h2 style="color: #D13939;">Đánh giá kết quả học tập</h2>
			<br/>
			<p style="font-size: 16px;line-height: 25px;">Theo dõi quá trình học tập qua các biểu đồ điểm số, từ đó điều chỉnh chế độ học tập cho hợp lý.</p>
			<p style="font-size: 16px;line-height: 25px;">Đánh giá kết quả chi tiết theo từng chương, bài; giúp bạn khắc phục điểm yếu và phát huy điểm mạnh.</p>
			<br/>
			<p><a href="javascript:void(0);"  class="login-open" data-toggle="modal" data-target="#login-modal" data-section="dashboard-intro"><button class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-hand-right"></span>&nbsp; Dùng thử</button></a></p>
		</div>
	</div>
	<br/>
	<hr/>
	<br/>	
	<div class="row">
		<div class="col-md-5">
			<h2 style="color: #D13939;">Học mọi lúc mọi nơi</h2>
			<br/>
			<p style="font-size: 16px;line-height: 25px;">Thời lượng bài kiểm tra đa dạng cho phép bạn làm bài cả ngày hoặc chỉ với 5 phút nghỉ giữa giờ.</p>
			<p style="font-size: 16px;line-height: 25px;">PLS được thiết kế tương thích trên nhiều thiết bị. Không chỉ máy tính, bạn còn có thể luyện tập ngay trên smartphone và tablet.</p>
			
			<br/>
			<p><a href="javascript:void(0);"  class="login-open" data-toggle="modal" data-target="#login-modal" data-section="responsive-intro"><button class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-hand-right"></span>&nbsp; Dùng thử</button></a></p>
		</div>
		<div class="col-md-7 intro-img">
			<?php echo $this->Html->image('responsive-theme.jpg'); ?>
			
		</div>
	</div>
	<br/>
	<!--
	<hr/>
	<br/>
	<div class="row">
		<div class="col-md-5">
			<div class="advantages-container">
				<div class="advantages-image">
					<?php echo $this->Html->image('hs1.jpg'); ?>
				</div>	
				<div class="advantages-text">
					<p><b>Quỳnh Anh - THPT Phan Đình Phùng</b></p>
					<p>Mình cảm thấy thực sự hào hứng với lượng câu hỏi nhiều và trải rộng của PLS.
						Sau một thời gian làm bài trên hệ thống, điểm tổng kết môn Vật Lý của mình được nâng cao đáng kể.</p>
				</div>
			</div>	
		</div>
		<div class="col-md-6">
			<div class="advantages-container">
				<div class="advantages-image">
					<?php echo $this->Html->image('hs2.jpg'); ?>
				</div>	
				<div class="advantages-text">
					<p><b>Trung Quốc - THPT Quang Trung</b></p>
					<p>Nhờ theo dõi kết quả học tập trên hệ thống, mình đã cải thiện được nhiều chương còn kém. Qua vài tháng luyện tập, mình đã nắm vững và đều toàn bộ kiến thức Vật Lý cấp 3.</p>
				</div>
			</div>	
		</div>
	</div>
	<br/>
	-->
	<hr/>
	<div class="row">
		<div class="col-md-4">
		</div>
		<div class="col-md-6 right">
			<h3 style="margin-top: 5px;font-weight: bold;">Còn chờ gì nữa?</h3>
			<h4>Tham gia thử sức ngay thôi!</h4>
		</div>
		<div class="col-md-2 right">
			<a href="javascript:void(0);" class="login-open btn btn-lg btn-primary mgt-10" data-toggle="modal" data-target="#login-modal" data-section="home-footer">
				Đăng nhập <span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div>
    </div>
	<br/>
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
	});
</script>
