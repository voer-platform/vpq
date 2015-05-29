<div class='admin-insert-questions'>
	<!-- left nav -->
	<?php echo $this->element('admin-left-nav'); ?>

	<!-- right nav -->
	<div class='col-lg-10'>
		<!-- visible form -->
		<div class='row'>
			<h2>Chi tiết câu hỏi</h2>
			<hr/>
		</div>
		<div class='row'>
			<form action="" method="POST" name="frmExchangesRates" role="form" class="form-horizontal">
				<div class='col-lg-9' style='padding-left:0px;'>
					<div id='left'>
						<div class='col-lg-12'>
							<div class='row' style='margin:0px;margin-top:10px;'>
								<b style='color:brown;font-size:16px;'>Câu hỏi</b>
							</div>
							<div class='row' style='margin:0px;margin-top:10px;'>
								<span style='color:brown;'><?php echo $question[0]['ImportQuestion']['question'];?></span>
							</div>
							<br/>
							<br/>
							<div class='row'>
								<div class='btn-group answer'>
									<label <?php echo(array_key_exists('1',$correct))?"class='btn-answer active'":"class='btn-answer wrong'"; ?>>
										<span>a</span><?php echo $question[0]['ImportQuestion']['answer_a'];?>
									</label>
									<label <?php echo(array_key_exists('2',$correct))?"class='btn-answer active'":"class='btn-answer wrong'"; ?>>
										<span>b</span><?php echo $question[0]['ImportQuestion']['answer_b'];?>
									</label>
									<label <?php echo(array_key_exists('3',$correct))?"class='btn-answer active'":"class='btn-answer wrong'"; ?>>
										<span>c</span><?php echo $question[0]['ImportQuestion']['answer_c'];?>
									</label>
									<label <?php echo(array_key_exists('4',$correct))?"class='btn-answer active'":"class='btn-answer wrong'"; ?>>
										<span>d</span><?php echo $question[0]['ImportQuestion']['answer_d'];?>
									</label>
								</div>
							</div>
						</div>					
					</div>
				</div>
				<div class='col-lg-3'>				
					<div class='row' style='padding-left:20px;'>
						<input type='hidden' name='id' class='form-control' value='<?php echo $question[0]['ImportQuestion']['id'];?>' />
						<input type='submit' class='btn btn-primary col-lg-12' style='height:50px;' name='yes' value='Duyệt'/>
					</div>
					<br/>
					<div class='row' style='padding-left:20px;'>
						<input type='submit' class='btn btn-danger col-lg-12' style='height:50px;' name='no' value='Làm lại'/>
					</div>
				</div>
			</form>
		</div>
	</div>	
</div>
<script>
	/*$(document).ready(function(){
		$('#start_date').datepicker();
		$('#end_date').datepicker();
	});*/
</script>
