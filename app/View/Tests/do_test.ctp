<p id='clock-time' style='display:none;'><?php echo $duration; ?></p>
<?php echo $this->element('do_test');?>
<script>
	mixpanel.track("Do Test", {
						"test_time": <?=$duration;?>,
						"user_id":<?=$user['id'];?>,
					});
</script>