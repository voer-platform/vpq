<?php $this->start('meta'); ?>
<meta name="description" content="PLS là một mạng xã hội học trực tuyến, giúp cho học sinh có thể ôn luyện bài học bằng cách làm bài tập và theo dõi tiến độ cũng như chất lượng học tập.">
<meta name="keywords" content="hoc truc tuyen, on thi dai hoc, hoc mai, luyen thi, on thi chat luong, on thi cap 3, lam bai tap, on thi thpt, lam bai thpt, hoc online">
<meta name="robots" content="INDEX,FOLLOW">
<meta property="og:url" content="<?php echo Router::url( $this->here, true ); ?>" /> 
<meta property="og:title" content="<?php echo __('PLS - Mạng xã hội học trực tuyến'); ?>" />
<meta property="og:description" content="<?php echo __('PLS là một mạng xã hội học trực tuyến, giúp cho học sinh có thể ôn luyện bài học bằng cách làm bài tập và theo dõi tiến độ cũng như chất lượng học tập.'); ?>" /> 
<meta property="og:image" content="<?php echo $this->Html->url(Router::url($this->here, true).'img/pls.png'); ?>" />
<?php $this->end(); ?>

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
	h3.news-title {
	  margin-bottom: 5px;
	  font-size:14px;
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
	.topbanner-container {
		position:relative;
		cursor:pointer;
	}
	.topbanner-container:hover .topbanner {
		display:none;
	}	
	.topbanner-container:hover .topbanner-hover {
		display: block;
	}
	.topbanner {
		
		  top: 0;
		  left: 0;
		  z-index: 2;
	}
	.topbanner-hover {
		display:none;
	  top: 0;
	  left: 0;
	  z-index: 1;
	}
	.about {
		border: 1px solid #eee;
		padding: 10px 20px;
		margin-bottom: 20px;
	}
	.about h1 {
		font-size: 18px;
		margin-top: 10px;
	}
</style>
<div class="container">

	<div class="row">
		<div class="col-md-9">
			
			<div class="row">
				<div class="col-md-8">

					<div class="topbanner-container" <?php if(!$user){ ?>data-toggle="modal" data-target="#login-modal" data-section="menu-top"<?php } else { ?>onClick="window.location.href='/people/dashboard';"<?php } ?>>
						<?=$this->Html->image('topbanner02.gif', array('class'=>'fw topbanner', 'alt' => 'Quảng cáo'));?>
						<?=$this->Html->image('topbanner-hover02.gif', array('class'=>'fw topbanner-hover', 'alt' => 'Quảng cáo'));?>
					</div>
					<br/>
					<div class="about">
						<h1 class="text-danger">Học trực tuyến tại PLS Edu</h1>
						<p>PLS là một mạng xã hội học tập, giúp cho học sinh có thể ôn luyện bài học bằng cách làm bài tập và theo dõi tiến độ cũng như chất lượng học tập.</p>
					  </div>
					
					<a href="<?=$this->Html->url('/tin-tuc/', true);?>" style="color:black;"><h2 class="fs-18 inline"><?=$newsletterCategories[0]['NewsletterCategory']['name'];?></h2><span class="pull-right fs-12"><i>Xem thêm ...</i></span></a>
					<hr class="news-hr" />
					<div class="news-container">
						<?php foreach($newsletterCategories[0]['Newsletters'] AS $news){ ?>
							<div class="news-list-item">
								<a href="<?=$this->Html->url('/tin-tuc/'.$news['Newsletter']['slug'], true);?>">
									<img class="news-img" src="<?=$this->Pls->getImageFromContent($news['Newsletter']['content']);?>" width="70" height="70" />
								</a>
								<a href="<?=$this->Html->url('/tin-tuc/'.$news['Newsletter']['slug'], true);?>">
									<h3 class="news-title"><b><?=$news['Newsletter']['title'];?></b></h3>
								</a>	
								<p class="news-time"><?=date('d/m/Y h:i', strtotime($news['Newsletter']['created']));?></p>
								<p class="news-excerpt"><?=substr(strip_tags($news['Newsletter']['content']), 0, stripos(strip_tags($news['Newsletter']['content']), '.')+1);?></p>
							</div>	
						<?php } ?>
					</div>
				</div>
				<div class="col-md-4">
					<?=$this->element('../Portal/rankings');?>
				</div>
			</div>
			
		</div>
		<div class="col-md-3">
			<?=$this->element('../Portal/sidebar');?>
		</div>
	</div>	

</div>	

<script>
	$(document).ready(function(){
		mixpanel.track(
			"Enter Hompage"
		);

		setInterval(function(){
			$(".cta-btn").toggleClass("cta-btn-hover");
		 },1000);
		
	});
	
</script>
