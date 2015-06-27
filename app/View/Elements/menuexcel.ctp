<?php echo $this->HTML->css('navbar-static-top');?>
<?php Configure::load("pls"); ?>
<div class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php echo $this->Html->image('logo-small.png', array('alt' => 'PLS')); ?>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">		
		<?php if(!empty($user)): ?>
			<?php if($user['role'] == 'admin'): ?>
			  <li><?php echo $this->HTML->link(__('Nhập câu hỏi'), array('controller' => 'partner', 'action' => 'import_excel')); ?></li>
			  <li><?php echo $this->HTML->link(__('Kiểm tra'), array('controller' => 'partner', 'action' => 'check_question')); ?></li>
			<?php endif; ?>
			<?php if($user['role'] == 'editor'): ?>
				 <li><?php echo $this->HTML->link(__('Nhập câu hỏi'), array('controller' => 'partner', 'action' => 'import_excel')); ?></li>
			<?php endif; ?>
			<?php if($user['role'] == 'tester'): ?>
				<li><?php echo $this->HTML->link(__('Kiểm tra'), array('controller' => 'partner', 'action' => 'check_question')); ?></li>
			<?php endif; ?>
		<?php endif; ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		
        <?php if(!empty($user)): ?>
          
          

          <li class="dropdown mglr-10">
            <a href="javascript:void(0);" class="dropdown-toggle profile-img" style='padding-top:15px;' data-toggle="dropdown">
				<!--<?php echo $this->Html->image($user['image'], array('class' => 'profile-img')); ?>-->
				<?php echo $user['fullname']; ?>
				&nbsp;
				<span class="glyphicon glyphicon-cog"></span>
			</a>
            <ul class="dropdown-menu" role="menu">
			  <li><a href="javascript:void(0);" id="change-password2"><?php echo __('Change password'); ?></a></li>
              <li class="divider"></li>
              <li><?php echo $this->Html->link(__('Logout'),array('controller'=> 'Login','action'=> 'logout')); ?></li>
            </ul>
          </li>
		  <!--<li class="dropdown mglr-10">
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
			
		  </li>-->
      	<?php endif; ?>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>
