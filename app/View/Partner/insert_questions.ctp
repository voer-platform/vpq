<?php echo $this->Html->script('/ckeditor/ckeditor.js');?>
<?php echo $this->Html->script('/ckfinder/ckfinder.js');?>
<?php echo $this->Html->css('insert-questions-admin.css'); ?>

<div class='admin-insert-questions'>
	<!-- left nav 
	<?php echo $this->element('admin-left-nav'); ?>

	<!-- right nav -->
	<div class='col-lg-12'>
		<!-- visible form -->
			<form action="" method="POST" name="frmimportexcel" role="form"  enctype="multipart/form-data" class="form-horizontal">
				<div class='row'>
					<table style="border:0px;">
						<tr>
							<td style="padding-right:50px;"><h3 style="margin:0px;">Thêm câu hỏi</h3></td>
							<td style="padding-right:10px;"><input type='file' name='file_import' class='form-control'/></td>
							<td><input type='submit' name='import_excel' value='Import Excel' class='btn btn-primary'/></td>
						</tr>
					</table>
				</div>
			</form>
			<div class='row'>
			<hr/>
			</div>
			<div class='row'>
				<div class='col-sm-3' style='padding-left:0px;padding-right:10px;'>
					<select name='grade' id='grade' class='form-control'>
						<option value>Chọn lớp</option>
						<?php foreach($grade as $grade): ?>
							<option value='<?php echo $grade['Grade']['id'];?>'>Lớp <?php echo $grade['Grade']['name'];?></option>
						<?php endforeach; ?>
					</select>					
				</div>	
				<div class='col-sm-3' style='padding-left:0px;padding-right:5px;'>
					<select name='subject' id='subject' class='form-control'>
						<option value>Chọn môn</option>
						<?php foreach($subject as $subject): ?>
							<option value='<?php echo $subject['Subject']['id'];?>'><?php echo $subject['Subject']['name'];?></option>
						<?php endforeach; ?>
					</select>
				</div>				
				<div class='col-sm-3' style='padding-left:5px;padding-right:0px;'>
					<select name='categories' id='categories' class='form-control'>
						<option value>Chọn chương</option>						
					</select>
				</div>
				<div class='col-sm-3' style='padding-left:10px;padding-right:0px;'>
					<select name='subcategories' id='subcategories' class='form-control'>
						<option value>Chọn bài</option>
					</select>
				</div>				
			</div>
			<div class='row'>
				<hr/>
			</div>
			<div class='row'>
				<div class='col-lg-12'>
					<div class='row'>
						<b>Câu hỏi</b>
					</div>
					<div class='row'>
						<textarea class="form-control" rows="3" name='question' id='question'></textarea>
					</div>
					<br/>
					<div class='row'>
						Chú ý: Nếu câu hỏi có biểu thức toán học, hãy sử dụng công cụ này để lấy mã MathML.&nbsp;						
						<?php echo $this->Html->link('Công cụ lấy mã MathML', 'http://www.wiris.com/editor/demo/en/mathml-latex.html', array('target' => '_blank')) ?>
					</div>
					<br/>
					<div class='row'>
						<b>Lời giải</b>
					</div>
					<div class='row'>
						<textarea class="form-control" rows="3" name='solution' id='solution'></textarea>
					</div>
				</div>
			</div>
			<br/>
			<div class='row'>
				<table class='col-lg-12' style='border:0px;' id='add_question'>
					<tr>
						<td class='col-lg-6' style='padding-left:0px;padding-right:15px;border-right:1px solid #eee'>
							<b>Đáp án A</b>
							<label class="checkbox-inline" style='float:right;'>
								<input type="checkbox" value="0" name='chk_a'  class='checkbox'  id='chk_1'>Chọn nếu là đáp án đúng
							</label>
						</td>
						<td style='padding-left:15px;'>
							<b>Đáp án B</b>
							<label class="checkbox-inline" style='float:right;'>
								<input type="checkbox" value="1" name='chk_b'  class='checkbox'  id='chk_2'>Chọn nếu là đáp án đúng
							</label>
						</td>
					</tr>
					<tr>
						<td style='padding-right:15px;border-right:1px solid #eee'>
							<textarea class="form-control" rows="2" name='answer_a' id='answer_a'></textarea>
						</td>
						<td style='padding-left:15px;'>
							<textarea class="form-control" rows="2" name='answer_b' id='answer_b'></textarea>
						</td>
					</tr>
					<tr>
						<td style='padding-left:0px;padding-right:15px;border-right:1px solid #eee'>
							<b>Đáp án C</b>
							<label class="checkbox-inline" style='float:right;'>
								<input type="checkbox" value="2" name='chk_c'  class='checkbox'  id='chk_3'>Chọn nếu là đáp án đúng
							</label>
						</td>
						<td style='padding-left:15px;'>
							<b>Đáp án D</b>
							<label class="checkbox-inline" style='float:right;'>
								<input type="checkbox" value="3" name='chk_d'  class='checkbox'  id='chk_4'>Chọn nếu là đáp án đúng
							</label>
						</td>
					</tr>
					<tr>
						<td style='padding-right:15px;border-right:1px solid #eee'>
							<textarea class="form-control" rows="2" name='answer_c' id='answer_c'></textarea>
						</td>
						<td style='padding-left:15px;'>
							<textarea class="form-control" rows="2" name='answer_d' id='answer_d'></textarea>
						</td>
					</tr>
					<tr>
						<td style='padding-left:0px;padding-right:15px;border-right:1px solid #eee'>
							<b>Đáp án E</b>
							<label class="checkbox-inline" style='float:right;'>
								<input type="checkbox" value="4" name='chk_e'  class='checkbox'  id='chk_5'>Chọn nếu là đáp án đúng
							</label>
						</td>
						<td style='padding-left:15px;'>
						</td>
					</tr>
					<tr>
						<td style='padding-right:15px;border-right:1px solid #eee'>
							<textarea class="form-control" rows="2" name='answer_e' id='answer_e'></textarea>
						</td>
						<td style='padding-left:15px;'>
						</td>
					</tr>
				</table>
			</div>
			<br/>
			<div class='row'>
				<input type='hidden' class='form-control' value='' name='correct' id='correct'/>
				<button type='button' class='btn btn-primary' name='add' id='add'>Thêm</button>
			</div>
			<br/>
	</div>
	
