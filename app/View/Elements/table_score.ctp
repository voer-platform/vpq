<div class='col-sm-12'>
	<div class='col-sm-12'>
	<table class="table table-striped table table-bordered">
		<tr>
			<th style='text-align:center;' class='col-sm-2'>Ngày làm bài</th>
			<th style='text-align:center;' class='col-sm-2'>Môn</th>
			<th style='text-align:center;' class='col-sm-2'>Thời gian giới hạn</th>
			<th style='text-align:center;' class='col-sm-2'>Thời gian làm bài</th>
			<th style='text-align:center;' class='col-sm-2'>Điểm</th>
		</tr>
		<?php foreach($scores as $item=>$score): ?>
			<tr>
				<td><?php echo $this->Html->link($this->Name->convertDayOfWeek(date('D', strtotime($score['Score']['time_taken'])))." ".date('d-m-y', strtotime($score['Score']['time_taken'])), array('controller' => 'scores', 'action' => 'viewDetails', $score['Score']['id']));?></td>
				<td style='text-align:center;'>Vật lý</td>
				<td style='text-align:center;'><?php echo $score['Test']['time_limit']; ?> phút</td>
				<td style='text-align:center;'><?php echo floor($score['Score']['duration']/60); ?>:<?php echo $score['Score']['duration']%60?></td>
				<td style='text-align:center;'><?php echo $score['Test']['number_questions'] != 0? round($score['Score']['score']/$score['Test']['number_questions'], 2)*10 : 0 ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	</div>
	<!--<div class='col-sm-6' style='padding-right:50px;'>
		<?php foreach($scores as $item=>$score): ?>
		<?php if($item<5): ?>
		<div class='row' <?php if($item!=0): ?> style='margin-top:50px'<?php endif;?>>
			<div class='col-sm-7' style="border: solid 1px #C0D0E0; padding:0px">
				<img src="/img/history4.png" style='width:305px;height:185px' alt="PLS">
			</div>
			<div class='col-sm-5' style="border: solid 1px #C0D0E0;">		
				<div class='row' style="border-bottom: solid 1px #C0D0E0">
					<div class='col-sm-10 col-sm-offset-1'>
						<a style='font-size:20px'><?php echo date('D, d-m-y', strtotime($score['Score']['time_taken'])) ?></a>
					</div>					
				</div>
				<div class='row'>
					<div class='col-sm-10 col-sm-offset-1'>
						<label>Môn: Vật lý</label>
					</div>					
				</div>
				<div class='row'>
					<div class='col-sm-10 col-sm-offset-1'>
						<label>Thời gian: <?php echo $score['Test']['time_limit']; ?> phút</label>
					</div>				
				</div>
				<div class='row'>				
					<div class='col-sm-8 col-sm-offset-2'>
						<span class="subject-score">
							<span class="subject-score-text">Điểm</span>
							<span class="subject-score-number"><?php echo $score['Test']['number_questions'] != 0? round($score['Score']['score']/$score['Test']['number_questions'], 2)*10 : 0 ?></span>						
						</span>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<div class='col-sm-6' style='padding-left:50px;'>	
		<?php foreach($scores as $item=>$score): ?>
		<?php if($item>=5): ?>
		<div class='row' <?php if($item!=5): ?> style='margin-top:50px'<?php endif;?>>
			<div class='col-sm-7' style="border: solid 1px #C0D0E0; padding:0px">
				<img src="/img/history4.png" style='width:305px;height:185px' alt="PLS">
			</div>
			<div class='col-sm-5' style="border: solid 1px #C0D0E0;">		
				<div class='row' style="border-bottom: solid 1px #C0D0E0">
					<div class='col-sm-10 col-sm-offset-1'>
						<a style='font-size:20px'><?php echo date('D, d-m-y', strtotime($score['Score']['time_taken'])) ?></a>
					</div>					
				</div>
				<div class='row'>
					<div class='col-sm-10 col-sm-offset-1'>
						<label>Môn: Vật lý</label>
					</div>					
				</div>
				<div class='row'>
					<div class='col-sm-10 col-sm-offset-1'>
						<label>Thời gian: <?php echo $score['Test']['time_limit']; ?> phút</label>
					</div>				
				</div>
				<div class='row'>				
					<div class='col-sm-8 col-sm-offset-2'>
						<span class="subject-score">
							<span class="subject-score-text">Điểm</span>
							<span class="subject-score-number"><?php echo $score['Test']['number_questions'] != 0? round($score['Score']['score']/$score['Test']['number_questions'], 2)*10 : 0 ?></span>						
						</span>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<?php endforeach; ?>
	</div>-->
</div>
