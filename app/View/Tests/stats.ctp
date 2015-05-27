<h2><span class="glyphicon glyphicon-stats"></span> <?php echo __('Test Stats'); ?></h2>
<hr/>
	<table class="table table-bordered table-striped" style="width:50%;">
		<tr>
			<th></th>
			<th>7 ngày</th>
			<th>30 ngày</th>
			<th>Tất cả</th>
		</tr>
		<tr>
			<td><b>Số lượt test</b></td>
			<td><?php echo $test7Days[0][0]['total']; ?></td>
			<td><?php echo $test30Days[0][0]['total']; ?></td>
			<td><?php echo $testAllDays[0][0]['total']; ?></td>
		</tr>
		<tr>
			<td><b>Số người test</b></td>
			<td><?php echo $test7Days[0][0]['users']; ?></td>
			<td><?php echo $test30Days[0][0]['users']; ?></td>
			<td><?php echo $testAllDays[0][0]['users']; ?></td>
		</tr>
		<tr>
			<td><b>Số môn test</b></td>
			<td><?php echo $test7Days[0][0]['subjects']; ?></td>
			<td><?php echo $test30Days[0][0]['subjects']; ?></td>
			<td><?php echo $testAllDays[0][0]['subjects']; ?></td>
		</tr>
		<tr>
			<td><b>Thời gian thực tế</b></td>
			<td><?php echo $test7Days[0][0]['time']; ?></td>
			<td><?php echo $test30Days[0][0]['time']; ?></td>
			<td><?php echo $testAllDays[0][0]['time']; ?></td>
		</tr>
		<tr>
			<td><b>Thời gian cho phép</b></td>
			<td><?php echo $test7Days[0][0]['timelimit']; ?></td>
			<td><?php echo $test30Days[0][0]['timelimit']; ?></td>
			<td><?php echo $testAllDays[0][0]['timelimit']; ?></td>
		</tr>
		<tr>
			<td><b>Thời gian trung bình</b></td>
			<td><?php echo $test7Days[0][0]['average']; ?></td>
			<td><?php echo $test30Days[0][0]['average']; ?></td>
			<td><?php echo $testAllDays[0][0]['average']; ?></td>
		</tr>
		<tr>
			<td><b>Sử dụng thời gian</b></td>
			<td><?php echo $test7Days[0][0]['used']; ?></td>
			<td><?php echo $test30Days[0][0]['used']; ?></td>
			<td><?php echo $testAllDays[0][0]['used']; ?></td>
		</tr>
	</table>
	
	<table class="table table-bordered table-striped">
		<tr>
			<th></th>
			<th colspan="<?=count($testDetail)+2;?>" class="success">7 ngày</th>
			<th colspan="<?=count($testDetail)+2;?>" class="info">30 ngày</th>
			<th colspan="<?=count($testDetail)+2;?>" class="warning">Tất cả</th>
		</tr>
		<tr>
			<th></th>
			<?php 
				foreach($testDetail AS $k=>$range){ 
					$class = 'success';
					switch($k)
					{
						case 'test7Days': $class = 'success'; break;
						case 'test30Days': $class = 'info'; break;
						case 'testAllDays': $class = 'warning'; break;
					}
					foreach($range AS $k=>$limit){
					
			?>
					<th class="<?=$class;?>"><?=$k;?>_phút</th>
			<?php
					}
				
				} 
			 ?>
		</tr>
		<?php foreach($infos AS $info){ ?>
			<tr>
				<td><?=$info;?></td>
				<?php foreach($testDetail AS $k=>$range){ 
				
						foreach($range AS $k=>$limit){
				?>
					<td><?=$limit[$info];?></td>
				<?php
					}}
				?>
			</tr>
		<?php } ?>
	</table>