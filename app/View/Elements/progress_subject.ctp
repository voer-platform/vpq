
<?php if( !empty($progresses) ){ ?>
	
	
	<?php  
		foreach($progresses as $key => $progress){
			$score  = round($progress['Progress']['sum_progress']/$progress['Progress']['sum_total'],2)*10;
			$name   = $this->Name->determineRank($score);
	?>
		<div class="panel panel-default" style="background:#FCFCFC;">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-12 mgbt-xs-10">
						<h2 class="dashboard-subject-name"><?php echo $this->Html->image('subjects/'.$progress['Subject']['id'].'.png'); ?> <?php echo $progress['Subject']['name']; ?></h2>
							<p>
								<!--
								<a href="javascript:void(0);" 
									class="hasDetail pls-popover" 
									data-type="Ranking Popover" 
									data-trigger="hover" 
									data-container="body" 
									data-toggle="popover" 
									data-placement="right" 
									data-content="Bạn đang đứng vị trí số <?php echo $rankings[$progress['Subject']['id']]; ?> trong bảng xếp hạng của môn <?php echo $progress['Subject']['name']; ?>" 
									data-original-title=""><span class="glyphicon glyphicon-question-sign"></span></a>-->
									<span class="label label-success ranking-info"><span class="glyphicon glyphicon-star"></span> Vị trí xếp hạng <?php echo $rankings[$progress['Subject']['id']]; ?>
									<a href="javascript:void(0);" 
									class="hasDetail pls-popover pull-right" 
									data-type="Ranking Popover" 
									data-trigger="hover" 
									data-container="body" 
									data-toggle="popover" 
									data-placement="top" 
									data-content="Bạn đang đứng vị trí số <?php echo $rankings[$progress['Subject']['id']]; ?> trong bảng xếp hạng điểm trung bình của môn <?php echo $progress['Subject']['name']; ?>" 
									data-original-title=""><span class="glyphicon glyphicon-question-sign"></span></a>
									</label>
							</p>
							<a href="<?php 
								echo $this->Html->url(
									array(
										'controller' => 'Tests', 
										'action' => 'chooseTest', 
										$progress['Subject']['id'],
									)
								); 
							?>" class="btn btn-sm btn-primary btn-test pls-test-btn fw bl left" data-teston="subject">
								<span class="glyphicon glyphicon-play"></span> <?php echo __('Do test on this'); ?>
							</a>
					</div>		
					<div class="col-md-9 col-sm-9 col-xs-12 no-border-xs" style="border-left: solid 1px #C0D0E0;">
						<div class="row">
							<div class="col-md-3 col-xs-3 pdr-xs-5">
								<span class="detail-subject-score" style="border-color:<?php echo $this->Name->rankColor($score); ?>" id="subject-score-<?php echo $progress['Subject']['id']; ?>" title="<?php echo __('Score based on latest 10 tests on the subject'); ?>">
									<span class="subject-score-number"><?php echo $score; ?></span>
									<span class="detail-subject-score-text" style="color:<?php echo $this->Name->rankColor($score); ?>"><?php echo __('Score'); ?></span>
								</span>
							</div>
							<div class="col-md-9 col-xs-9 mgl-md-s20 pdl-md-0 pdl-xs-5">
								<?php echo __('Tiến trình học tập'); ?> <a href="javascript:void(0);" class="hasDetail pull-right pls-popover" data-type="Progress Popover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="Được tính bằng tỷ lệ số bài học đã thực hành trên tổng số bài của môn học này"><span class="glyphicon glyphicon-question-sign"></span></a>
								
								<div class="progress" style="margin: 10px 0;">
									<?php $completeness = round(($cover[$progress['Subject']['id']]['pass']/$cover[$progress['Subject']['id']]['total'])*100); ?>
									<div class="progress-bar progress-bar-striped" id="subject-cover-<?php echo $progress['Subject']['id']; ?>" style="width: <?php echo $completeness; ?>%;" role="progressbar" aria-valuenow="<?php echo $completeness; ?>" aria-valuemin="0" aria-valuemax="100" id="preogressbar-cover"><?php echo $completeness.'%'; ?></div>
								</div>
								
								Bạn đã thực hành <b class="num-pass"><?php echo $cover[$progress['Subject']['id']]['pass']; ?></b> trên tổng số <b class="num-total"><?php echo $cover[$progress['Subject']['id']]['total']; ?></b> bài học
								<!--<?php echo __('Rating'); ?>
								<br/>
								<div class="progress">
									<div class="progress-bar progress-bar-info" id="subject-progress-<?php echo $progress['Subject']['id']; ?>" style="width: <?php echo round(($progress['Progress']['sum_progress']/$progress['Progress']['sum_total'])*100); ?>%;" role="progressbar" aria-valuenow="<?php echo round($progress['Progress']['sum_progress']/$progress['Progress']['sum_total']*100); ?>" aria-valuemin="0" aria-valuemax="100" id="preogressbar-rating"><?php echo $progress['Progress']['sum_progress'].'/'.$progress['Progress']['sum_total']; ?></div>
								</div>-->
							</div>
						</div>	
					</div>
				</div>	
			</div>	
		</div>		
		<div>
			<div class="pd10">
				<div class="time-range">
					<div class="row">
						<div class="col-md-6 col-xs-12">
							<span class="pull-left"><b>Biểu đồ học tập</b></span>
						</div>	
						<div class="col-md-6 col-xs-12">
							<div class="btn-group pull-right">
								<a class="btn btn-default btn-xs dropdown-toggle time-range-select" data-range="custom" data-toggle="dropdown" aria-expanded="false"><?php echo __('Custom'); ?> <span class="caret"></span></a>
								<div class="dropdown-menu unclickable-dropdown" role="menu">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<input type="text" class="form-control datepicker" id="time-range-start" placeholder="Từ ngày" />
											</div>
											<div class="form-group">
												<input type="text" class="form-control datepicker" id="time-range-end" placeholder="Đến ngày" />
											</div>
											<div class="form-group right">
												<button class="btn btn-default btn-sm" id="time-ranger-choose">Đồng ý</button>
											</div>
										</div>	
									</div>	
								</div>
							</div>	
							
							<!--<a class="pull-right btn btn-primary btn-xs time-range-select" data-range="all"><?php echo __('All time'); ?></a>-->
							<a class="pull-right btn btn-default  btn-xs time-range-select" data-range="month"><?php echo __('1 Month'); ?></a>
							<a class="pull-right btn btn-default btn-xs time-range-select" data-range="week"><?php echo __('1 Week'); ?></a>
							<a class="pull-right btn btn-primary btn-xs time-range-select" data-range="tentimes"><?php echo __('Last 10 times'); ?></a>
							<h5 class="pull-right hidden-xs"><?php echo __('Time range'); ?></h5>
						</div>	
					</div>	
				</div>
				<div class="chart" id="chart-subject-<?php echo $progress['Subject']['id']; ?>"></div>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
				<div role="tabpanel">
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs grade-tabs" role="tablist">
					<?php foreach($gradeContents AS $grade){ ?>
						<li role="presentation" class="<?php if( $grade['Grade']['name']==$user['grade']) echo 'active'; ?>"><a href="#grade<?php echo $grade['Grade']['id']; ?>" aria-controls="grade<?php echo $grade['Grade']['id']; ?>" role="tab" data-toggle="tab"><?php echo __('Grade').' '.$grade['Grade']['name']; ?></a></li>
					<?php } ?>
				  </ul>
				  <!-- Tab panes -->
				  <div class="tab-content">
					<?php foreach($gradeContents AS $grade){ ?>
						<div role="tabpanel" class="tab-pane <?php if($grade['Grade']['name']==$user['grade']) echo 'active'; ?>" id="grade<?php echo $grade['Grade']['id']; ?>">
							<table class="table table-bordered subcategory-detail-table" style="border-top:0;">
								<thead>
									<th></th>
									<th class="center"><?php echo __('Score'); ?></th>
									<th class="center"><?php echo __('Rank'); ?></th>
									<th class="center"><?php echo __('Test'); ?></th>
								</thead>
							<?php foreach($grade['Category'] AS $category){ ?>
								<tr class="category-row" data-id="<?php echo $category['id']; ?>">
									<td>
										<a href="javascript:void(0);"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp; Chương: <?php echo $category['name']; ?></a>
									</td>
									<td class="center w-100">
										<b><?php echo (isset($progressDetail['category'][$category['id']]))?$progressDetail['category'][$category['id']]:'-'; ?></b>
									</td>
									<td class="center w-100">
										<?php $rank = (isset($progressDetail['category'][$category['id']]))?$this->Name->determineRank($progressDetail['category'][$category['id']]):'-'; ?>
											<span class="label label-<?php echo (is_array($rank))?$rank['color']:''; ?>"><?php echo (is_array($rank))?$rank['rank']:'-'; ?></span>
									</td>
									<td class="center w-100">
										<a href="<?php echo $this->Html->url(array('controller' => 'Tests', 
																				'action' => 'chooseTest', 
																				$progress['Subject']['id'],
																				'?'	=>	array('category'=>$category['id']))); ?>" class="pls-test-btn" data-teston="category">
											<button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-play"></span> <?=__('Test'); ?></button>
										</a>
									</td>
								</tr>
								<?php foreach($category['Subcategory'] AS $subcategory){ ?>
									<tr class="subcategory-row subcategory-<?php echo $category['id']; ?>">
										<td>
											&emsp;&emsp;Bài: <?php echo $subcategory['name']; ?>
										</td>
										<td class="center">
											<b><?php echo (isset($progressDetail['subcategory'][$subcategory['id']]))?$progressDetail['subcategory'][$subcategory['id']]:'-'; ?></b>
										</td>
										<td class="center">
											<?php $rank = (isset($progressDetail['subcategory'][$subcategory['id']]))?$this->Name->determineRank($progressDetail['subcategory'][$subcategory['id']]):'-'; ?>
											<span class="label label-<?php echo (is_array($rank))?$rank['color']:''; ?>"><?php echo (is_array($rank))?$rank['rank']:'-'; ?></span>
										</td>
										<td class="center w-100">
											<a href="<?php echo $this->Html->url(array('controller' => 'Tests', 
																				'action' => 'chooseTest', 
																				$progress['Subject']['id'],
																				'?' => array('subcategory' => $subcategory['id']))); ?>" class="pls-test-btn" data-teston="subcategory">
												<button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-play"></span> <?=__('Test'); ?></button>
											</a>	
										</td>
									</tr>
								<?php } ?>
							<?php } ?>
							</table>
						</div>
					<?php } ?>
				  </div>

				</div>
			</div>
		</div>
		
	<?php } ?>
<?php	
	}
	else { ?>
		
		<div class="alert alert-success">
			<div class="row">
				<div class="col-md-9">
					<span class="glyphicon glyphicon-hand-right "></span>
					<strong><?php echo __('Welcome to Personal Learning System!'); ?></strong>
					<br/>
					<?php echo __('You have no progress on this subject, please click Test Button to begin your learning process'); ?>
				</div>
				<div class="col-md-3">
					<a href="<?php echo $this->Html->url(array('controller' => 'Tests', 
																'action' => 'chooseTest', 
																$subject_id)); ?> "class="pls-test-btn" data-teston="first test">
					<button class="btn btn-primary btn-test btn-lg pull-right"><span class="glyphicon glyphicon-play"></span> Kiểm tra ngay</button>
					</a>
				</div>
			</div>	
		</div>
	<?php } ?>

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
