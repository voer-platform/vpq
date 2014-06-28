<?php echo $this->Html->css('login.css')?>

<div class="container">
    <?php echo $this->Session->flash('auth'); ?>
    <?php echo $this->Form->create('Person', array('class'=>'form-signin')); ?>
        <h2 class="form-signin-heading">Please sign in</h2>
        <?php   echo $this->Form->input('username', array('class' => 'form-control', 'placeholder'=>'Email address', 'required'=>'', 'autofocus'=>''));
                echo $this->Form->input('password', array('class' => 'form-control', 'placeholder'=>'Password', 'required'=>'', 'autofocus'=>'')); ?>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <!-- <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button> -->
    <?php echo $this->Form->end(array('label' => 'Login', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
</div>