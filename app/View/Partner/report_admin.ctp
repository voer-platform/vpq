<div style="margin:10px 50px 10px 50px">
	<!-- right nav -->
	<div class='row' style='margin:0px;'>
		<div class='col-lg-12'>
			<div class='row'>
				<h2>Báo cáo thống kê</h2>
				<hr/>
			</div>
		</div>
	</div>
	<form action="" method="POST" name="frmreportadmin" role="form" class="form-horizontal">
		<div class='row' style='margin:0px;'>
			<h3>Kết quả nhóm nhập liêu:</h3>
		</div>
		<div class='row' style='margin:0px;'>
			<table class="table table-striped table-bordered">
				<tr>
					<th style="text-align:center;width:200px;background-color:#d9edf7;">Họ tên</th>
					<th style="text-align:center;width:150px;background-color:#d9edf7;">Tổng số câu</th>
					<th style="text-align:center;width:100px;background-color:#d9edf7;">Toán</th>
					<th style="text-align:center;width:100px;background-color:#d9edf7;">Lý</th>
					<th style="text-align:center;width:100px;background-color:#d9edf7;">Hóa</th>
					<th style="text-align:center;width:100px;background-color:#d9edf7;">Anh</th>
					<th style="text-align:center;width:100px;background-color:#d9edf7;">Sinh</th>
					<th style="text-align:center;width:120px;background-color:#d9edf7;">Hủy</th>
					<th style="text-align:center;width:120px;background-color:#d9edf7;">Đã kiểm tra</th>
					<th style="text-align:center;width:120px;background-color:#d9edf7;">Thanh Toán</th>
					<th style="text-align:center;width:120px;background-color:#d9edf7;"></th>
				</tr>
				<?php $i=0; ?>
				<?php foreach($people_insert as $value){ ?>
					<tr>
						<td><?php echo $value['Person']['fullname'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['total'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['math'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['physical'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['chemistry'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['english'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['biological'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['delete'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['status'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['number'] ?></td>
						<td style="text-align:center;">
							<input type="hidden" class="form-control" name="id_partner[]" value="<?php echo $value['Person']['id'] ?>" />
							<input type="text" class="form-control" name="socau[]" value="0" />							
						</td>
					</tr>
				<?php } ?>
					<tr>
						<td style="text-align:center;background-color:#DFF0D8;"><b>Tổng</b></td>
						<td style="text-align:center;background-color:#DFF0D8;"><?php echo $total ?></td>
						<td style="text-align:center;background-color:#DFF0D8;"><?php echo $total_math ?></td>
						<td style="text-align:center;background-color:#DFF0D8;"><?php echo $total_physical ?></td>
						<td style="text-align:center;background-color:#DFF0D8;"><?php echo $total_chemistry ?></td>
						<td style="text-align:center;background-color:#DFF0D8;"><?php echo $total_english ?></td>
						<td style="text-align:center;background-color:#DFF0D8;"><?php echo $total_biological ?></td>
						<td style="text-align:center;background-color:#DFF0D8;"><?php echo $total_delete ?></td>
						<td style="text-align:center;background-color:#DFF0D8;"><?php echo $total_status ?></td>
						<td style="text-align:center;background-color:#DFF0D8;"></td>
						<td style="text-align:center;background-color:#DFF0D8;"></td>
					</tr>
			</table>
		</div>
		<!--<div class='row' style='margin:0px;'>
			<h3>Kết quả nhóm phân loại</h3>
		</div>
		<div class='row' style='margin:0px;'>
			<table class="table table-striped table-bordered">
				<tr>
					<th style="text-align:center;width:200px;background-color:#d9edf7;">Họ tên</th>
					<th style="text-align:center;width:150px;background-color:#d9edf7;">Tổng số câu</th>
					<th style="text-align:center;width:100px;background-color:#d9edf7;">Toán</th>
					<th style="text-align:center;width:100px;background-color:#d9edf7;">Lý</th>
					<th style="text-align:center;width:100px;background-color:#d9edf7;">Hóa</th>
					<th style="text-align:center;width:100px;background-color:#d9edf7;">Anh</th>
					<th style="text-align:center;width:100px;background-color:#d9edf7;">Sinh</th>
					<th style="text-align:center;width:120px;background-color:#d9edf7;">Phân loại trùng</th>
					<th style="text-align:center;width:120px;background-color:#dff0d8;">Đã Thanh Toán</th>
					<th style="text-align:center;width:120px;background-color:#dff0d8;"></th>	
				</tr>
				<?php foreach($people_classify as $value){ ?>
					<tr>
						<td><?php echo $value['Person']['fullname'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['total'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['math'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['physical'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['chemistry'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['english'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['biological'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['status'] ?></td>
						<td style="text-align:center;"></td>
						<td style="text-align:center;">
							<input type="hidden" class="form-control" name="id_partner[]" value="<?php echo $value['Person']['id'] ?>" />
							<input type="text" class="form-control" name="socau[]" value="0" />							
						</td>
					</tr>
				<?php } ?>					
			</table>
		</div>-->
		<div class='row' style='margin:0px;'>
			<input type="submit" class="btn btn-primary" name="submit" value="Thanh Toán"/>
		</div>
	</form>
</div>
