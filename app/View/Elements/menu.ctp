<?php echo $this->HTML->css('navbar-static-top');?>

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
          			__('VOER'), 
          			'http://voer.edu.vn', 
          			array('class'=>'navbar-brand')); ?>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><?php echo $this->HTML->link(__('Home'), '/'); ?></li>
            <li><?php echo $this->HTML->link(__('About'), '/about'); ?></li>
            <li><?php echo $this->HTML->link(__('Dashboard'), array('controller' => 'people', 'action' => 'dashboard')); ?></li>
            <li><?php echo $this->HTML->link(__('Choose Test'), array('controller' => 'tests', 'action' => 'chooseTest')); ?></li>
            <li><?php echo $this->HTML->link(__('History'), array('controller' => 'people', 'action' => 'history')); ?></li>
            <li><?php echo $this->HTML->link(__('Progress'), array('controller' => 'people', 'action' => 'progress')); ?></li>
            <?php 
              if($this->Session->read('Auth.User')['role'] === 'admin'){
                echo '<li>';
                echo $this->HTML->link(__('Admin'), '/admin');
                echo '</li>';
              }
            ?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php
		        $user = $this->Session->read('Auth.User');
		        if(!empty($user)) {
		            echo "<li>".$this->Html->link($user['first_name']." ".$user['last_name'],"#")."</li>";
		            echo '<li>'.$this->Html->link(__('Logout'),array('controller'=> 'people','action'=> 'logout',1,)).'</li>';
		        }
		        else {
		        	echo '<li>'.$this->Html->link(__('Login'),array('controller'=> 'people','action'=> 'login',1,)).'</li>';
		        	echo " ";
		            echo '<li>'.$this->Html->link(__('Join us'),array( 'controller' => 'people','action' => 'register',1,)).'</li>';
	        	}
    		?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>