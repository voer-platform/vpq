<script type="text/javascript"
	  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
	</script>
<div class='admin-insert-questions'>
	<!-- right nav -->
	<div class='row' style='margin:0px;'>
		<div class='col-lg-12'>
			<div class='row'>
				<h2>Danh sách câu hỏi</h2>
				<hr/>
			</div>
		</div>
	</div>
	<form action="" method="POST" name="frmimportexcel" role="form"  enctype="multipart/form-data" class="form-horizontal">
	<div class='row' style='margin:0px;'>
		<div class="col-lg-3" style="padding-left:0px;">
			<select class='form-control' name='subject' id='subject'>
				<option value=''>-Chọn môn-</option>						
				<?php foreach($subject as $sub): ?>
				<option value='<?php echo $sub['Subject']['id'];?>' <?php echo ($sub['Subject']['id']==$subject_id)?"selected":"" ?>><?php echo $sub['Subject']['name'];?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="col-lg-3" style="padding-left:0px;">
			<select class='form-control' name='book' id='book'>
				<option value=''>-Chọn sách-</option>
				<?php if(!empty($book)): ?>
					<?php foreach($book as $book): ?>
					<option value='<?php echo $book['Book']['id'];?>' <?php echo ($book['Book']['id']==$book_id)?"selected":"" ?>><?php echo $book['Book']['name'];?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="col-lg-3" style="padding-left:0px;">
			<select class='form-control' name='state' id='state'>
				<option value=''>-Trạng thái-</option>
				<option value='0' <?php echo (isset($state) && $state==0)?"selected":"" ?>>Chưa kiểm tra</option>
				<option value='1' <?php echo (isset($state) && $state==1)?"selected":"" ?>>Chưa phân loại</option>
				<option value='2' <?php echo (isset($state) && $state==2)?"selected":"" ?>>Hủy</option>
				<option value='3' <?php echo (isset($state) && $state==3)?"selected":"" ?>>Đã phân loại</option>
			</select>
		</div>
		<div class="col-lg-3">
			<input type='submit' class='btn btn-primary' name='search' value='Tìm kiếm' />
		</div>
	</div>
	
	<div class='row' style='margin:0px;'>
		<div class='col-lg-12' style='padding:0px;'>
			<hr style='margin:20px 0px 10px 0px'/>
			<div class='row' style='margin:0px;'>
				<div class='col-lg-6' style='padding-left:0px;'>
					<h4>Môn: <span id='mon' style='color:#1EF059'><?php echo $sub_name; ?></span></h4>					
				</div>
				<div class='col-lg-6' style='padding-right:0px;'>
					<h4 style='float:right;'>Số lượng câu đã nhập: <span id='sach' style='color:#1EF059'><?php echo $count; ?></span></h4>
				</div>
			</div>
			<hr style='margin:10px 0px 10px 0px'/>
			<div class='row' style='margin:0px;'>
				<table id="tbl_questions" class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th style='text-align:center;width:70px;'>STT</th>				
							<th style='text-align:center;'>Nội dung</th>
							<th style='text-align:center;width:150px;'>Trạng thái</th>
							<th style='text-align:center;width:105px;'></th>
						</tr>
					<thead>
					<tbody>
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
									<span class="label label-default">Chưa kiểm tra</span>
								<?php } ?>
								<?php if($ques['ImportQuestion']['check_question']==1){ ?>
									<span class="label label-warning">Đã kiểm tra</span>
								<?php } ?>
								<?php if($ques['ImportQuestion']['check_question']==2){ ?>
									<span class="label label-danger">Hủy</span>
								<?php } ?>
								<?php if($ques['ImportQuestion']['check_question']==3){ ?>
									<span class="label label-success">Đã phân loại</span>
								<?php } ?>
							</td>
							<td style='text-align:center;'>
								<?php if($ques['ImportQuestion']['check_question']==0){ ?>
									<?php echo $this->Html->link('', array('controller' => 'partner', 'action' => 'view_question',$ques['ImportQuestion']['id']), array('class' => 'btn btn-dashboard btn-primary glyphicon glyphicon-eye-open','title'=>'Xem chi tiết')) ?>
								<?php }else{ ?>
									<?php echo $this->Html->link('', array('controller' => 'partner', 'action' => 'view_question',$ques['ImportQuestion']['id']), array('class' => 'btn btn-dashboard btn-primary glyphicon glyphicon-eye-open','title'=>'Xem chi tiết','disabled')) ?>
								<?php } ?>
								<a onclick="return confirm ('Bạn có muốn xóa câu hỏi này không?')" class='btn btn-danger glyphicon glyphicon-trash' title='Xóa' href="<?php echo $this->Html->url(array('controller'=>'Partner','action'=> 'delete')); ?>?id=<?php echo $ques['ImportQuestion']['id'] ?>"></a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				
				</table>						
			</div>
			<!--<div class='row' style='margin:0px;'>
				<div class="paging">
				<?php /*
					echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
					echo $this->Paginator->numbers(array('separator' => ''));
					echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')); */
				?>
			</div>-->
		</div>
	</div>
	
	</form>
</div>
<div id="modal_message" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="margin-top:100px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Thông báo</h4>
            </div>
            <div class="modal-body" style='text-align:center'>
                <p id='tb' style='font-size:16px;'>Bạn đã được thanh toán <?php echo $number ?> VND.</p>
            </div>
            <div class="modal-footer">
				<button type="button" class="btn btn-primary" id="accept" data-dismiss="modal">Xác nhận</button>
                <button type="button" class="btn btn-danger" id="notaccept" data-dismiss="modal">Không xác nhận</button>
            </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
		var $status = <?php echo $accept ?>;
		$('#tbl_questions').DataTable(
			{
				"lengthMenu": [[50, 25, 10], [50, 25, 10]]
			}
		);
		if($status==1){
			$('#modal_message').modal({
						backdrop: false
					});	
		}		
	});
	
	$(document).on('click','#accept',function(){
		var url = '<?php echo Router::url(array('controller'=>'partner','action'=>'accept'));?>/0';
		$.getJSON(url, function( data ) {
			alert("Xác nhận thành công.");
		});	
	})
	
	$(document).on('click','#notaccept',function(){
		var url = '<?php echo Router::url(array('controller'=>'partner','action'=>'accept'));?>/2';
		$.getJSON(url, function( data ) {
			alert("Yêu cầu của bạn đã được gửi, mời bạn đến gặp người quản lý để giải quyết.");
		});	
	})
	
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