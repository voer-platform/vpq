<script type="text/javascript"
	  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
	</script>
<div class='admin-insert-questions'>
	<form action="" method="POST" name="frmExchangesRates" role="form" class="form-horizontal">
	<div class='col-lg-12'>
	
		<!-- visible form -->
		<div class='row'>
			<div class='col-lg-6' style='padding-left:0px;'>
				<h2>Chi tiết câu hỏi: <?php echo $subject[0]['Subject']['name'];?></h2>
			</div>
			<?php if($user['role']=='editor' || $user['role']=='admin'): ?>
			<div class='col-lg-6' style='padding-right:0px;'>
				<h2 style='float:right;'><span style='color:rgb(78, 195, 223);'>Số lượng câu hỏi có thể trùng:</span> <span style='color:red;'><?php echo $count_same; ?></span></h3>
			</div>
			<?php endif; ?>
		</div>
		<div class='row'>
			<hr/>
		</div>
		<div class='row'>
			
				<div class='col-lg-9' style='padding-left:0px;'>
					<div id='left'>
						<div class='col-lg-12'>
							<div class='row' style='margin:0px;margin-top:10px;'>
								<b style='color:brown;font-size:16px;'>Câu hỏi:</b>
							</div>
							<div class='row' style='margin:0px;margin-top:10px;'>
								<span style='color:brown;' id='content'><?php echo $question[0]['ImportQuestion']['question'];?></span>
							</div>
							<br/>
							<div class='row' style='margin:0px;margin-top:10px;'>
								<b style='color:brown;font-size:16px;'>Lời giải:</b>
							</div>
							<div class='row' style='margin:0px;margin-top:10px;'>
								<textarea style='margin-top:10px;margin-bottom:10px;' class='form-control' name='text_solution' id='text_solution' value='' rows="10"><?php echo $question[0]['ImportQuestion']['solution'];?></textarea>
							</div>
							<div class='row'>
								<div class='btn-group answer'>
									<label <?php echo(array_key_exists('0',$correct))?"class='btn-answer active'":"class='btn-answer wrong'"; ?> id='answer_a'>
										<span class="lbanswer">a</span><?php echo $question[0]['ImportQuestion']['answer_a'];?>
									</label>
									<textarea style='margin-top:10px;margin-bottom:10px;' type='text' class='form-control' name='text_a' id='text_a' value=''><?php echo $question[0]['ImportQuestion']['answer_a'];?></textarea>
									<label <?php echo(array_key_exists('1',$correct))?"class='btn-answer active'":"class='btn-answer wrong'"; ?> id='answer_b'>
										<span class="lbanswer">b</span><?php echo $question[0]['ImportQuestion']['answer_b'];?>
									</label>
									<textarea style='margin-top:10px;margin-bottom:10px;' type='text' class='form-control' name='text_b' id='text_b' value=''><?php echo $question[0]['ImportQuestion']['answer_b'];?></textarea>
									<label <?php echo(array_key_exists('2',$correct))?"class='btn-answer active'":"class='btn-answer wrong'"; ?> id='answer_c'>
										<span class="lbanswer">c</span><?php echo $question[0]['ImportQuestion']['answer_c'];?>
									</label>
									<textarea style='margin-top:10px;margin-bottom:10px;' type='text' class='form-control' name='text_c' id='text_c' value=''><?php echo $question[0]['ImportQuestion']['answer_c'];?></textarea>
									<label <?php echo(array_key_exists('3',$correct))?"class='btn-answer active'":"class='btn-answer wrong'"; ?> id='answer_d'>
										<span class="lbanswer">d</span><?php echo $question[0]['ImportQuestion']['answer_d'];?>
									</label>
									<textarea style='margin-top:10px;margin-bottom:10px;' type='text' class='form-control' name='text_d' id='text_d' value=''><?php echo $question[0]['ImportQuestion']['answer_d'];?></textarea>
								</div>
							</div>
						</div>					
					</div>
				</div>
				<div class='col-lg-3'>
					<?php if($user['role']=='tester'){ ?>
					<div class='row'>
						<select class='form-control' name='grades' id='grades'>
							<option value=''>-Chọn lớp-</option>
							<option value='1'>Lớp 10</option>
							<option value='2'>Lớp 11</option>
							<option value='3'>Lớp 12</option>
						</select>
					</div>
					<br/>
					<div class='row'>
						<select class='form-control' name='cat' id='cat'>
							<option value=''>-Chọn chương-</option>							
						</select>
					</div>
					<br/>
					<div class='row'>						
						<div class='col-lg-9' style='padding-left:0px;padding-right:10px;'>
							<select class='form-control' name='subcat' id='subcat'>								
								<?php if($question[0]['ImportQuestion']['subcategory_id']!=0 || $question[0]['ImportQuestion']['subcategory_id']!=''){ ?>
								<option value='<?php echo $subcategory[0]['Subcategory']['id']; ?>'><?php echo $subcategory[0]['Subcategory']['name']; ?></option>
							<?php }else{ ?>
								<option value=''>-Chọn bài-</option>
							<?php } ?>
							</select>
						</div>
						<div class='col-lg-3' style='padding-left:0px;padding-right:0px;'>
							<input type='text' name='subcategory_id' id='subcategory_id' class='form-control' value='<?php echo $question[0]['ImportQuestion']['subcategory_id'];?>' />
						</div>						
					</div>					
					<br/>					
					<div class='row'>
						<input type='submit' class='btn btn-primary col-lg-12' style='height:50px;' name='yes' id='yes' value='Phân Loại' />
					</div>
					<br/>
					<div class='row'>
						
						<input type='submit' class='btn btn-danger col-lg-12' style='height:50px;' name='no' value='Làm lại'/>
					</div>					
					<?php }else{ ?>
						<div class='row'>
							<div class='col-lg-12' style='padding-left:0px; padding-right:0px'>
								<p><b>Chú ý đáp án:</b><span style="float:right;">A=0, B=1, C=2, D=3<span></p>
							</div>
						</div>
						<br/>
						<div class='row'>
							<div class='col-lg-5' style='padding-left:0px;'>
								<label>Đáp án đúng:</label>
							</div>
							<div class='col-lg-7' style='padding-right:0px;'>
								<input type='text' class='form-control' name='answer_correct' id='answer_correct' value='<?php echo $cr; ?>' />
							</div>
						</div>
						<br/>
						<div class='row'>
							<input type='submit' class='btn btn-warning col-lg-12' style='height:50px;' name='update' id='update' value='Cập nhật' />
						</div>
						<br/>
						<div class='row'>
							<input type='submit' class='btn btn-primary col-lg-12' style='height:50px;' name='ok' value='Xác nhận' />
						</div>
						<br/>
						<div class='row'>
							<input type='submit' class='btn btn-danger col-lg-12' style='height:50px;' name='no2' value='Hủy'/>
						</div>
					<?php } ?>
					<div class='row'>
						<input type='hidden' name='subject_id' id='subject_id' class='form-control' value='<?php echo $question[0]['ImportQuestion']['subject_id'];?>' />
						<input type='hidden' name='id' class='form-control' value='<?php echo $question[0]['ImportQuestion']['id'];?>' />
					</div>
				</div>
			
		</div>
		<br/>
		<?php if($user['role']=='editor' || $user['role']=='admin'){ ?>
		<div class='row'>
			<div class='col-lg-9' style='padding-left:0px;'>
				<textarea type='text' style='width:710px;' class='form-control' rows='8' name='content_question' id='content_question'><?php echo $question[0]['ImportQuestion']['question'];?></textarea>
			</div>
			<div class='col-lg-3'>
	
			</div>
		</div>
		<div class='row'>
			<h3>Danh sách câu hỏi có thể trùng</h3>
			<hr/>
		</div>		
		<div class='row'>
			<?php $i=1; ?>
			<table class='table table-striped table-bordered'>
				<tr>
					<th style='text-align:center;width:70px'>STT</th>
					<th style='text-align:center;'>Câu hỏi</th>
				</tr>
				<?php foreach($same_question as $sq): ?>
					<tr>
						<td style='text-align:center;'><?php echo $i; ?></td>
						<td><?php echo $sq['Question']['content']; ?></td>
					</tr>
					<?php $i++; ?>	
				<?php endforeach; ?>
			</table>
		</div>
		<div class='row' style='margin:0px;'>
			<div class="paging">
			<?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
			?>
		</div>
		<?php } ?>
	</div>
	<br/>
	</form>
