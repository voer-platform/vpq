<?php if($question){ ?>
<div class="sorting-form-container">
	<div class="alert alert-success">
		<strong>Câu hỏi:</strong> <?=$question['ImportQuestion']['question'];?><br/>
		A: <?=$question['ImportQuestion']['answer_a'];?><br/>
		B: <?=$question['ImportQuestion']['answer_b'];?><br/>
		C: <?=$question['ImportQuestion']['answer_c'];?><br/>
		D: <?=$question['ImportQuestion']['answer_d'];?>
		<?php if($question['ImportQuestion']['answer_e']){ ?>
		<br/>E: <?=$question['ImportQuestion']['answer_e'];?>
		<?php } ?>
	</div>
	<div class="form-group" id="sorting-option">
		<label class="control-label"><u>Phân loại:</u></label>
		<br/>
		<input type="hidden" id="question" value="<?=$question['ImportQuestion']['id'];?>" />
		<input type="hidden" id="subject" value="<?=$question['ImportQuestion']['subject_id'];?>" />
		<?php if (!$question['ImportQuestion']['grade_id']) { ?>
			<select class="form-control inline wa mgt-10" id="grade">
				<option value="">Chọn lớp</option>
				<?php foreach($grades AS $id => $name){ ?>
					<option value="<?=$id;?>">Lớp <?=$name;?></option>
				<?php } ?>
			</select>
		<?php } else { ?>
			<input type="hidden" id="grade" value="<?=$question['ImportQuestion']['grade_id'];?>" />
			<label> Lớp <?=$grades[$question['ImportQuestion']['grade_id']];?></label>
		<?php } ?>
		<select class="form-control inline wa mgt-10" id="category">
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
		<select class="form-control inline wa mgt-10" id="subcategory">
			<option value="">Chọn bài</option>
		</select>
	</div>	
	<p class="text-danger" id="sorting-error" style="display:none;"></p>
</div>	
<?php } ?>