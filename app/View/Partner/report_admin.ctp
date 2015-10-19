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
					<th style="text-align:center;width:200px;background-color:#dff0d8;">Họ tên</th>
					<th style="text-align:center;width:150px;background-color:#dff0d8;">Tổng số câu</th>
					<th style="text-align:center;width:100px;background-color:#dff0d8;">Toán</th>
					<th style="text-align:center;width:100px;background-color:#dff0d8;">Lý</th>
					<th style="text-align:center;width:100px;background-color:#dff0d8;">Hóa</th>
					<th style="text-align:center;width:100px;background-color:#dff0d8;">Anh</th>
					<th style="text-align:center;width:100px;background-color:#dff0d8;">Sinh</th>
					<th style="text-align:center;width:120px;background-color:#dff0d8;">Đã kiểm tra</th>			
				</tr>
				<?php foreach($people_insert as $value){ ?>
					<tr>
						<td><?php echo $value['Person']['fullname'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['total'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['match'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['physical'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['chemistry'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['english'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['biological'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['status'] ?></td>
					</tr>
				<?php } ?>
			</table>
		</div>
		<div class='row' style='margin:0px;'>
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
				</tr>
				<?php foreach($people_classify as $value){ ?>
					<tr>
						<td><?php echo $value['Person']['fullname'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['total'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['match'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['physical'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['chemistry'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['english'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['biological'] ?></td>
						<td style="text-align:center;"><?php echo $value['Person']['status'] ?></td>
					</tr>
				<?php } ?>
			</table>
		</div>
	</form>
</div>
