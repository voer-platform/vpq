<?php echo $this->Html->css('performance_details.css');?>

<div class='performance'>
	<h2>Performance on latest 10 tests on <?php echo ucfirst($category); ?></h2>
	<div id='chart'></div>

</div>
<?php echo "<p class='fade' id='js-category'>".$category."</p>";?>

<?php echo $this->HTML->script('https://www.google.com/jsapi'); ?>
<?php echo $this->HTML->script('chart.js'); ?>