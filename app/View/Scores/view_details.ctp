<!-- <ol class="breadcrumb">
  <li><?php # echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php # echo __('Do test'); ?></li>
</ol> -->
<?php echo $this->element('score_view'); ?>
<?php if(isset($finishTest)){ ?>
	<script>
		mixpanel.track("Finish Test", {
							"test_time": <?=$duration;?>,
							"user_id":<?=$userInfo['id'];?>,
						});
	</script>
<?php } ?>