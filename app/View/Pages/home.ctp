<?php echo $this->Html->css('home.css');?>

<div class='container'>
    <div class="jumbotron">
        <?php if(empty($this->Session->read('Auth.User'))): ?>
            <h1>PLS</h1>
            <p class="lead"><?php echo __('Join us to access Open, Free, Huge pool of questions in many categories'); ?>!</p>
            <?php echo $this->Html->link(__('Join us!'), '#', array('data-toggle' => 'modal', 'data-target' => '#modal-login', 'class' => "btn btn-lg btn-primary")); ?>
        <?php else: ?>
            <h1><?php echo __('How is your study?'); ?></h1>
        	<p class="lead"><?php  echo 'Do not let your profile die...'; ?></p>
            <?php echo $this->Html->link(__('Take a look'), array('controller' => 'people', 'action' => 'dashboard'), array('class' => "btn btn-lg btn-primary")); ?>
        <?php endif; ?>    
    </div>
</div>