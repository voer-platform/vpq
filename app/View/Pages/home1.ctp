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
			<br/>
			<?php echo $this->Html->image('homefake.png'); ?>
		</div>
	</div>
</div>
