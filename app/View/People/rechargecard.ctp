<div class='row'>
	<div class='col-sm-12'>
			<h2>Nạp xu bằng thẻ cào</h2>
			<hr/>
	</div>
</div>
<div class='row'>
	<div class='col-sm-9'>
		<div class="panel panel-default" style='padding:0px;'>
			<div class="panel-heading">
			<h3 class="panel-title"><b>Nạp thẻ</b></h3>		
			</div>
			<div class="panel-body">
				<form action="" method="POST" name="frmrechargecard" role="form" class="form-horizontal">
					<div class='row' style='padding-left:20px;'>
						<div class='col-sm-10' style='padding-right:0px;'>
							<h4>Chọn loại thẻ<h4/>
							<hr/>
						</div>
					</div>
					<div class='row' style='padding-left:20px;'>						
						<div class='col-sm-2'>
							<?php echo $this->Html->image('viettel.png',array('style'=>'width:120px;height:60px;'));?>
							<input type='radio' style='width:100%;height:100%;position:absolute;top:0px;opacity:0;' name='nhamang' value='1' checked/>
						</div>
						<div class='col-sm-2'>
							<?php echo $this->Html->image('vina.png',array('style'=>'width:120px;height:60px;'));?>
							<input type='radio' style='width:100%;height:100%;position:absolute;top:0px;opacity:0;' name='nhamang' value='2' />
						</div>
						<div class='col-sm-2'>
							<?php echo $this->Html->image('mobile.png',array('style'=>'width:120px;height:60px;'));?>
							<input type='radio' style='width:100%;height:100%;position:absolute;top:0px;opacity:0;' name='nhamang' value='3' />
						</div>
						<div class='col-sm-2'>
							<?php echo $this->Html->image('vcoi.png',array('style'=>'width:120px;height:60px;border:1px solid #ccc;border-radius:4px;'));?>
							<input type='radio' style='width:100%;height:100%;position:absolute;top:0px;opacity:0;' name='nhamang' value='4' />
						</div>
						<div class='col-sm-2'>
							<?php echo $this->Html->image('fpt-gate.png',array('style'=>'width:120px;height:60px;border:1px solid #ccc;border-radius:4px;'));?>
							<input type='radio' style='width:100%;height:100%;position:absolute;top:0px;opacity:0;' name='nhamang' value='5' />
						</div>
					</div>
					<br/>
					<div class='row' style='padding-left:20px;'>
						<div class='col-sm-5'>
							<input type='text' class='form-control' placeholder='Mã Thẻ' name='pin'/>
						</div>
						<div class='col-sm-5' style='padding-right:0px;'>
							<input type='text' class='form-control' placeholder='Số seri' name='seri'/>
						</div>
					</div>
					<br/>
					<div class='row' style='padding-left:20px;'>
						<div class='col-sm-5'>
							<input type='submit' class='btn btn-primary' value='Nạp xu' name='napthe'/>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class='col-sm-3'>
		<div class="panel panel-default" style='padding:0px;'>
			<div class="panel-heading" style='background-color:#fff'>
				<h3 class="panel-title"><b>Bảng giá</b></h3>		
			</div>
			<div class="panel-body" style='padding-top:0px;padding-bottom:0px;'>
				<div class='row' style='background-color:#ccc;padding-top:10px;padding-bottom:10px;'>
					<div class='col-sm-6' style='text-align:center;'>
						<b>Mệnh giá</b>
					</div>
					<div class='col-sm-6' style='text-align:center;'>
						<b>Coin</b>
					</div>
				</div>
				<div class='row' style='background-color:#fff;padding-top:10px;padding-bottom:10px;'>
					<div class='col-sm-6' style='text-align:center;'>
						50.000
					</div>
					<div class='col-sm-6' style='text-align:center;'>
						10
					</div>
				</div>
				<div class='row' style='background-color:#f5f5f5;padding-top:10px;padding-bottom:10px;'>
					<div class='col-sm-6' style='text-align:center;'>
						100.000
					</div>
					<div class='col-sm-6' style='text-align:center;'>
						30
					</div>
				</div>
				<div class='row' style='background-color:#fff;padding-top:10px;padding-bottom:10px;'>
					<div class='col-sm-6' style='text-align:center;'>
						200.000
					</div>
					<div class='col-sm-6' style='text-align:center;'>
						90
					</div>
				</div>
				<div class='row' style='background-color:#f5f5f5;padding-top:10px;padding-bottom:10px;'>
					<div class='col-sm-6' style='text-align:center;'>
						500.000
					</div>
					<div class='col-sm-6' style='text-align:center;'>
						365
					</div>
				</div>
			</div>
		</div>
	</div>
</div>