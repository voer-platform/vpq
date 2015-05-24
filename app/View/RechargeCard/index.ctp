<?php echo $this->Html->css('rechargecard.css');?>
<div class='row'>
	<div class='col-sm-12'>
			<h2>Nạp xu bằng thẻ cào</h2>
			<hr/>
	</div>
</div>
<div class='row'>
	<div class='col-sm-9'>
		<?php if(isset($rechargeMess)){ ?>
		
		<?php if($statusType=='success'){ ?>
			<script>
				mixpanel.track("Recharge Card Success", {"user_id": "<?php echo $user['id']; ?>"});
			</script>
		<?php } ?>
		
		<div class="alert alert-<?php echo $statusType; ?>">
			<?php echo $rechargeMess; ?>
		</div>
		<?php } ?>
		
		<div role="tabpanel">
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs grade-tabs" role="tablist">
				<li role="presentation" class="<?php if($rechargeMethod=='phonecard'){ ?>active<?php } ?>"><a href="#phonecard" aria-controls="phonecard" role="tab" data-toggle="tab">Nạp thẻ điện thoại</a></li>
				<li role="presentation" class="<?php if($rechargeMethod!='phonecard'){ ?>active<?php } ?>"><a href="#giftcard" aria-controls="giftcard" role="tab" data-toggle="tab">Nạp mã quà tặng</a></li>
		  </ul>
		  <!-- Tab panes -->
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane <?php if($rechargeMethod=='phonecard'){ ?>active<?php } ?>" id="phonecard">
				<form action="<?php echo $this->Html->url(array('controller'=>'Rechargecard', 'action'=>'recharge')); ?>" method="POST" name="frmrechargecard" role="form" class="form-horizontal">
					<div class='row' style='padding-left:20px;'>
						<div class='col-sm-10' style='padding-right:0px;'>
							<br/>
							<h4>Chọn loại thẻ<h4/>
							<hr/>
						</div>
					</div>
					<div class='row' style='padding-left:20px;'>	
						<?php foreach($CardTypes AS $k=>$type){ ?>
						<div class="col-sm-2">
							<input type="radio" class="cardtype-radio" <?php if($k==0){ ?>checked<?php } ?> name="type" value="<?php echo $type['CardType']['id']; ?>" data-telco="<?php echo $type['CardType']['name']; ?>" />
							<?php echo $this->Html->image("cards/".$type['CardType']['id'].".png", array('class'=>'cardtype-image'));?>
						</div>
						<?php } ?>
					</div>
					<br/>
					<div class='row' style='padding-left:20px;'>
						<div class="col-md-12">
							<label class="control-label">Bạn đã chọn loại thẻ: <font color="green" id="telco"><?php echo $CardTypes[0]['CardType']['name']; ?></font></label>
							<br/><br/>
						</div>
						
						<div class="col-sm-5">
							<input type="text" class="form-control" placeholder="Mã Thẻ" name="code" required autocomplete="off" />
						</div>
						<div class="col-sm-5 pdr-0">
							<input type="text" class="form-control" placeholder="Số seri" name="seri" required autocomplete="off" />
						</div>
					</div>
					<br/>
					<div class='row' style='padding-left:20px;'>
						<div class='col-sm-5'>
							<input type='submit' id="recharge-btn" class='btn btn-primary' value='Nạp xu' name='napthe'/>
						</div>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane <?php if($rechargeMethod!='phonecard'){ ?>active<?php } ?>" id="giftcard">
				<form action="<?php echo $this->Html->url(array('controller'=>'Rechargecard', 'action'=>'rechargeGiftcard')); ?>" method="POST" class="form-inline">
					<div class="row" style="padding-left:20px;">
						<div class="col-md-12">
							<br/>
							<label>Bạn hãy nhập 13 kí tự mã thẻ để nhận quà</label>
							<br/><br/>
							<input type="text" placeholder="Mã quà tặng" required autocomplete="off" name="giftcode" class="form-control col-md-6 w-300" />&nbsp;
							<input type="submit" class="btn btn-primary" value="Nhận quà" />
						</div>
					</div>	
				</form>
			</div>
		  </div>
		</div>
		<br/><br/><br/>
	</div>
	<div class='col-sm-3'>
		<?php if(isset($promotion)){ ?>
		<div class="panel panel-default" style='padding:0px;'>
			<div class="panel-heading" style='background-color:#fff'>
				<h3 class="panel-title"><b>Khuyến mại</b></h3>		
			</div>
			<div class="panel-body">
				Bạn được tặng <b><font color="red"><?php echo $promotion['percent']; ?>%</font></b> giá trị thẻ nạp từ ngày 
					<b><font color="green"><?php echo date('d/m/Y', strtotime($promotion['start_date'])); ?></font></b> đến ngày
					<b><font color="green"><?php echo date('d/m/Y', strtotime($promotion['end_date'])); ?></font></b>
				
			</div>
		</div>
		<?php } ?>
		
		<div class="panel panel-default" style='padding:0px;'>
			<div class="panel-heading" style='background-color:#fff'>
				<h3 class="panel-title"><b>Bảng giá</b></h3>		
			</div>
			<div class="panel-body pd0">
				<table class="table table-striped nbrd mg0">
					<tr class="info">
						<th class="center w-half">Mệnh giá</th>
						<th class="center w-half">Xu</th>
					</tr>
					<?php foreach($exchangeRates AS $rate){ ?>
					<tr>
						<td class="center"><?php echo number_format($rate['ExchangeRate']['price'], 0, '', '.'); ?> VNĐ</td>
						<td class="center"><?php echo number_format($rate['ExchangeRate']['coin'], 0, '', '.'); ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	mixpanel.track("Enter Recharge Card Page", {"user_id": "<?php echo $user['id']; ?>"});
	$('#recharge-btn').click(function(){
		mixpanel.track("Click Recharge Card Button", {"user_id": "<?php echo $user['id']; ?>"});
	});
	
	$('.cardtype-radio').change(function(){
		if($(this).is(':checked')==true)
		{
			$('#telco').html($(this).attr('data-telco'));
		}
	});
</script>