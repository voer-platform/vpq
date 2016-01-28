<?php echo $this->Html->css('dashboard.css?v=1.5');?>
<?php echo $this->Html->script('highcharts.js');?>
<?php echo $this->Html->script('no-data-to-display.src.js');?>

<div class="check-phone hidden-xs"></div>

<div class='dashboard'>
  

	
	<div class="row">
		<div class="col-md-9">
			<?php if ($announcement) { ?>
				
			<div class="alert alert-warning">
				<?=$announcement[0]['Announcement']['content'];?>
			</div>
			<?php } ?>
			<ol class="breadcrumb">
			  <li><a href="<?=$this->Html->url(array('controller'=>'people', 'action'=>'dashboard'));?>"><span class="glyphicon glyphicon-th"></span> Danh sách môn học</a></li>
			  <?php if(isset($subjectName)){ ?>
				<li><a href="javascript:void(0);"><?=$subjectName;?></a></li>
			  <?php } ?>	
			</ol>
			<?php if(isset($overviews)){ ?>
				<?php if(!is_numeric($overviews[0]['Ranking']['score'])){ ?>
				<div class="alert alert-success">
					<div class="row">
						<div class="col-md-12">
							<span class="glyphicon glyphicon-hand-right "></span>
							<strong><?php echo __('Welcome to Personal Learning System!'); ?></strong>
							<br/>
							<?php echo __('You have no progress at all, please click Test Button to begin your learning process'); ?>
						</div>
					</div>	
				</div>
				<?php } ?>
			
				<div class="row">
					<?php  
						foreach($overviews as $key => $subj){
							$noTest = (is_numeric($subj['Ranking']['score']))?0:1;
							$score  = ($subj['Ranking']['score'])?$subj['Ranking']['score']:0;
							$name   = $this->Name->determineRank($score);
							$pass = (isset($cover[$subj['Subject']['id']]['pass']))?$cover[$subj['Subject']['id']]['pass']:0;
							$total = (isset($cover[$subj['Subject']['id']]['total']))?$cover[$subj['Subject']['id']]['total']:0;
							$completeness = ($pass)?round(($cover[$subj['Subject']['id']]['pass']/$cover[$subj['Subject']['id']]['total'])*100):0;
							if(isset($rankings[$subj['Subject']['id']]))
							{
								$rankingInfo = 'Bạn đang đứng vị trí số '.$rankings[$subj['Subject']['id']].' trong bảng xếp hạng điểm của môn '.$subj['Subject']['name'];
							}
							else
							{
								$rankingInfo = 'Bạn chưa có tên trong bảng xếp hạng của môn '.$subj['Subject']['name'];
							}
					?>
						<div class="col-md-4 col-sm-4">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
												<a class="nudl no-style" href="<?php 
													echo $this->Html->url(
														array(
															'controller' => 'People',
															'action'	=>	'dashboard',
															$subj['Subject']['id']
														)
													); 
												?>">
													<h2 class="dashboard-subject-name"><?php echo $this->Html->image('subjects/'.$subj['Subject']['id'].'.png'); ?> <?php echo $subj['Subject']['name']; ?></h2>
												</a>
												<span class="badge badge-info overviews-ranking hasDetail" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="<?=$rankingInfo;?>">
													<span class="glyphicon glyphicon-star"></span>
													<?=(isset($rankings[$subj['Subject']['id']]))?$rankings[$subj['Subject']['id']]:0;?>
												</span>
												<p>
												<a class="btn btn-default btn-sm bl wa left" href="<?php 
													echo $this->Html->url(
														array(
															'controller' => 'People',
															'action'	=>	'dashboard',
															$subj['Subject']['id']
														)
													); 
												?>">
													<span class="glyphicon glyphicon-info-sign"></span> Chi tiết môn học
												</a>
												</p>
												<a href="<?php 
													echo $this->Html->url(
														array(
															'controller' => 'Tests', 
															'action' => 'chooseTest', 
															$subj['Subject']['id'],
														)
													); 
												?>" class="btn btn-sm btn-orange btn-test pls-test-btn fw bl left" data-teston="subject">
													<span class="glyphicon glyphicon-play"></span> <?php echo __('Do test on this'); ?>
												</a>
												
												
										</div>	
									</div>	
									<div class="row <?php echo ($noTest)?'blur3':''; ?>">
										<hr class="mgt-10 mgb-10" />
										
										<div class="col-md-4 col-sm-4 col-xs-3 pdr-5">
											<a class="nudl no-style" href="<?php 
													echo $this->Html->url(
														array(
															'controller' => 'People',
															'action'	=>	'dashboard',
															$subj['Subject']['id']
														)
													); 
												?>">
												
												<div class="subject-score" style="background-color:<?php echo $this->Name->rankColor($score); ?>" id="subject-score-<?php echo $subj['Subject']['id']; ?>">
													<div style="position: absolute;width: 100%;height: 100%;display: block;top: 0;left: 0;padding: 2px;border-radius: 50%;">
															<div style="width: 100%;height: 100%;display: block;background-color: #fff;border-radius: 50%;">
																	<span class="subject-score-number"><?php echo $score; ?></span>
																	<span class="subject-score-text" style="color:<?php echo $this->Name->rankColor($score); ?>"><?php echo __('Score'); ?></span>
															</div>
														
													</div>
													
												</div>
												
											</a>	
										</div>	
										<div class="col-md-8 col-sm-8 col-xs-9 fs-12 pdl-5">
											<?php echo __('Tiến trình học tập'); ?> <a href="javascript:void(0);" class="hasDetail pull-right pls-popover" data-type="Progress Popover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="Được tính bằng tỷ lệ số bài học đã thực hành trên tổng số bài của môn học này"><span class="glyphicon glyphicon-question-sign"></span></a>
											
											<div class="progress" style="margin: 7px 0;">
												<div class="progress-bar progress-bar-striped" id="subject-cover-<?php echo $subj['Subject']['id']; ?>" style="width: <?php echo $completeness; ?>%;" role="progressbar" aria-valuenow="<?php echo $completeness; ?>" aria-valuemin="0" aria-valuemax="100" id="preogressbar-cover"><?php echo $completeness.'%'; ?></div>
											</div>
											
											Đã thực hành <b class="num-pass"><?php echo $pass; ?></b> / <b class="num-total"><?php echo $total; ?></b> bài
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 <?php echo ($noTest)?'blur3':''; ?> mgt-10">
											<div class="chart" data-enabled-label="false" data-chart-height="70" data-spacing-bottom="5" id="chart-subject-<?php echo $subj['Subject']['id']; ?>"></div>
										</div>
									</div>	
								</div>

								<?php if(!$subj['Subject']['enabled']){ ?>
									<div class="subject-overlay"><p>Đang cập nhật</p></div>
								<?php } ?>
							</div>
						</div>	
					<?php } ?>
				</div>	
				<?php } else { ?>   
					<?php echo $this->element('progress_subject'); ?>
				<?php } ?>	
		</div>	
		<div class="col-md-3 hidden-sm">
			<?=$this->element('../People/sidebar');?>
		</div>
	</div>	

