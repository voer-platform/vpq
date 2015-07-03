<div class='admin-insert-questions'>
	<!-- right nav -->
	<div class='row' style='margin:0px;'>
		<div class='col-lg-12'>
			<div class='row'>
				<h2>Import questions from excel</h2>
				<hr/>
			</div>
		</div>
	</div>
	<form action="" method="POST" name="frmimportexcel" role="form"  enctype="multipart/form-data" class="form-horizontal">
	<div class='row' style='margin:0px;'>
		<div class='col-lg-3' style='border-right:solid 1px #eee;'>
			<div class='row' style='margin-right:0px;'>
				<input type='file' name='file_import' class='form-control'/>
				</div>
				<br/>
			<div class='row' style='margin-right:0px;'>
				<input type='submit' name='import_excel' value='Import Excel' class='btn btn-primary'/>
			</div>			
			<div class='row' style='margin-right:0px;'>
				<hr/>
			</div>
			<div class='row' style='margin-right:0px;'>
				<select class='form-control' name='subject' id='subject'>
					<option value=''>-Chọn môn-</option>						
					<?php foreach($subject as $sub): ?>
					<option value='<?php echo $sub['Subject']['id'];?>' <?php echo ($sub['Subject']['id']==$subject_id)?"selected":"" ?>><?php echo $sub['Subject']['name'];?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<br/>
			<div class='row' style='margin-right:0px;'>
				<select class='form-control' name='book' id='book'>
					<option value=''>-Chọn sách-</option>
					<?php if(!empty($book)): ?>
						<?php foreach($book as $book): ?>
						<option value='<?php echo $book['Book']['id'];?>' <?php echo ($book['Book']['id']==$book_id)?"selected":"" ?>><?php echo $book['Book']['name'];?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
			<!--<br/>
			<div class='row' style='margin-right:0px;'>
				<select class='form-control' name='categories' id='categories'>
					<option value=''>-Chọn chương-</option>
					<?php if(!empty($categories)): ?>
						<?php foreach($categories as $categories): ?>
						<option value='<?php echo $categories['Category']['id'];?>' <?php echo ($categories['Category']['id']==$category_id)?"selected":"" ?>><?php echo $categories['Category']['name'];?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
			<br/>
			<div class='row' style='margin-right:0px;'>
				<select class='form-control' name='subcategories' id='subcategories'>
					<option value=''>-Chọn bài-</option>
					<?php if(!empty($subcategories)): ?>
						<?php foreach($subcategories as $subcategories): ?>
						<option value='<?php echo $subcategories['Subcategory']['id'];?>' <?php echo ($subcategories['Subcategory']['id']==$subcategory_id)?"selected":"" ?>><?php echo $subcategories['Subcategory']['name'];?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>-->
			<br/>
			<div class='row' style='margin-right:0px;'>
				<select class='form-control' name='state' id='state'>
					<option value=''>-Trạng thái-</option>
					<option value='0' <?php echo ($state==0)?"selected":"" ?>>Chưa kiểm tra</option>
					<option value='1' <?php echo ($state==1)?"selected":"" ?>>Chưa phân loại</option>
					<option value='2' <?php echo ($state==2)?"selected":"" ?>>Hủy</option>
					<option value='3' <?php echo ($state==3)?"selected":"" ?>>Đã phân loại</option>
				</select>
			</div>
			<br/>
			<div class='row' style='margin-right:0px;'>
				<input type='submit' class='btn btn-primary' name='search' value='Tìm kiếm' />
			</div>
		</div>
		<div class='col-lg-9' style='padding-right:0px;'>
			<!--<div class='row' style='margin:0px;'>
				<h3 style='margin:0px;'>Danh sách câu hỏi</h3>
			</div>
			<br/>-->
			<div class='row' style='margin:0px;'>
				<div class='col-lg-6' style='padding-left:0px;'>
					<h4>Môn: <span id='mon' style='color:#1EF059'><?php echo $sub_name; ?></span></h4>					
				</div>
				<div class='col-lg-6' style='padding-right:0px;'>
					<h4 style='float:right;'>Sách: <span id='sach' style='color:#1EF059'><?php echo $book_name; ?></span></h4>
				</div>
			</div>
			<hr style='margin-top:0px;'/>
			<div class='row' style='margin:0px;'>
				<table class='table table-striped table-bordered'>
					<tr>
						<th style='text-align:center;width:70px;'>STT</th>
						<!--<th style='text-align:center;'>Môn</th>
						<th style='text-align:center;'>Sách</th>
						<th style='text-align:center;'>Trang</th>
						<th style='text-align:center;'>Câu</th>-->						
						<th style='text-align:center;'>Nội dung</th>
						<th style='text-align:center;width:150px;'>Trạng thái</th>
						<th style='text-align:center;width:105px;'></th>
					</tr>
					<?php foreach($import_question as $key=>$ques): ?>
					<tr>
						<td style='text-align:center;'><?php echo $key+1; ?></td>
						<!--<td><?php echo $ques['ImportQuestion']['subject']; ?></td>
						<td><?php echo $ques['ImportQuestion']['book_name']; ?></td>
						<td><?php echo $ques['ImportQuestion']['page']; ?></td>						
						<td><?php echo $ques['ImportQuestion']['sentence']; ?></td>-->						
						<td><?php echo $ques['ImportQuestion']['question']; ?></td>
						<td style='text-align:center'>
							<?php if($ques['ImportQuestion']['check_question']==0){ ?>
								<span class="label label-default">chưa kiểm tra</span>
							<?php } ?>
							<?php if($ques['ImportQuestion']['check_question']==1){ ?>
								<span class="label label-warning">chưa phân loại</span>
							<?php } ?>
							<?php if($ques['ImportQuestion']['check_question']==2){ ?>
								<span class="label label-danger">hủy</span>
							<?php } ?>
							<?php if($ques['ImportQuestion']['check_question']==3){ ?>
								<span class="label label-success">đã phân loại</span>
							<?php } ?>
						</td>
						<td style='text-align:center;'>
							<?php if($ques['ImportQuestion']['check_question']==0){ ?>
							<?php echo $this->Html->link('', array('controller' => 'partner', 'action' => 'view_question',$ques['ImportQuestion']['id']), array('class' => 'btn btn-dashboard btn-primary glyphicon glyphicon-eye-open','title'=>'Xem chi tiết','target'=>'_blank')) ?>
							<a onclick="return confirm ('Bạn có muốn xóa câu hỏi này không?')" class='btn btn-danger glyphicon glyphicon-trash' title='Xóa' href="<?php echo $this->Html->url(array('controller'=>'admin','action'=> 'import_excel')); ?>?delete=<?php echo $ques['ImportQuestion']['id'] ?>"></a>
							<?php }else{ ?>
								<?php echo $this->Html->link('', array('controller' => 'partner', 'action' => 'view_question',$ques['ImportQuestion']['id']), array('class' => 'btn btn-dashboard btn-primary glyphicon glyphicon-eye-open','title'=>'Xem chi tiết','target'=>'_blank','disabled')) ?>
								<a onclick="return confirm ('Bạn có muốn xóa câu hỏi này không?')" class='btn btn-danger glyphicon glyphicon-trash' title='Xóa' disabled href="<?php echo $this->Html->url(array('controller'=>'admin','action'=> 'import_excel')); ?>?delete=<?php echo $ques['ImportQuestion']['id'] ?>"></a>
							<?php } ?>
						</td>
					</tr>
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
		</div>
	</div>
	
	</form>
</div>

<script>
	$(document).ready(function(){
		
	});
	$(document).on('change','#subject',function(){
		if($(this).val()!=''){
			$subject_id=$(this).val();
			var url = '<?php echo Router::url(array('controller'=>'partner','action'=>'getBook'));?>/' + $subject_id;
			$.getJSON(url, function( data ) {
				var options="";
				options+="<option value=''>-Chọn sách-</option>";
				for($i=0;$i<data.length;$i++)
				{
				options+="<option value='"+data[$i]['Book']['id']+"' data-id='"+data[$i]['Book']['subject_id']+"' data-grade='"+data[$i]['Book']['grade_id']+"'>"+data[$i]['Book']['name']+"</option>";
				}
				$("#book").html(options);
			});			
		}
	});
	/*$(document).on('change','#book',function(){
		if($(this).val()!=''){
			$book_id=$(this).val();
			var url = '<?php echo Router::url(array('controller'=>'partner','action'=>'getCategory'));?>/' + $book_id;
			$.getJSON(url, function( data ) {
				var options="";
				options+="<option value=''>-Chọn sách-</option>";
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
	});*/
</script>