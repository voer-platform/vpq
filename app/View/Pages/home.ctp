<?php $this->start('meta'); ?>
<meta property="og:url" content="<?php echo Router::url( $this->here, true ); ?>" /> 
<meta property="og:title" content="<?php echo __('Personal Learning System'); ?>" />
<meta property="og:description" content="<?php echo __('Where you can learn anything!'); ?>" /> 
<meta property="og:image" content="<?php echo $this->Html->url(Router::url($this->here, true).'img/logo-small.png'); ?>" />
<?php $this->end(); ?>
<?php echo $this->Html->css('home.css');?>
<style>
	.content.container {
		width:100%!important;
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
</style>
<div id="banner">
	<div class="banner-overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<br/><br/><br/><br/><br/><br/><br/><br/>
				<h1 style="font-size:42px;font-weight:bold;"><strong>PLS</strong> - Học theo cách của bạn</h1>
				<p style="font-size: 20px;">Tham gia vào hệ thống để trải nghiệm nguồn kiến thức vô tận trên nhiều lĩnh vực</p>
				<a href="<?php echo $fb_login_url; ?>" class="mix-login" data-section="home-banner">
					<?php echo $this->Html->image('facebook-login-button.png', array('class' => 'facebook-btn', 'alt' => __('Login with Facebook'))); ?>
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
			<p><a href="<?php echo $fb_login_url; ?>" class="mix-login" data-section="dashboard-intro"><button class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-hand-right"></span>&nbsp; Dùng thử</button></a></p>
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
			<p><a href="<?php echo $fb_login_url; ?>" class="mix-login" data-section="responsive-intro"><button class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-hand-right"></span>&nbsp; Dùng thử</button></a></p>
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
		<div class="col-md-4 right">
			<h3 style="margin-top: 5px;font-weight: bold;">Còn chờ gì nữa?</h3>
			<h4>Tham gia thử sức ngay thôi!</h4>
		</div>
		<div class="col-md-4 right">		 
			<a href="<?php echo $fb_login_url; ?>" class="mix-login" data-section="home-footer">
				<?php echo $this->Html->image('facebook-login-button.png', array('style'=> 'width:100%;','class' => 'facebook-btn', 'alt' => __('Login with Facebook'))); ?>
			</a>			
		</div>
    </div>
	<br/>
</div>
<script>
	$(document).ready(function(){
		
		mixpanel.track(
			"Enter Hompage"
		);
		
		mixpanel.track_links(".mix-login", "Login", function(e){
			return {"login_section": $(e).attr('data-section')};
		});
	});
</script>
