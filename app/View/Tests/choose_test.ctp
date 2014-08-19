<?php echo $this->Html->css('choose_test.css'); ?>

<ol class="breadcrumb">
  <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php echo __('Choose Test'); ?></li>
</ol>

<div class="chooseTest">
	<h2><?php echo __('Choose time for the test')?></h2>
	<?php echo __('Test').': '.$subject; ?>
	<div class='btn-groups'>
		<?php
			$times = array(5, 10, 15, 30, 60);
			foreach($times as $time){
				echo $this->Html->link($time . ' '. __('mins'), array('controller' => 'Tests', 'action' => 'doTest', $time, $subject), array('class' => 'btn btn btn-primary btn-lg'));
			}
		?>
	</div>
</div>