</div>

<script>
	$(document).ready(function(){

	});
	
	$(document).on('change','#grade',function(){
		if($('#subject').val()!=''){
			$grade_id=$(this).val();
			$subject_id=$('#subject').val();
			var url = '<?php echo Router::url(array('controller'=>'categories','action'=>'byGrade'));?>/' + $grade_id + '/'+$subject_id;
			$.getJSON(url, function( data ) {
				var options="";
				options+="<option value=''>Chọn chương</option>";
				for($i=0;$i<data.length;$i++)
				{
				options+="<option value='"+data[$i]['Category']['id']+"'>"+data[$i]['Category']['name']+"</option>";
				}
				$("#categories").html(options);
			});
		}
	});
	
	$(document).on('change','#subject',function(){
		if($('#grade').val()!=''){
			$subject_id=$(this).val();
			$grade_id=$('#grade').val();
			var url = '<?php echo Router::url(array('controller'=>'partner','action'=>'byGrade'));?>/' + $grade_id + '/'+$subject_id;
			$.getJSON(url, function( data ) {
				var options="";
				options+="<option value=''>Chọn chương</option>";
				for($i=0;$i<data.length;$i++)
				{
				options+="<option value='"+data[$i]['Category']['id']+"'>"+data[$i]['Category']['name']+"</option>";
				}
				$("#categories").html(options);
			});
		}
	});
	
	$(document).on('change','#categories',function(){
		$cat_id=$(this).val();
		var url = '<?php echo Router::url(array('controller'=>'partner','action'=>'get_subcategories'));?>/' + $cat_id;
		$.getJSON(url, function( data ) {
			var options="";
			options+="<option value=''>Chọn bài</option>";
			for($i=0;$i<data.length;$i++)
			{
			options+="<option value='"+data[$i]['Subcategory']['id']+"'>"+data[$i]['Subcategory']['name']+"</option>";
			}
			$("#subcategories").html(options);
		});
	});
	
	$(document).on('click','#add',function(){
		$('#correct').val('');
		$correct=$('#correct').val();	
		
		for(i=1;i<6;i++)
		{
			if($('#chk_'+i).attr('checked')=='checked'){
				$val=$('#chk_'+i).val();
				$correct=$correct+" "+$val;
				$('#correct').val($correct);				
			}
		}
		if($('#question').val()!='' && $('#answer_a').val()!='' && $('#answer_b').val()!='' && $('#answer_c').val()!='' && $('#answer_d').val()!='' && $('#correct').val()!='')
		{
			var data = {};
			data['subject']=$('#subject').val();
			data['subcategories']=$('#subcategories').val();
			data['question']=$('#question').val();
			data['0']=$('#answer_a').val();
			data['1']=$('#answer_b').val();
			data['2']=$('#answer_c').val();
			data['3']=$('#answer_d').val();
			data['4']=$('#answer_e').val();
			data['correct']=$('#correct').val();
			data['solution']=$('#solution').val();
			console.log(data);
			$.ajax({
					type:'POST',
					data: data,
					url:"<?php echo Router::url(array('controller'=>'Partner','action'=>'addquestion'));?>/",
					success:function(data){							
						$('#question').val('');
						$('#answer_a').val('');
						$('#answer_b').val('');
						$('#answer_c').val('');
						$('#answer_d').val('');
						$('#answer_e').val('');
						$('#solution').val('');
						$('.checkbox').attr('checked',false);
						alert("Cập nhật thành công");
					}				
				});	  
		}else{
			alert("Nhập đầy đủ câu hỏi, câu trả lời và chọn đáp án đúng");
		}
	});
	$(document).on('click','.checkbox',function(){		
		if(this.checked){			
			$(this).attr('checked',true);			
		}else{			
			$(this).attr('checked',false);	
		}
	});
</script>