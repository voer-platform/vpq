<?php echo $this->Html->css('insert-questions-admin.css'); ?>

<div class='admin-insert-questions'>
	<!-- left nav -->
	<?php echo $this->element('admin-left-nav'); ?>

	<!-- right nav -->
	<div class='col-lg-10'>
		<!-- visible form -->
		<div class='row'>
			<h2>Quản lý khuyến mại</h2>
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
				<div class='col-sm-7 col-sm-offset-1'>
					<table class='table table-striped table-bordered'>
						<tr>
							<th style='text-align:center;'>STT</th>
							<th style='text-align:center;'>Khuyến mại</th>
							<th style='text-align:center;'>Ngày bắt đầu</th>
							<th style='text-align:center;'>Ngày kết thúc</th>
							<th></th>
						</tr>
						<?php $i=1; ?>
						<?php foreach($data as $dt): ?>
							<tr>
								<td style='text-align:center;'><?php echo $i; ?></td>
								<td style='text-align:center;'><?php echo $dt['promotional']['percent']?></td>
								<td style='text-align:center;'><?php echo $dt['promotional']['start_date']?></td>
								<td style='text-align:center;'><?php echo $dt['promotional']['end_date']?></td>
								<td style='text-align:center;'>
									<a class='btn btn-primary' title='Sửa' href="<?php echo $this->Html->url(array('controller'=> 	'admin','action'=> 'promotional')); ?>?update=<?php echo $dt['promotional']['id'] ?>"><span class='glyphicon glyphicon-pencil'></span></a>									
									<a onclick="return confirm ('Bạn có muốn xóa khuyến mại này không?')" class='btn btn-danger' title='Xóa' href="<?php echo $this->Html->url(array('controller'=>'admin','action'=> 'promotional')); ?>?delete=<?php echo $dt['promotional']['id'] ?>"><span class='glyphicon glyphicon-trash'></span></a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>					
					</table>
					<div class="paging">
					<?php
						echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
						echo $this->Paginator->numbers(array('separator' => ''));
						echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
					?>
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
