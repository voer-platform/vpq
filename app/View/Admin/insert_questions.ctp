<?php echo $this->Html->script('/ckeditor/ckeditor.js');?>
<?php echo $this->Html->script('/ckfinder/ckfinder.js');?>
<?php echo $this->Html->css('insert-questions-admin.css'); ?>

<div class='admin-insert-questions'>
	<!-- left nav -->
	<?php echo $this->element('admin-left-nav'); ?>

	<!-- right nav -->
	<div class='col-lg-10'>
		<!-- visible form -->
		<div>	
			
			<div class='row'>
				<legend>Thêm câu hỏi</legend>
				<?php echo $this->Form->create('Question', array('type' => 'file')); ?>
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
				</div>
			</div>
			<div class='row'>
				<hr/>
			</div>
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
							<textarea class="form-control" rows="2" name='answer_a'></textarea>
						</td>
						<td style='padding-left:15px;'>
							<textarea class="form-control" rows="2" name='answer_b'></textarea>
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
							<textarea class="form-control" rows="2" name='answer_c'></textarea>
						</td>
						<td style='padding-left:15px;'>
							<textarea class="form-control" rows="2" name='answer_d'></textarea>
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
	
</div>

<!-- elf file manager -->
<?php //$this->TinymceElfinder->defineElfinderBrowser()?>
<!--<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>-->

<!-- script -->
<!--<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>-->
<script>
	/*var i = 0;
	// tinyMCE
    tinymce.init({
    	selector : '.tinymce-content',
    	plugins : 'code',
    	relative_urls: false,
    	toolbar: 'code image',
    	menubar : '',
    	extended_valid_elements: 'figure,figcaption,maction,maligngroup,malignmark,math,menclose,merror,mfenced,mfrac,mglyph,mi,mlabeledtr,mlongdiv,mmultiscripts,mn,mo,mover,mpadded,mphantom,mroot,mrow,ms,mscarries,mscarry,msgroup,msline,mspace,msqrt,msrow,mstack,mstyle,msubsup,msup,mtable,mtd,mtext,mtr,munder,munderover,semantics,sub,mfrac,sup,annotation', 
    	file_browser_callback : elFinderBrowser
    });

    tinymce.init({
    	selector: '.tinymce-answer',
    	height: 50,
    	width: 300,
    	plugins : 'code',
    	relative_urls: false,
    	toolbar: 'code',
    	extended_valid_elements: 'figure,figcaption,maction,maligngroup,malignmark,math,menclose,merror,mfenced,mfrac,mglyph,mi,mlabeledtr,mlongdiv,mmultiscripts,mn,mo,mover,mpadded,mphantom,mroot,mrow,ms,mscarries,mscarry,msgroup,msline,mspace,msqrt,msrow,mstack,mstyle,msubsup,msup,mtable,mtd,mtext,mtr,munder,munderover,semantics,sub,mfrac,sup,annotation', 
    	menubar : ''
    });

    // disable multiple correct question
    $(".answer-correct").each(function()
	{
	    $(this).change(function()
	    {
	        $(".answer-correct").prop('checked',false);
	        $(this).prop('checked',true);
	    });
	});

    // add more attachments
    $('#btn-add-attachments').click(function(){
    	i++;
    	$('#attachments').append("<input type='file' name='data[Attachment][" + i + "]' class='form-control' id='QuestionAttachment-" + i + "'>");
    	$('#btn-add-attachments').text("<?php echo __('More attachments'); ?>");
    	$('#attachments-description').text("<?php echo __('Click button to add more'); ?>");
    });*/
	$(document).ready(function(){
		$url="http://pls.local:1080/";     

			var editor = CKEDITOR.replace( 'question',
				{
					filebrowserBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html',
					filebrowserImageBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html?type=Images',
					filebrowserFlashBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html?type=Flash',
					filebrowserUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
					filebrowserImageUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
					filebrowserFlashUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					fullPage: true,
					allowedContent: true,
				}
				
			);
			CKFinder.setupCKEditor( editor, '../' ) ;
			
			var editor2 = CKEDITOR.replace( 'answer_a',
				{
					filebrowserBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html',
					filebrowserImageBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html?type=Images',
					filebrowserFlashBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html?type=Flash',
					filebrowserUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
					filebrowserImageUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
					filebrowserFlashUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					fullPage: true,
					allowedContent: true,
				}
				
			);
			CKFinder.setupCKEditor( editor2, '../' ) ;
			
			var editor3 = CKEDITOR.replace( 'answer_b',
				{
					filebrowserBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html',
					filebrowserImageBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html?type=Images',
					filebrowserFlashBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html?type=Flash',
					filebrowserUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
					filebrowserImageUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
					filebrowserFlashUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					fullPage: true,
					allowedContent: true,
				}
				
			);
			CKFinder.setupCKEditor( editor3, '../' ) ;
			
			var editor4 = CKEDITOR.replace( 'answer_c',
				{
					filebrowserBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html',
					filebrowserImageBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html?type=Images',
					filebrowserFlashBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html?type=Flash',
					filebrowserUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
					filebrowserImageUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
					filebrowserFlashUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					fullPage: true,
					allowedContent: true,
				}
				
			);
			CKFinder.setupCKEditor( editor4, '../' ) ;
			
			var editor5 = CKEDITOR.replace( 'answer_d',
				{
					filebrowserBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html',
					filebrowserImageBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html?type=Images',
					filebrowserFlashBrowseUrl : $url+'app/webroot/ckfinder/ckfinder.html?type=Flash',
					filebrowserUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
					filebrowserImageUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
					filebrowserFlashUploadUrl : $url+'app/webroot/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					fullPage: true,
					allowedContent: true,
				}
				
			);
			CKFinder.setupCKEditor( editor5, '../' ) ;
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
	
	$(document).on('change','#categories',function(){
		$cat_id=$(this).val();
		var url = '<?php echo Router::url(array('controller'=>'subcategories','action'=>'get_subcategories'));?>/' + $cat_id;
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
		for(i=1;i<5;i++)
		{
			if($('#chk_'+i).attr('checked')=='checked'){
				$val=$('#chk_'+i).val();
				$correct=$correct+" "+$val;
				$('#correct').val($correct);
			}
		}
		if($('#subcategories').val()!='' && $('#correct').val()!='')
		{
			var data = {};
			data['subcategories']=$('#subcategories').val();
			data['question']=CKEDITOR.instances['question'].getData();
			data['0']=CKEDITOR.instances['answer_a'].getData();
			data['1']=CKEDITOR.instances['answer_b'].getData();
			data['2']=CKEDITOR.instances['answer_c'].getData();
			data['3']=CKEDITOR.instances['answer_d'].getData();
			data['correct']=$('#correct').val();
			console.log(data);
			$.ajax({
					type:'POST',
					data: data,
					url:"<?php echo Router::url(array('controller'=>'admin','action'=>'addquestion'));?>/",
					success:function(data){							
						CKEDITOR.instances['question'].setData('');
						CKEDITOR.instances['answer_a'].setData('');
						CKEDITOR.instances['answer_b'].setData('');
						CKEDITOR.instances['answer_c'].setData('');
						CKEDITOR.instances['answer_d'].setData('');
						$('.checkbox').attr('checked',false);
						alert("Cập nhật thành công");
					}				
				});	  
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