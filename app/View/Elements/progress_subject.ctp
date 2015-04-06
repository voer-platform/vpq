<?php if( !empty($progresses) ){ ?>
	<div class="time-range clearfix">
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
        <h5 class="pull-right"><?php echo __('Time range'); ?></h5>
    </div>
	
	<?php  
		foreach($progresses as $key => $progress){
			$score  = round($progress['Progress']['sum_progress']/$progress['Progress']['sum_total'],2)*10;
			$name   = $this->Name->determineRank($score);
	?>
		<div class="row dashboard-subject-container">
			<div class="col-md-2">
				<h2 class="dashboard-subject-name"><?php echo $this->Html->image('physical.png'); ?> <?php echo $progress['Subject']['name']; ?></h2>
					<a href="<?php 
						echo $this->Html->url(
							array(
								'controller' => 'Tests', 
								'action' => 'chooseTest', 
								$progress['Subject']['id'],
							)
						); 
					?>" class="btn btn-sm btn-primary btn-test pls-test-btn" data-teston="subject">
						<span class="glyphicon glyphicon-play"></span> <?php echo __('Do test on this'); ?>
					</a>
				</div>		
			<div class="col-md-4" style="border-left: solid 1px #C0D0E0;">
				<div style="display: inline-block;">
					<span class="subject-score" id="subject-score-<?php echo $progress['Subject']['id']; ?>" title="<?php echo __('Score based on latest 10 tests on the subject'); ?>">
						<span class="subject-score-number"><?php echo $score; ?></span>
						<span class="subject-score-text"><?php echo __('Score'); ?></span>
					</span>
				</div>
				<div style="display: inline-block;float:right;width: 65%;">
					<?php echo __('Tiến trình học tập'); ?> <a href="javascript:void(0);" class="hasDetail pull-right pls-popover" data-type="Progress Popover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="top" data-content="Được tính bằng tỷ lệ số câu hỏi đã làm trên tổng số câu hỏi của môn học này"><span class="glyphicon glyphicon-question-sign"></span></a>
					
					<div class="progress" style="margin: 10px 0;">
						<?php $completeness = round(($cover[$progress['Subject']['id']]['pass']/$cover[$progress['Subject']['id']]['total'])*100); ?>
						<div class="progress-bar progress-bar-striped" id="subject-cover-<?php echo $progress['Subject']['id']; ?>" style="width: <?php echo $completeness; ?>%;" role="progressbar" aria-valuenow="<?php echo $completeness; ?>" aria-valuemin="0" aria-valuemax="100" id="preogressbar-cover"><?php echo $completeness.'%'; ?></div>
					</div>
					
					Bạn đã hoàn thành <b class="num-pass"><?php echo $cover[$progress['Subject']['id']]['pass']; ?></b> trên tổng số <b class="num-total"><?php echo $cover[$progress['Subject']['id']]['total']; ?></b> câu hỏi
					<!--<?php echo __('Rating'); ?>
					<br/>
					<div class="progress">
						<div class="progress-bar progress-bar-info" id="subject-progress-<?php echo $progress['Subject']['id']; ?>" style="width: <?php echo round(($progress['Progress']['sum_progress']/$progress['Progress']['sum_total'])*100); ?>%;" role="progressbar" aria-valuenow="<?php echo round($progress['Progress']['sum_progress']/$progress['Progress']['sum_total']*100); ?>" aria-valuemin="0" aria-valuemax="100" id="preogressbar-rating"><?php echo $progress['Progress']['sum_progress'].'/'.$progress['Progress']['sum_total']; ?></div>
					</div>-->
				</div>
			</div>
			<div class="col-md-6">
				<div class="chart" id="chart-subject-<?php echo $progress['Subject']['id']; ?>"></div>
			</div>
		</div>		
		
		<div class="row">
			<div class="col-md-12">
				<br/>
				<div role="tabpanel">
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs grade-tabs" role="tablist">
					<?php foreach($gradeContents AS $grade){ ?>
						<li role="presentation" class="<?php if($grade['Grade']['id']==1) echo 'active'; ?>"><a href="#grade<?php echo $grade['Grade']['id']; ?>" aria-controls="grade<?php echo $grade['Grade']['id']; ?>" role="tab" data-toggle="tab"><?php echo __('Grade').' '.$grade['Grade']['name']; ?></a></li>
					<?php } ?>
				  </ul>
				  <!-- Tab panes -->
				  <div class="tab-content">
					<?php foreach($gradeContents AS $grade){ ?>
						<div role="tabpanel" class="tab-pane <?php if($grade['Grade']['id']==1) echo 'active'; ?>" id="grade<?php echo $grade['Grade']['id']; ?>">
							<table class="table table-bordered" style="border-top:0;">
								<thead>
									<th></th>
									<th class="center"><?php echo __('Score'); ?></th>
									<th class="center"><?php echo __('Rank'); ?></th>
									<th class="center"><?php echo __('Test'); ?></th>
								</thead>
							<?php foreach($grade['Category'] AS $category){ ?>
								<tr class="category-row" data-id="<?php echo $category['id']; ?>">
									<td>
										<a href="javascript:void(0);"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp; <?php echo $category['name']; ?></a>
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
											&emsp;&emsp;<?php echo $subcategory['name']; ?>
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
		<br/>
		<div class="alert alert-success">
			<div class="row">
				<div class="col-md-6">
					<span class="glyphicon glyphicon-hand-right "></span>
					<strong><?php echo __('Welcome to Personal Learning System!'); ?></strong>
					<br/>
					<?php echo __('You have no progress at all, please click Test Button to begin your learning process'); ?>
				</div>
				<div class="col-md-6">
					<a href="<?php echo $this->Html->url(array('controller' => 'Tests', 
																'action' => 'chooseTest', 
																2)); ?>">
					<button class="btn btn-primary btn-test btn-lg pull-right"><span class="glyphicon glyphicon-play"></span> Kiểm tra ngay</button>
					</a>
				</div>
			</div>	
		</div>
	<?php } ?>