</div>

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
                'subjectID'   : subjectID,
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
					/*
					//console.log(jsonData.progresses);
					//Loop progresses data
					if(Object.keys(jsonData.progresses).length>0)
					{
						$.each(jsonData.progresses, function(subj_id, subj){
							score = Math.round((subj.sum_progress/subj.sum_total)*100)/10;
							$('#subject-score-'+subj_id+' .subject-score-number').html(score);
							$('#subject-score-'+subj_id+' .subject-score-text').css({'color':rankColor(score)});
							$('#subject-score-'+subj_id).css({'border-color':rankColor(score)});
							
							//progressBar = $('#subject-progress-'+subj_id);
							//progressBar.html(subj.sum_progress+'/'+subj.sum_total);
							//progressBar.width((subj.sum_progress/subj.sum_total)*100+'%');
						});
					}
					else
					{
						$('.subject-score-number').html('0');
					}
					//Loop covers data
					if(Object.keys(jsonData.cover).length>0)
					{
						$.each(jsonData.cover, function(subj_id, subj){
							coverBar = $('#subject-cover-'+subj_id);
							numPass = 0;
							if(subj.hasOwnProperty('pass'))
							{
								numPass = subj.pass;
							}
							$('.num-pass').html(numPass);
							coverBar.html(Math.round((numPass/subj.total)*100)+'%');
							coverBar.width(Math.round((numPass/subj.total)*100)+'%');
						});
                    } else {
						$('.num-pass').html('0');
					}
					*/
                }
            }
        });
    }

	function rankColor($score){
		if(9 <= $score && $score <= 10){
            return '#5CB85C';
        }
        else if( 8 <= $score && $score < 9){
           return '#337AB7';
        }
        else if(6.5 <= $score && $score < 8){
            return '#5BC0DE';
        }
        else if(5 <= $score && $score < 6.5){
           return '#F0AD4E';
        }
        else if(3.5 <= $score && $score < 5){
            return '#D9534F';
        }
        else if (0 <= $score && $score < 3.5){
            return '#777';
        }
	}
	
	function drawChart(inputData){
		//console.log(inputData);
		chartContainer = $('.chart').parent();
		if(inputData.hasOwnProperty('subject'))
		{
			$.each(inputData.subject, function(subj_id, subj){
				chartEl = $('#chart-subject-'+subj_id);
				spaceBottom = (chartEl.attr('data-spacing-bottom'))?parseInt(chartEl.attr('data-spacing-bottom')):0;
				chartHeight = (chartEl.attr('data-chart-height'))?parseInt(chartEl.attr('data-chart-height')):120;
				
				var enableLables = (chartEl.attr('data-enabled-label') === "false")?false:true;
				try{
					chartEl.highcharts({
						chart: {
							//spacing: [0, 0, 0, 0],
							width: chartContainer.width(),
							height: chartHeight,
							//margin: [0, 0, 0, 30]
							spacingLeft: 0,
							spacingRight: 1,
							spacingBottom: spaceBottom,
							showAxes: true,
							plotBorderColor: '#E6E6E6',
							plotBorderWidth: 1
						},
						title: {
							text: null,
							//x: -20 //center
						},
						xAxis: {
							categories: subj.date,
							tickLength: 0,
							//minRange: 0.5,
							labels: {
								autoRotation: false,
								enabled: enableLables
							}
						},
						yAxis: {
							title: {
								text: null
							},
							tickPositions: [0, 5, 10],
							labels: {
								x: 3,
								y: 3
							},
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
	
	//Check phone device on click test button
	/*if($('.check-phone').is(':visible')==true)
	{
		mixpanel.track_links(".pls-test-btn", "Dashboard Test", function(e){
			return {"test_on": $(e).attr('data-teston')};
		});
	} else {
		$(document).on('click', '.pls-test-btn', function(){
			// window.location.href = PLS.ajaxUrl+'mobile';
			alert('PLS chưa hỗ trợ mobile, hãy sử dụng máy tính để làm bài bạn nhé!');
			return false;
		});
	};*/
	
	
	$('.category-row td:first-child').click(function(){
		catId = $(this).parent().attr('data-id');
		$('.subcategory-row').not('.subcategory-'+catId).hide();
		$('.subcategory-'+catId).toggle();
	});
	
	$('.hasDetail').popover();
	
	function FBInvite(){
		FB.ui({
			method: 'apprequests',
			title: 'Mời bạn bè tham gia PLS',
			message: 'Mời bạn bè tham gia PLS',
			new_style_message: true
		},function(response){
			$.ajax({
				type: 'POST',
				url: '<?php echo $this->Html->url(
							array(
								'controller' => 'People', 
								'action' => 'invite'
							)
						); ?>',
				data: {'frs': response.to},
				success: function(){
					mixpanel.track("Invite friends", {"user_id": "<?php echo $user['id']; ?>"});
				}
			});
		});
	}
	
	function FBShare(){
		FB.ui({
		  method: 'share',
		  href: '<?php echo Router::url('/', true); ?>',
		}, function(response){
			mixpanel.track("Share Facebook", {"user_id": "<?php echo $user['id']; ?>", "share_page": "Home Page"});
		});
	}
	
</script>
