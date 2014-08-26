<?php if($ajax): ?>
	<?php echo $result; ?>
<?php else: ?>
<?php echo $this->Html->css('performance_details.css');?>

<ol class="breadcrumb">
  <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php echo __('Details'); ?></li>
</ol>

<div class='performance'>
	<h2><?php echo __('Latest performance on').' '.$this->Name->subjectToName($subject); ?></h2>
	<div id='chart'></div>

</div>
<?php echo "<p class='fade' id='js-subject'>".$subject."</p>";?>

<?php echo $this->HTML->script('https://www.google.com/jsapi'); ?>

<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);

	var ajaxData = null;
	var subject = $('#js-subject').text();
	// var URL = '../Progresses/ajax';

	// get chart data from ajax call
	$.ajax({
	    type: 'POST',
	    url : '',
	    async : false,
	    data: {
	        'chartType' : 'ggChart',
	        'subject'  : subject
	    },
	    success : function (msg) {
	        if(msg != ''){
	            ajaxData = JSON.parse(msg);
	        }
	        else {
	            ajaxData = [];
	        }
	    }
	});

	// draw the data
	function drawChart(id){
	    var data = google.visualization.arrayToDataTable(ajaxData);

	    var options = {
	        
	        // title: 'Latest performace on ' + subject.charAt(0).toUpperCase() + subject.slice(1),
	        title : '',
	        vAxis:{
	            format: '##%',
	            maxValue: 1,
	            minValue: 0
	        },
	        hAxis:{
	        	format: "MM/dd/yy"
	        }
	    };
	    data.addColumn({type: 'string', role: 'annotation'});

	    var chart = new google.visualization.LineChart(document.getElementById('chart'));
	    chart.draw(data, options);
	}
</script>
<?php endif; ?>