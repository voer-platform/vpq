<?php echo $this->Html->css('clock'); ?>

<div id='clock-container' class='panel panel-default'>
	<div class="panel-body">
		<h4><?php echo __('Time remains').': '; ?></h4>
		<span id='clock-minutes'></span> <?php echo ' '.__('Minutes'); ?>
		<span id='clock-seconds'></span> <?php echo ' '.__('Seconds'); ?>
	</div>
</div>

<script type="text/javascript">
	var seconds = parseInt($('#clock-time').text()) * 60;
	var clockMinutes = $("#clock-minutes");
	var clockSeconds = $('#clock-seconds');
	  
	clockMinutes.html(Math.floor(seconds/60));
	clockSeconds.html(seconds%60);

	setInterval(function(){
		seconds -= 1;
		clockMinutes.html(Math.floor(seconds/60));
		clockSeconds.html(seconds%60);

		if(seconds == 0){
			window.clearInterval();
			alert("<?php echo __('Time\'s up!'); ?>");

			$('#TestAnswersDuration').val(seconds);
			$('#btn-submit').click()
		}
	}, 1000); 
</script>