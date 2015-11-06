<script type="text/javascript"
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>
<?php echo $this->HTML->css('dataTables.bootstrap.min.css'); ?>
<?php echo $this->Html->script('jquery.dataTables.min.js');?>
<?php echo $this->Html->script('dataTables.bootstrap.min.js');?>
<?php echo $this->Html->css('insert-questions-admin.css'); ?>

<div class='admin-insert-questions'>

	<!-- right nav -->
	<div class='col-lg-12'>
		<!-- visible form -->
		<div class='row'>
			<h2>Thống kê phân loại câu hỏi</h2>
			<hr/>
		</div>
		<div class='row'>
			<form action="" method="POST" name="frmExchangesRates" role="form" class="form-horizontal">
				<table id="tbl_classify" class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
					<thead>
						<tr>
							<td style="text-align:center;width:70px;">STT</td>
							<td style="text-align:center;width:150px;">ID</td>
							<td style="text-align:center">CONTENT</td>
							<td style="text-align:center;width:100px;">TOTAL</td>
							<td style="text-align:center;width:100px;">PERCENT</td>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php foreach($data as $value){ ?>
							<tr>
								<td style="text-align:center;"><?php echo $i++; ?></td>
								<td><?php echo $value['cq']['iquestion_id'] ?></td>
								<td><?php echo $value['iq']['question'] ?></td>
								<td style="text-align:center;"><?php echo $value['0']['total'] ?></td>
								<td style="text-align:center;"><?php echo $value['iq']['correct_percent'] ?>%</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>				
			</form>
		</div>
	</div>	
</div>
<script>
	$(document).ready(function(){
		$('#tbl_classify').DataTable(
			{
				"lengthMenu": [[10, 25, 50], [10, 25, 50]]
			}
		);	
	});
</script>
