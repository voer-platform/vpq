<?php echo $this->Html->css('dashboard.css');?>
<?php echo $this->HTML->css('datepicker.css'); ?>
<?php echo $this->Html->script('bootstrap-datepicker.js');?>
<?php echo $this->Html->script('highcharts.js');?>
<?php echo $this->Html->script('no-data-to-display.src.js');?>
<script>
	$(document).ready(function(){
		$('.time-range-select').click(function(){
			
		});
	});
	
</script>
<div class='dashboard'>
    <h2 class="page-heading heading"><?php echo __('Dashboard');?></h2>
    <div class="dashboard-header clearfix">
        <div class="pull-left clearfix">
            <div class="avatar pull-left">
                <?php echo $this->Html->image($user['image'], array('width' => '60px', 'height' => '60px')); ?>
            </div>
            <div class="user-name pull-right">
                <h4><?php echo $user['first_name'].' '.$user['last_name'] ?></h4>
                <div>
                    <?php echo $this->Html->link(__('Edit Profile'),array('controller'=> 'people','action'=> 'view', $user['id'])); ?>
                </div>
            </div>
        </div>
    </div>
	
    
	<?php echo $this->element('progress_subject'); ?>
	<br/><br/><br/><br/><br/><br/>
</div>

<script type="text/javascript">
	/* Mixpanel initial */
	$('.pls-popover').mouseover(function(){
		mixpanel.track("Show Popover", {"popover_id": $(this).attr('data-type')});
	});

    /**
     * get data from ajax for table
     */
	var currentTimeRangeType 	= 'tentimes';
	var currentTimeStart	= null;
	var currentTimeEnd		= null;
    var currentSubject      = null;
    var currentSubjectID    = null
    var currentCategory     = null;
    var currentCategoryID   = null;
    var curerentLoadAll     = false;
    var currentChecked      = [];

    /**
     * Filters
     */

    $('.checkbox-grade').change(function(){
        console.log('change');
        currentChecked = [];
        $('.checkbox-grade:checkbox:checked').each(function(){
            currentChecked[currentChecked.length] = $(this).attr('grade');
        });

        if(currentChecked.length == 0){
            currentChecked = null;
        }
        else {
            currentChecked = currentChecked.join();
        }

        ajaxLoad(currentSubjectID, currentChecked, currentCategoryID);
		//console.log(currentSubjectID+'-'+currentCategoryID);
		if(currentSubjectID!=null){
			ajaxTable(2, currentSubjectID);
		}
		else if(currentCategoryID!=null){
			ajaxTable(3, currentCategoryID);
		}
		else {
			ajaxTable(1);
		}	
    });
	
	

	/**
	 * Time Range Filters
	 */
	$('.time-range-select, #time-ranger-choose').click(function(){
		if($(this).attr('id')=='time-ranger-choose')
		{
			currentTimeStart = $('#time-range-start').val();
			currentTimeEnd	 = $('#time-range-end').val();
			pr = $(this).parents('.dropdown-menu');
			pr.parent().removeClass('open');
			if(currentTimeStart.length==10 || currentTimeEnd.length==10){			
				$('.time-range-select.btn-primary').removeClass('btn-primary').addClass('btn-default');
				pr.siblings('.time-range-select').addClass('btn-primary').removeClass('btn-default');
			}
			else{
				return false;
			}
			currentTimeRangeType = 'custom';
			ajaxLoad(currentSubjectID, currentChecked, currentCategoryID);
			mixpanel.track("Dashboard Time Filters", {"range": currentTimeRangeType});
		}
		else if($(this).attr('data-range')!='custom'){
			currentTimeRangeType = $(this).attr('data-range');
			//$(this).siblings('.btn-primary')
			$('.time-range-select.btn-primary').removeClass('btn-primary').addClass('btn-default');
			$(this).addClass('btn-primary').removeClass('btn-default');
			ajaxLoad(currentSubjectID, currentChecked, currentCategoryID);
			mixpanel.track("Dashboard Time Filters", {"time_range": currentTimeRangeType});
		}	
		
	});
	
	$('.unclickable-dropdown').click(function(e){
		e.stopPropagation();
	});
	
	$('.datepicker').datepicker({format: "dd/mm/yyyy"}).on('changeDate', function(ev) {
		$(this).datepicker('hide');
	});
	
    /**
     * Tables
     */ 

    function tableClick(){
        var type = parseInt($(this).attr('type'));
        // subject
        if(type == 0){
            currentSubject      = null;
            currentSubjectID    = null;
            currentCategory     = null;
            currentCategoryID   = null;

            // ajax
            ajaxLoad(currentSubjectID, currentChecked, currentCategoryID);

            // breadcrumb
            $('#breadcrumb-list').html("<li class='active'><?php echo __('Subjects'); ?></li>");
            console.log('before' + curerentLoadAll);
            if(curerentLoadAll == false){
                ajaxTable(0);
                $('#load-all-progress').text("<?php echo __('Load Subjects'); ?>");
                curerentLoadAll = true;
            }
            else if(curerentLoadAll == true){
                ajaxTable(1);
                $('#load-all-progress').text("<?php echo __('Load All'); ?>");
                curerentLoadAll = false;
            }
        }
        else if(type == 1){
            currentSubject      = null;
            currentSubjectID    = null;
            currentCategory     = null;
            currentCategoryID   = null;

            // breadcrumb
            $('#breadcrumb-list').html("<li class='active'><?php echo __('Subjects'); ?></li>");

            // ajax
            ajaxLoad(currentSubjectID, currentChecked, currentCategoryID);

            // table
            ajaxTable(1);
        }
        // category
        else if (type == 2){
            currentSubject      = this.text;
            currentSubjectID    = $(this).attr('subject');
            currentCategory     = null;
            currentCategoryID   = null;

            // breadcrumb
            $('#breadcrumb-list').html(
                "<li><a href='javascript:void(0);' class='breadcrumb-link' type='1'><?php echo __('Subjects'); ?></a></li>" + 
                "<li class='active'>" + currentSubject + "</li>");

            // ajax
            ajaxLoad(currentSubjectID, currentChecked, currentCategoryID);

            // table
            ajaxTable(2, $(this).attr('subject'));
        }
        // subcategory
        else if(type == 3){
            currentCategory     = this.text;
            currentCategoryID   = $(this).attr('category')

            // breadcrumb
            $('#breadcrumb-list').html(
                "<li><a href='javascript:void(0);' class='breadcrumb-link' type='1'><?php echo __('Subjects'); ?></a></li>" +
                "<li><a href='javascript:void(0);' class='breadcrumb-link' type='2' subject="+currentSubjectID+">" + currentSubject + "</a></li>" + 
                "<li class='active'>"+ currentCategory + "</li>");

            // ajax
            ajaxLoad(currentSubjectID, currentChecked, currentCategoryID);

            // table
            ajaxTable(3, $(this).attr('category'));
        }
    }
    
    $('.progress-table').click(tableClick);
    $('#load-all-progress').click(tableClick);
    $('.breadcrumb-link').click(tableClick);

    // get table from ajax
    function ajaxTable(type, id){
        var url = "<?php echo Router::url(array('controller'=>'progresses','action'=>'ajaxTable'));?>"
        $.ajax({
            type : 'GET',
            url : url,
            data : {
                type : type,
				grades: currentChecked,
                id : id
            },
            success : function(msg){
                $('#dashboard-table').html(msg);
                $('.progress-table').click(tableClick);
                $('.breadcrumb-link').click(tableClick);   
            }
        });
    }

