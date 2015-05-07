<div class="panel panel-default col-sm-10 col-sm-offset-1" style='margin-top:50px; padding:0px;'>
    <div class="panel-heading">
    <h3 class="panel-title"><b>Thẻ Điện thoại</b></h3>		
    </div>
	<div class="panel-body">
		<form action="" method="POST" name="frmrechargecard" role="form" class="form-horizontal">
		
		<div class='row' style='margin:0px;'>			
			<div class='col-sm-5 col-sm-offset-1'>
				<br/>
				<div class='row'>
					<?php echo $this->Html->image('viettel.jpg') ?>
				</div>
				</br>			
				<div class='row'>
					<label>Số seri (Số thẻ):</label>			
				</div>
				<div class='row'>
					<input type='text' value='' name='seri' class='form-control'/>
				</div>
				<br/>
				<div class='row'>
					<label>Mã PIN (Mã nạp):</label>			
				</div>
				<div class='row'>
					<input type='text' value='' name='pin' class='form-control'/>			
				</div>
				<br/>
				<div class='row'>
					<input type='submit' value='Nạp thẻ' class='btn btn-primary col-sm-12'/>
				</div>
			</div>
			<div class='col-sm-4 col-sm-offset-1'>
				<br/>
				<table class='table table-bordered'>
					<tr>
						<th style='text-align:center;' colspan='2'>Bảng quy đổi</th>
					</tr>
					<tr>
						<td style='text-align:center;'>50.000 VND</td>
						<td style='text-align:center;'>10 PC</td>
					</tr>
					<tr>
						<td style='text-align:center;'>100.000VND</td>
						<td style='text-align:center;'>30 PC</td>
					</tr>
					<tr>
						<td style='text-align:center;'>200.000 VND</td>
						<td style='text-align:center;'>90 PC</td>
					</tr>
					<tr>
						<td style='text-align:center;'>500.000 VND</td>
						<td style='text-align:center;'>365 PC</td>
					</tr>
				</table>
			</div>
		</div>
		</form>
	</div>
</div>
<div class='col-sm-10 col-sm-offset-1' style='margin-bottom:50px; padding:0px;'>
	
</div>