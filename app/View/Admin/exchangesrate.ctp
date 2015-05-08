<?php echo $this->Html->css('insert-questions-admin.css'); ?>

<div class='admin-insert-questions'>
	<!-- left nav -->
	<?php echo $this->element('admin-left-nav'); ?>

	<!-- right nav -->
	<div class='col-lg-10'>
		<!-- visible form -->
		<div class='row'>
			<h2>Exchanges Rates</h2>
			<hr/>
		</div>
		<div class='row'>
			<form action="" method="POST" name="frmExchangesRates" role="form" class="form-horizontal">
				<div class='col-sm-4'>
					<div class='row'>
						<label>Khuyến mại (% số xu nhận được)</label>
						<input type='text' class='form-control' value='' name='promotional'/>
					</div>
					<br/>
					<div class='row'>
						<label>Ngày bắt đầu</label>
						<input type='text' class='form-control' value='' id='start_date' name='start_date'/>
					</div>
					<br/>
					<div class='row'>
						<label>Ngày kết thúc</label>
						<input type='text' class='form-control' value='' id='end_date' name='end_date'/>
					</div>
					<br/>
					<div class='row'>
						<input type='submit' class='btn btn-primary' value='Thực hiện' />
					</div>
				</div>
				<div class='col-sm-4 col-sm-offset-1 box'>
					<div class='row'>	
						<div class='col-sm-10 col-sm-offset-1' style='text-align:center;'>
							<span style='color:green; font-size:50pt;'><?php echo $Rate['promotional']; ?>%</span>
							<hr style='margin:0px;' />
						</div>
					</div>
					<div class='row' style='padding-top:10px;'>
						<div class='col-sm-10 col-sm-offset-1' style='text-align:center;'>
							<span style='font-size:13pt;text-align:center;'>Ngày bắt đầu: <?php echo $Rate['start_date']; ?></span>
							<hr style='margin:0px;margin-top:10px;'/>
						</div>
					</div>
					<div class='row' style='padding:10px;'>
						<div class='col-sm-10 col-sm-offset-1'  style='text-align:center;'>
							<span style='font-size:13pt;'>Ngày kết thúc: <?php echo $Rate['end_date']; ?></span>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>	
</div>
<script>
	$(document).ready(function(){
		$('#start_date').datepicker();
		$('#end_date').datepicker();
	});
</script>
