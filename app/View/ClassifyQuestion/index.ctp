<div class="questions index">
	<h2>Phân loại câu hỏi</h2>
	<hr/>
	<?php if (isset($message)) { ?>
		<div class="alert alert-success"><?=$message;?></div>
	<?php } ?>
	<div class="row">
		<div class="col-md-12">
			<form class="form-inline">
				<select class="form-control" name="subject" id="subject">
					<option value="">Tất cả môn học</option>
					<?php foreach($subjects AS $id=>$subject){ ?>
						<option value="<?php echo $id; ?>" <?php if(isset($csubject) && $csubject==$id) echo 'selected'; ?>><?php echo $subject; ?></option>
					<?php } ?>
				</select>
				
				<select class="form-control" name="grade" id="grade">
					<option value="">Mọi lớp</option>
					<?php foreach($grades AS $id=>$grade){ ?>
						<option value="<?php echo $id; ?>" <?php if(isset($cgrade) && $cgrade==$id) echo 'selected'; ?>><?php echo $grade; ?></option>
					<?php } ?>
				</select>
			
				<button type="submit" class="btn btn-primary" name="search" value="true">Tìm câu hỏi</button>
				<h4 class="pull-right">Bạn đã phân loại giúp PLS <font color="red"><?=$questionCount;?></font> câu hỏi</h4>
			</form>
			
		</div>	
	</div>	
	<hr/>
	<table cellpadding="0" cellspacing="0" class="table table-striped table table-bordered">
	<thead>
	<tr>
			<th>Câu hỏi</th>
			<th>Phân loại</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($questions as $question): ?>
	<tr>
		<td>
			<?php echo html_entity_decode($question['ImportQuestion']['question']); ?><br/>
			A: <?php echo html_entity_decode($question['ImportQuestion']['answer_a']); ?><br/>
			B: <?php echo html_entity_decode($question['ImportQuestion']['answer_b']); ?><br/>
			C: <?php echo html_entity_decode($question['ImportQuestion']['answer_c']); ?><br/>
			D: <?php echo html_entity_decode($question['ImportQuestion']['answer_d']); ?>
			<?php if($question['ImportQuestion']['answer_e']){ ?>
			<br/>
			E: <?php echo html_entity_decode($question['ImportQuestion']['answer_e']); ?>
			<?php } ?>
		</td>
		<td class="sorting-option" width="500">
			<form method="POST" action="">
				<input type="hidden" name="sort_question" class="sort-question" value="<?=$question['ImportQuestion']['id'];?>" />
				<input type="hidden" class="sort-subject" value="<?=$question['ImportQuestion']['subject_id'];?>" />
				<div class="form-group">
					<?php if (!isset($question['ImportQuestion']['grade_id'])) { ?>
						<select class="form-control inline wa mgt-10 sort-grade">
							<option value="">Chọn lớp</option>
							<?php foreach($grades AS $id => $name){ ?>
								<option value="<?=$id;?>">Lớp <?=$name;?></option>
							<?php } ?>
						</select>
						<select class="form-control inline wa mgt-10 sort-category">
							<option value="">Chọn chương</option>
							<?php if (isset($categories)) { 
										foreach ($categories AS $id => $name) {
							?>
								<option value="<?=$id;?>"><?=$name;?></option>
							<?php
								}
									}
							?>
						</select>
					<?php } else { ?>
						<input type="hidden" class="sort-grade" value="<?=$question['ImportQuestion']['grade_id'];?>" />
						<label> Lớp <?=$grades[$question['ImportQuestion']['grade_id']];?></label>&nbsp;					
						<select class="form-control inline wa mgt-10 sort-category">
							<option value="">Chọn chương</option>
							<?php foreach ($this->Pls->getCategory($question['ImportQuestion']['subject_id'], $question['ImportQuestion']['grade_id']) AS $id => $name) { ?>
								<option value="<?=$id;?>"><?=$name;?></option>
							<?php	}	?>
						</select>
					<?php } ?>
				</div>
				<div class="form-group">
					
					<select class="form-control inline wa sort-subcategory" name="sort_subcategory">
						<option value="">Chọn bài</option>
					</select>
					<input type="submit" class="btn btn-primary sort-submit" value="Gửi" />
				</div>	
				<p class="text-danger sort-error" style="display:none;">Vui lòng chọn chương, bài</p>
			</form>	
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
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
	<br/><br/>
</div>
<script>

</script>