<h3>Lịch sử người dùng: <?=$person['Person']['fullname'];?> <i>(lần truy cập cuối <?=date('d/m/Y', strtotime($person['Person']['last_login']));?> )</i></h3>
<hr/>
<div class="row">
	<div class="col-md-12">
		<form class="form-inline">
			<label>Tìm kiếm </label>&nbsp;
			
			<select class="form-control" name="subject" id="subject">
				<option value="">Môn học</option>
				<?php foreach($subjects AS $id=>$subject){ ?>
					<option value="<?php echo $id; ?>" <?php if(isset($csubject) && $csubject==$id) echo 'selected'; ?>><?php echo $subject; ?></option>
				<?php } ?>
			</select>

			<select class="form-control" name="duration">
				<option value="">Thời lượng</option>
				<option value="5" <?php if(isset($cduration) && $cduration==5) echo 'selected'; ?>>5 phút</option>
				<option value="10" <?php if(isset($cduration) && $cduration==10) echo 'selected'; ?>>10 phút</option>
				<option value="15" <?php if(isset($cduration) && $cduration==15) echo 'selected'; ?>>15 phút</option>
				<option value="30" <?php if(isset($cduration) && $cduration==30) echo 'selected'; ?>>30 phút</option>
				<option value="60" <?php if(isset($cduration) && $cduration==60) echo 'selected'; ?>>60 phút</option>
			</select>
			
			<button type="submit" class="btn btn-primary" name="search" value="true">Tìm kiếm</button>
			<a href="<?php echo $this->here; ?>" class="btn btn-default">Xóa lọc</a>
		</form>
	</div>	
</div>	
<hr/>
<div class="row">
	<div class="col-md-12">
		<table class="table table-striped table table-bordered">
			<tr>
				<th style='text-align:center;' class='col-sm-2'><?php echo $this->Paginator->sort('Score.time_taken', __('Date')); ?></th>
				<th style='text-align:center;' class='col-sm-2'><?php echo __('Subject'); ?></th>
				<th style='text-align:center;' class='col-sm-2'>Thời gian giới hạn</th>
				<th style='text-align:center;' class='col-sm-2'>Thời gian làm bài</th>
				<th style='text-align:center;' class='col-sm-2'>Điểm</th>
			</tr>
			<?php foreach($scores as $item=>$score): ?>
				<tr>
					<td style='text-align:center;'><?php echo $this->Html->link(date('d/m/Y h:i:s', strtotime($score['Score']['time_taken'])), array('controller' => 'scores', 'action' => 'viewDetails', $score['Score']['id']));?></td>
					<td style='text-align:center;'><?php echo $score['Subject']['name'];?></td>
					<td style='text-align:center;'><?php echo $score['Test']['time_limit']; ?> phút</td>
					<td style='text-align:center;'><?php echo floor($score['Score']['duration']/60); ?>:<?php echo $score['Score']['duration']%60?></td>
					<td style='text-align:center;'><?php echo $score['Test']['number_questions'] != 0? round($score['Score']['score']/$score['Test']['number_questions'], 2)*10 : 0 ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
		<p>
			<?php
				echo $this->Paginator->counter(array(
					'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
				));
			?>
		</p>
		<ul class="pagination mg0">
		<?php
			echo $this->Paginator->prev('< ' . __('previous'), array('tag'=>'li'), null, array('tag'=>'li', 'class' => 'disabled', 'disabledTag'=>'a'));
			echo $this->Paginator->numbers(array('separator' => '', 'tag'=>'li', 'currentClass' => 'active', 'currentTag' => 'a'));
			echo $this->Paginator->next(__('next') . ' >', array('tag'=>'li'), null, array('tag'=>'li', 'class' => 'disabled', 'disabledTag'=>'a'));
		?>
		</ul>
	</div>
</div>	
<br/>