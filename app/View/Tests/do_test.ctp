<!-- <ol class="breadcrumb">
  <li><?php # echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php #echo __('Do test'); ?></li>
</ol> -->
<p id='clock-time' style='display:none;'><?php echo $duration; ?></p>
<?php echo $this->element('do_test');?>