<?php echo $this->Html->css('dashboard.css');?>
<?php echo $this->Html->script('highcharts.js');?>
<?php echo $this->Html->script('no-data-to-display.src.js');?>
<div id="rechargecard" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style='margin-top:100px;'>
            <div class="modal-body" style='text-align:center;padding-top: 0px;'>				
				<div class='row'>
					<div class='row' style='margin:0px;padding-left:10px;padding-right:10px;padding-top:15px;'>
					<?php echo $this->Html->image('Xu.png',array('style'=>'width:100px;height:100px;')) ?>						
					<span style='color:#428bca;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:18pt;'>Trời ơi hết xu rồi</span>
					<hr style='margin-top:7px;margin-bottom:5px;'/>
					</div>
					<div  class='row' style='margin:0px;padding:10px;'>	
						<p style='font-size:12pt;'>Đừng lo lắng, bạn hãy chọn 1 trong 2 hình thức dưới để tăng xu ngay nhé.</p>
					</div>
					<div  class='row' style='margin:0px;'>						
						<div class='col-sm-12' style='padding-left:10px;padding-right:10px;'>								
							<div class='col-sm-6' style='padding-left:0px;padding-right:5px;'>
							<a class='btn btn-danger bl fw' href="<?php echo $this->Html->url(array('controller'=> 'rechargecard')); ?>"><span class='glyphicon glyphicon-usd'></span> Nạp thẻ</a>
							</div>
							<div class='col-sm-6' style='padding-left:5px;padding-right:0px;'>
							<a class='btn btn-success bl fw' href="javascript:void(0);" onclick="FBInvite()"><span class='glyphicon glyphicon-send'></span>&nbsp;&nbsp;<?php echo _('Invite'); ?></a>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<div class='dashboard'>
	<div class="page-heading heading">
		<div class='row' >
			<div class='col-sm-12'">
				<!--<div class='row'>
					<div class="col-sm-9">
						<h2 style='margin:0px;'><?php echo __('Dashboard');?></h2>
					</div>
					<div class='col-sm-3' style='width:250px; float:right;'>
						<div class='row' style="margin-top:15px;">							
							<div class="fb-share-button col-sm-6" data-href="<?php echo Router::url($this->here, true); ?>" data-layout="button_count"></div>
							<div class='col-sm-6'>
							<a class='btn btn-success bl fw' href="javascript:void(0);" id="invite-btn" onclick="FBInvite()" style="padding:0px;margin:0px;width:100px;float:right;"><span class='glyphicon glyphicon-send'></span>&nbsp;&nbsp;<?php echo __('Invite'); ?></a>
							</div>
						</div>
					</div>			
				</div>-->
				<div class='row' style='margin-left:0px;'>
					<h2 style='margin:0px;'><?php echo __('Dashboard');?></h2>
				</div>
				<br/>
				<div class='row' style='margin-right:0px;'>
					<div class='col-sm-9' style='width:77%'>
						<div class="dashboard-header clearfix">
							<div class="pull-left clearfix">
								<div class="avatar pull-left">
									<?php echo $this->Html->image($user['image'], array('width' => '60px', 'height' => '60px')); ?>
								</div>
								<div class="user-name pull-right">
									<h4><?php echo $user['fullname']; ?></h4>
									<div>
										<?php echo $this->Html->link(__('Edit Profile'),array('controller'=> 'people','action'=> 'view', $user['id'])); ?>
									</div>
								</div>
							</div>
							<div class="pull-right clearfix">
								<div class="fb-like" data-href="https://www.facebook.com/pls.edu.vn" data-width="280px" data-layout="standard" data-action="like" data-show-faces="true" data-share="false"></div>
							</div>
						</div>
					</div>
					<div class='col-sm-3 box' style='float:right;padding-bottom:0;width:22%'>
						<div class='row'> 					
							<div  class='row' style='margin:0px;padding-left:10px;padding-right:10px;'>	
								<p style='font-size:13px;margin-top:5px;margin-bottom:5px;color:red;'>Hãy rủ bạn ôn thi miễn phí cùng PLS.</p>
								<hr style='border-top:2px solid #81AFD1; margin-top:7px;margin-bottom:5px;'/>
							</div>
							<div  class='row' style='margin:0px;margin-bottom:5px;'>						
								<div class='col-sm-12' style='padding-left:10px;padding-right:10px;padding-bottom:2px;padding-top:7px;'>							
									<div class="fb-share-button col-sm-6" data-href="<?php echo Router::url($this->here, true); ?>" data-layout="button_count" style='padding-left:0px;'></div>
									<div class='col-sm-6' style='padding-left:5px;padding-right:0px;'>
									<a class='btn btn-success bl fw' href="javascript:void(0);" id="invite-btn" onclick="FBInvite()" style="padding:0px;margin:0px;width:100px;float:right;"><span class='glyphicon glyphicon-send'></span>&nbsp;&nbsp;<?php echo __('Invite'); ?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--<div class="col-sm-3 box" style='float:right;padding-bottom:0;'>
				<div class='row'> 
					<div class='row' style='margin:0px;padding-left:10px;padding-right:10px;padding-top:9px;'>
					<?php echo $this->Html->image('coin.png',array('style'=>'width:40px;height:30px;vertical-align:bottom;')) ?>
					<span style='color:#428bca;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size:18px;'>Xu:</span> <span style='color:red;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size:18px'><?php echo $coin; ?></span>
					<hr style='border-top:2px solid #81AFD1; margin-top:7px;margin-bottom:5px;'/>
					</div>
					<div  class='row' style='margin:0px;padding-left:10px;padding-right:10px;'>	
						<p style='font-size:11px;'>Bạn hãy chọn 1 trong 2 hình thức dưới để tăng xu.</p>
					</div>
					<div  class='row' style='margin:0px;margin-bottom:5px;'>						
						<div class='col-sm-12' style='padding-left:10px;padding-right:10px;padding-bottom:7px;'>
							<div class='col-sm-6' style='padding-left:0px;padding-right:5px;'>
							<a class='btn btn-danger bl fw' href="<?php echo $this->Html->url(array('controller'=> 'rechargecard')); ?>"><span class='glyphicon glyphicon-usd'></span> Nạp thẻ</a>
							</div>
							<div class='col-sm-6' style='padding-left:5px;padding-right:0px;'>
							<a class='btn btn-success bl fw' href="javascript:void(0);" id="invite-btn" onclick="FBInvite()"><span class='glyphicon glyphicon-send'></span>&nbsp;&nbsp;<?php echo __('Invite'); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>-->			
		</div>
	</div>    
