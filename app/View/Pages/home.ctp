<?php echo $this->Html->css('home.css');?>

<div class='container'>
    <?php if(empty($user)): ?>
        <div class='row'>
            <center>
                <h1 id='name'>PLS</h1>
            <p id = 'slogan'><?php echo __('Join us to access Open, Free, Huge pool of questions in many categories'); ?>!</p>
            </center>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-4'>
                <center>
                    <h1><?php echo __('Login Using'); ?></h1>
                </center>
                <hr>
                <center>
                    <?php echo $this->Html->link($this->Html->image('facebook-login-button.png', array('class' => 'facebook-btn', 'alt' => __('Login with Facebook'))), $fb_login_url, array('escape' => false)); ?>
                    <?php echo $this->Html->link($this->Html->image('google-login-button.png', array('class' => 'google-btn', 'alt' => 'Login with Google')), '#', array('escape' => false)); ?>
                </center>
            </div>
            <div class = "col-lg-8 about_us" id = 'about_us_container' >
                <?php echo $this->element('about_us'); ?>
            </div>
        </div>

    <?php else: ?>
        <div class="jumbotron">
            <h1><?php echo __('How is your study?'); ?></h1>
            <p class="lead"><?php  echo __('Keep it up!'); ?></p>
            <?php echo $this->Html->link(__('Take a look'), array('controller' => 'people', 'action' => 'dashboard'), array('class' => "btn btn-lg btn-primary")); ?>
        </div> 
    <?php endif; ?>  
</div>