<?php $this->start('meta'); ?>
<meta property="og:url" content="<?php echo Router::url( $this->here, true ); ?>" /> 
<meta property="og:title" content="<?php echo __('Personal Learning System'); ?>" />
<meta property="og:description" content="<?php echo __('Where you can learn anything!'); ?>" /> 
<meta property="og:image" content="<?php echo $this->Html->url(Router::url($this->here, true).'img/logo-small.png'); ?>" />
<?php $this->end(); ?>
<?php echo $this->Html->css('home.css');?>
<style>
	.advantages-image {
		display: inline-block;
		width: 150px;
		height: 150px;
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
		padding-left:180px;
		height: 200px;
	}
	.advantages-text {
	  padding-top: 20px;
	}
	.section-heading {
		background: #FFF4D7;
		color:#08ADB1;
		padding: 20px;
		margin-top: 50px;
		margin-bottom: 30px;
	}	
</style>
<div class='container'>
	<div class="row">
		<div class="col-md-7">
			<h3><strong>Personal Learning System</strong> - Hệ thống hỗ trợ học trực tuyến</h3>
			<p style="font-size: 16px;">Tham gia vào hệ thống để trải nghiệm nguồn kiến thức vô tận trên nhiều lĩnh vực</p>
			<?php echo $this->Html->link($this->Html->image('facebook-login-button.png', array('class' => 'facebook-btn', 'alt' => __('Login with Facebook'))), $fb_login_url, array('escape' => false)); ?>
		</div>
		<div class="col-md-4 right">
			<?php echo $this->Html->image('banner-image.jpg'); ?>
		</div>
    </div>
    <div class="row">
		<div class="col-md-12">
			<h4 class="section-heading" style="background:#F5FAFF; color:#00898C;border-top: solid 5px #428bca;"><span class="glyphicon glyphicon-question-sign"></span> Có gì hot?</h4>
		</div>
		<div class="col-md-6">
			<div class="advantages-container">
				<div class="advantages-image">
					<?php echo $this->Html->image('many.jpg'); ?>
				</div>	
				<div class="advantages-text">
					<p><b>Số lượng câu hỏi và chủ đề vô tận</b></p>
					<p>Với hơn <b>21312555</b> câu hỏi và <b>1634</b> chuyên đề, bạn có thể tha hồ luyện tập những môn học yêu thích</p>
				</div>
			</div>	
		</div>
		<div class="col-md-6">
			<div class="advantages-container">
				<div class="advantages-image">
					<?php echo $this->Html->image('statistic.jpg'); ?>
				</div>	
				<div class="advantages-text">
					<p><b>Theo dõi kết quả học tập thông minh</b></p>
					<p>Giúp bạn nắm bắt được tình hình và cải tiến chất lượng học tập của mình</p>
				</div>
			</div>	
		</div>
		<div class="col-md-6">
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
		<div class="col-md-6">
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
	
	<div class="row">
		<div class="col-md-12">
			<h4 class="section-heading" style="margin-top: 0px;color:#B14208;"><span class="glyphicon glyphicon-thumbs-up"></span> Những người đi trước</h4>
		</div>
		<div class="col-md-6">
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
	<hr/>
	<div class="row">
		<div class="col-md-6">
		</div>
		<div class="col-md-3">
			<h3 style="margin-top: 5px;font-weight: bold;">Còn chờ gì nữa?</h3>
			<h4>Tham gia thử sức ngay thôi!</h4>
		</div>
		<div class="col-md-3 right">
			<?php echo $this->Html->link($this->Html->image('facebook-login-button.png', array('class' => 'facebook-btn', 'alt' => __('Login with Facebook'))), $fb_login_url, array('escape' => false)); ?>
		</div>
    </div>
</div>