</script>


<script type="text/javascript">
    /**
     * Ajax on chart data
     */
    var chart           = null;
    var currentGrade    = 0;                //current grade, 0 = all
    // var currentSubject = 0;              // current subject, 0 = all
    var cover           = [];               // current cover
    var rating          = [];               // current rating

    //
    // Draw chart
    //
    //google.load("visualization", "1", {packages:["corechart"]});
    //google.setOnLoadCallback(loadAndDraw);

    // load data for draw chart and draw
    /*function loadAndDraw(){
        console.log('call load ajax');
        ajaxLoad();
    }*/
	//ajaxLoad();
	Highcharts.setOptions({
		lang: {
			noData: 'Chưa có dữ liệu'
		}
	});
	
	chartData = <?php echo $chart; ?>;
	console.log(chartData);
	if(chartData.chart.hasOwnProperty('subject'))
	{
		drawChart(chartData.chart);
	}
	else
	{
		//chart.showLoading('No data to display'); 
	}
	
    function ajaxLoad(subjectID, gradeID, categoryID){
       // console.log('gradeID : ' + gradeID);
       // console.log(gradeID);

        // load chart data by ajax
        var URL = "<?php echo Router::url(array('controller'=>'scores','action'=>'ajaxCallHandler'));?>"
        // get chart data from ajax call
        $.ajax({
            type: 'POST',
            url : URL,
            data: {
                'subject'   : subjectID,
                'gradeID'   : gradeID,
                'categorydID' : categoryID,
				'timeRangeType'	: currentTimeRangeType,
				'timeStart'	:	currentTimeStart,
				'timeEnd'	:	currentTimeEnd
            },
            success : function (msg) {
                if(msg != ''){
                    var jsonData = JSON.parse(msg);
                    drawChart(jsonData.chart.chart);
					//console.log(jsonData.progresses);
					//Loop progresses data
					if(Object.keys(jsonData.progresses).length>0)
					{
						$.each(jsonData.progresses, function(subj_id, subj){
							$('#subject-score-'+subj_id+' .subject-score-number').html(Math.round((subj.sum_progress/subj.sum_total)*100)/10);
							$('.num-pass').html(subj.sum_progress);
							//progressBar = $('#subject-progress-'+subj_id);
							//progressBar.html(subj.sum_progress+'/'+subj.sum_total);
							//progressBar.width((subj.sum_progress/subj.sum_total)*100+'%');
						});
					}
					else
					{
						$('.subject-score-number').html('0');
						$('.num-pass').html('0');
					}
					//Loop covers data
					
					$.each(jsonData.cover, function(subj_id, subj){
						coverBar = $('#subject-cover-'+subj_id);
						numPass = 0;
						if(subj.hasOwnProperty('pass'))
						{
							numPass = subj.pass;
						}
						coverBar.html(Math.round((numPass/subj.total)*100)+'%');
						coverBar.width(Math.round((numPass/subj.total)*100)+'%');
					});
                    //$('#score-overall').text(jsonData.score);
                }
            }
        });
    }

	function drawChart(inputData){
		//console.log(inputData);
		chartContainer = $('.chart').parent();
		if(inputData.hasOwnProperty('subject'))
		{
			$.each(inputData.subject, function(subj_id, subj){
				try{
					$('#chart-subject-'+subj_id).highcharts({
						chart: {
							spacingBottom: 0,
							width: chartContainer.width(),
							height: 120
						},
						title: {
							text: null,
							//x: -20 //center
						},
						xAxis: {
							categories: subj.date,
							labels: {
								autoRotation: false
							}
						},
						yAxis: {
							title: {
								text: null
							},
							tickPixelInterval: 10,
							max: 10,
							min: 0,
							plotLines: [{
								value: 0,
								width: 1,
								color: '#808080'
							}]
						},
						tooltip: {
							valueSuffix: ''
						},
						credits: {
							enabled: false
						},
						legend: {
							enabled: false,
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'middle',
							borderWidth: 0
						},
						series: [{
							name: inputData.title[1],
							data: subj.score
						}]
					});
				}
				catch(e)
				{
					chart = $('#chart-subject-'+subj_id).highcharts();
					while( chart.series.length > 0 ) {
						chart.series[0].remove( false );
					}
					chart.redraw();
				}
			});	
		}
		else
		{
			chart = $('.chart').highcharts();
			while( chart.series.length > 0 ) {
				chart.series[0].remove( false );
			}
			chart.redraw();
		}
	}
    // draw the data
    /*function drawChart(inputData){
        var data = google.visualization.arrayToDataTable(inputData);

        var options = {
            title : '',
            vAxis:{
                format: '#.#',
                maxValue: 10,
                minValue: 0
            },
            hAxis:{
                format: "MM/dd/yy"
            }
        };
        data.addColumn({type: 'string', role: 'annotation'});

        chart = new google.visualization.LineChart(document.getElementById('chart'));
        chart.draw(data, options);
    }*/
	
	$('.category-row td:first-child').click(function(){
		catId = $(this).parent().attr('data-id');
		$('.subcategory-row').not('.subcategory-'+catId).hide();
		$('.subcategory-'+catId).toggle();
	});
	
	$('.hasDetail').popover();
	
</script>