<?php if(isset($overviews)){ ?>
	<?php if(!is_numeric($overviews[0]['Ranking']['score'])){ ?>
	<br/>
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
		<?php /*foreach($overviews AS $subj){ ?>
			<?php
				$hasScore = '';
				if($subj['Ranking']['score'])
				{
					$action_url = $this->Html->url(
										array(
											'controller' => 'People', 
											'action' => 'dashboard', 
											$subj['Subject']['id'],
										)
									);
					$hasScore = 'has-score';
				}
				else
				{
					$action_url = $this->Html->url(
										array(
											'controller' => 'Tests', 
											'action' => 'chooseTest', 
											$subj['Subject']['id'],
										)
									);
				}
			?>	
			<div class="col-md-2">
				<div class="subject-token <?php echo $hasScore; ?>">
					<p class="subject-name"><?php echo $subj['Subject']['name']; ?></p>
					<div class="subject-score">
						<?php echo ($subj['Ranking']['score'])?$subj['Ranking']['score']:'?'; ?>
						<span class="subject-score-text">Điểm</span>
					</div>	
					<br/>
					<a class="btn btn-default btn-sm" href="<?php echo $action_url; ?>">
					<?php if($subj['Ranking']['score']){ ?>
						<span class="glyphicon glyphicon-info-sign"></span> Chi tiết môn học</a>
					<?php } else { ?>
						<span class="glyphicon glyphicon-play"></span> Kiểm tra</a>
					<?php } ?>	
				</div>	
			</div>
		<?php } */ ?>
		
	</div>
	<br/>
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
				$rankingInfo = 'Bạn đang đứng vị trí số '.$rankings[$subj['Subject']['id']].' trong bảng xếp hạng của môn '.$subj['Subject']['name'];
			}
			else
			{
				$rankingInfo = 'Bạn chưa có tên trong bảng xếp hạng của môn '.$subj['Subject']['name'];
			}
	?>
		<div class="panel panel-default">
		<div class="panel-body">
		<div class="row">
			<div class="col-md-2" style="width: 21%;">
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
					?>" class="btn btn-sm btn-primary btn-test pls-test-btn fw bl left" data-teston="subject">
						<span class="glyphicon glyphicon-play"></span> <?php echo __('Do test on this'); ?>
					</a>
					
					
				</div>		
			<div class="col-md-4 <?php echo ($noTest)?'blur3':''; ?>" style="border-left: solid 1px #C0D0E0;width:33%;">
				<a class="nudl no-style" href="<?php 
						echo $this->Html->url(
							array(
								'controller' => 'People',
								'action'	=>	'dashboard',
								$subj['Subject']['id']
							)
						); 
					?>">
					<div style="display: inline-block;">
						<span class="subject-score" style="border-color:<?php echo $this->Name->rankColor($score); ?>" id="subject-score-<?php echo $subj['Subject']['id']; ?>">
							<span class="subject-score-number"><?php echo $score; ?></span>
							<span class="subject-score-text" style="color:<?php echo $this->Name->rankColor($score); ?>"><?php echo __('Score'); ?></span>
						</span>
					</div>
				</a>	
				<div style="display: inline-block;float:right;width: 65%;">
					<?php echo __('Tiến trình học tập'); ?> <a href="javascript:void(0);" class="hasDetail pull-right pls-popover" data-type="Progress Popover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="Được tính bằng tỷ lệ số bài học đã thực hành trên tổng số bài của môn học này"><span class="glyphicon glyphicon-question-sign"></span></a>
					
					<div class="progress" style="margin: 10px 0;">
						<div class="progress-bar progress-bar-striped" id="subject-cover-<?php echo $subj['Subject']['id']; ?>" style="width: <?php echo $completeness; ?>%;" role="progressbar" aria-valuenow="<?php echo $completeness; ?>" aria-valuemin="0" aria-valuemax="100" id="preogressbar-cover"><?php echo $completeness.'%'; ?></div>
					</div>
					
					Bạn đã thực hành <b class="num-pass"><?php echo $pass; ?></b> trên tổng số <b class="num-total"><?php echo $total; ?></b> bài học
				</div>
			</div>
			<div class="col-md-6 <?php echo ($noTest)?'blur3':''; ?>" style="width:46%;">
				<div class="chart" id="chart-subject-<?php echo $subj['Subject']['id']; ?>"></div>
			</div>
		</div>	
		</div>
		</div>
	<?php } ?>
	
 <?php } else { ?>   
	<?php echo $this->element('progress_subject'); ?>
	<br/><br/><br/><br/><br/><br/>


<script type="text/javascript">
	/* Mixpanel initial */
	$('.pls-popover').mouseover(function(){
		mixpanel.track("Show Popover", {"popover_id": $(this).attr('data-type')});
	});
	
	mixpanel.track_links(".pls-test-btn", "Dashboard Test", function(e){
		return {"test_on": $(e).attr('data-teston')};
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
<?php } ?>	
</div>

<script type="text/javascript">
	var over=<?php echo $over ?>;
	var coin=<?php echo $coin ?>;
	$(document).ready(function(){
		if(coin==0 && over==0){
			$('#rechargecard').modal({
					backdrop: true
				});
		}
	});
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
	
</script>
