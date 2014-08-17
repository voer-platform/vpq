<?php echo $this->Html->css('performance_details.css');?>

<div class='performance'>
	<h2>Latest performance on <?php echo ucfirst($subject); ?></h2>
	<div id='chart'></div>

</div>
<?php echo "<p class='fade' id='js-subject'>".$subject."</p>";?>

<?php echo $this->HTML->script('https://www.google.com/jsapi'); ?>
<?php echo $this->HTML->script('chart.js'); ?>