</div>
<script>
	$(document).on('click','#answer_a',function(){
		$('#answer_a').hide();
		$('#text_a').show();
	});
	$(document).on('click','#answer_b',function(){
		$('#answer_b').hide();
		$('#text_b').show();
	});
	$(document).on('click','#answer_c',function(){
		$('#answer_c').hide();
		$('#text_c').show();
	});
	$(document).on('click','#answer_d',function(){
		$('#answer_d').hide();
		$('#text_d').show();
	});
	$(document).on('click','#update',function(){
		$content_question=$('#content_question').val();
		$answer_a=$('#text_a').val();
		$answer_b=$('#text_b').val();
		$answer_c=$('#text_b').val();
		$answer_d=$('#text_b').val();
		$answer_correct=$('#answer_correct').val();
		if($content_question=='' || $answer_a=='' || $answer_b=='' || $answer_c=='' || $answer_d=='' || $answer_correct==''){
			return false;
		}
	});
	$(document).on('change','#grades',function(){
		$grade_id=$(this).val();
		$subject_id=$('#subject_id').val();
		var url = '<?php echo Router::url(array('controller'=>'partner','action'=>'byGrade'));?>/' + $grade_id + '/'+$subject_id;
		$.getJSON(url, function( data ) {
			var options="";
			options+="<option value=''>-Chọn chương-</option>";
			for($i=0;$i<data.length;$i++)
			{
			options+="<option value='"+data[$i]['Category']['id']+"'>"+data[$i]['Category']['name']+"</option>";
			}
			$("#cat").html(options);
		});
	});
	$(document).on('change','#cat',function(){
		$cat_id=$(this).val();
		var url = '<?php echo Router::url(array('controller'=>'partner','action'=>'get_subcategories'));?>/' + $cat_id;
		$.getJSON(url, function( data ) {
			var options="";
			options+="<option value=''>Chọn bài</option>";
			for($i=0;$i<data.length;$i++)
			{
			options+="<option value='"+data[$i]['Subcategory']['id']+"'>"+data[$i]['Subcategory']['name']+"</option>";
			}
			$("#subcat").html(options);
		});
	});
	$(document).on('change','#subcat',function(){
		$subcat_id=$(this).val();
		$('#subcategory_id').val($subcat_id);
	});
	$(document).on('click','#yes',function(){
		$subcat=$('#subcategory_id').val();
		if($subcat==0 || $subcat==''){
			alert('bạn chưa chọn bài để phân loại');
			return false;
		}
	});
	$(document).ready(function(){
		$('#text_a').hide();
		$('#text_b').hide();
		$('#text_c').hide();
		$('#text_d').hide();
	});
</script>