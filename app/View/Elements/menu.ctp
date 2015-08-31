<?php echo $this->HTML->css('navbar-static-top');?>
<?php Configure::load("pls"); ?>
<div class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container menu-container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
      </button>
	  <a href="<?=$this->HTML->url('/');?>">
      <?php echo $this->Html->image('logo-small.png', array('alt' => 'PLS')); ?>
	  </a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
		<li><?php echo $this->HTML->link(__('Home'), '/'); ?></li>
        <!-- if logged in user -->
        <?php if(!empty($user) ): ?>
          <li><?php echo $this->HTML->link(__('Dashboard'), array('controller' => 'people', 'action' => 'dashboard')); ?></li>
          <li><?php echo $this->HTML->link(__('History'), array('controller' => 'people', 'action' => 'history')); ?></li>
          <li><?php echo $this->HTML->link(__('Faq'), array('controller' => 'faqs', 'action' => 'userIndex')); ?></li>		  
        <?php endif; ?>

		<li><?php echo $this->HTML->link(__('About'), '/gioi-thieu'); ?></li>
		 <?php if(!empty($user) ): ?>
		<!--<li id='napthe'><a href="<?php echo $this->Html->url(array('controller'=> 'rechargeCard')); ?>">Nạp thẻ</a></li>-->
		<?php endif; ?>
		
		<li><?php echo $this->HTML->link(__('Ranking'), array('controller' => 'ranking', 'action' => 'index')); ?></li>
		
		<!-- if is admin -->
        <?php if($user['role'] === 'admin' || $user['role'] === 'editor'): ?>
          <li><?php echo $this->HTML->link(__('Admin'), array('controller' => 'Admin', 'action' => 'index')); ?></li>
        <?php endif; ?>
		
      </ul>
      <ul class="nav navbar-nav navbar-right">
		
        <?php if(!empty($user)): ?>
          
          

          <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle profile-img" data-toggle="dropdown">
				<?php echo $this->Html->image($user['image'], array('class' => 'profile-img')); ?>
				<?php echo $user['fullname']; ?>
				&nbsp;
				<span class="caret"></span>
			</a>
            <ul class="dropdown-menu" role="menu">
              <li><?php echo $this->Html->link(__('Account info'),array('controller'=> 'people','action'=> 'view', $user['id'])); ?></li>
              <li><?php echo $this->HTML->link(__('Dashboard'), array('controller' => 'people', 'action' => 'dashboard')); ?></li>
			  <li><a href="javascript:void(0);" id="change-password"><?php echo __('Change password'); ?></a></li>
              <li class="divider"></li>
              <li><?php echo $this->Html->link(__('Logout'),array('controller'=> 'people','action'=> 'logout')); ?></li>
            </ul>
          </li>
		  <li class="dropdown mglr-10">
			<a href="javascript:void(0);" id="open-notifications" class="dropdown-toggle pd10" data-unread="<?php echo $unread; ?>" data-toggle="dropdown">
				<div id="notifications-toggle">
					<?php if($unread){ ?>
					<span class="notify-counter"><?php echo $unread; ?></span>
					<?php } ?>
					<span class="glyphicon glyphicon-bell"></span>
				</div>	
			</a>	
				<ul class="dropdown-menu notify-menu" role="menu">
				<div class="notify-scroll">
					<?php echo $this->element('notification'); ?>
				</div>	
				</ul>
			
		  </li>
        <?php else: ?>
			<li><a href="javascript:void(0); "class="login-open" data-toggle="modal" data-target="#login-modal" data-section="menu-top">Đăng nhập - Đăng ký</a></li>
      	<?php endif; ?>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>
