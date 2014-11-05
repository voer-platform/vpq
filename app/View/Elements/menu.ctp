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
      <?php echo $this->HTML->link(
      			__(Configure::read('PLS.Name')), 
      			'/', 
      			array('class'=>'navbar-brand')); ?>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <!-- if logged in user -->
        <?php if(!empty($user) ): ?>
          <li><?php echo $this->HTML->link(__('Dashboard'), array('controller' => 'people', 'action' => 'dashboard')); ?></li>
          <li><?php echo $this->HTML->link(__('History'), array('controller' => 'people', 'action' => 'history')); ?></li>
          <li><?php echo $this->HTML->link(__('Progress'), array('controller' => 'people', 'action' => 'progress')); ?></li>
          <li><?php echo $this->HTML->link(__('About'), '/about'); ?></li>
        <?php endif; ?>
       
        <!-- if is admin -->
        <?php if($user['role'] === 'admin' || $user['role'] === 'editor'): ?>
          <li><?php echo $this->HTML->link(__('Admin'), array('controller' => 'Admin', 'action' => 'index')); ?></li>
        <?php endif; ?> 
       
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php if(!empty($user)): ?>
          <li><?php echo $this->Html->link($this->Html->image($user['image'], array('class' => 'profile-img')), array('controller' => 'people', 'action' => 'dashboard'), array('escape' => false, 'class' => 'profile-img') ); ?></li>
          <li><?php echo $this->Html->link($user['first_name']." ".$user['last_name'],array('controller' => 'people', 'action' => 'dashboard')); ?></li> 
          
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><?php echo $this->Html->link(__('Account info'),array('controller'=> 'people','action'=> 'view', $user['id'])); ?></li>
              <li><?php echo $this->HTML->link(__('Dashboard'), array('controller' => 'people', 'action' => 'dashboard')); ?></li>
              <li class="divider"></li>
              <li><?php echo $this->Html->link(__('Logout'),array('controller'=> 'people','action'=> 'logout')); ?></li>
            </ul>
          </li>
        <?php else: ?>
          <li><?php //echo $this->Html->link(__('Login'), '#', array('data-toggle' => 'modal', 'data-target' => '#modal-login')); ?></li>
      	<?php endif; ?>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>