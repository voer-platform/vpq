<?php echo $this->Html->css('login.css'); ?>

<div class="modal fade" id="modal-login">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><?php echo __('Please Login using...'); ?></h4>
      </div>
      <div class="modal-body">
        <?php echo $this->Html->link($this->Html->image('facebook-login-button.png', array('class' => 'facebook-btn', 'alt' => __('Login with Facebook'))), $fb_login_url, array('escape' => false)); ?>
        <?php echo $this->Html->link($this->Html->image('google-login-button.png', array('class' => 'google-btn', 'alt' => 'Login with Google')), '#', array('escape' => false)); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo __('CLose'); ?></button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->