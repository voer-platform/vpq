<h2><span class="glyphicon glyphicon-stats"></span> <?php echo __('Test Stats'); ?></h2>
<hr/>
	<div class="row">
	<div class="col-md-6">
		<table class="table table-bordered table-striped">
			<tr>
				<th></th>
				<th>Hôm nay</th>
				<th>Hôm qua</th>
				<th>7 ngày</th>
				<th>30 ngày</th>
				<th>Tất cả</th>
			</tr>
			<tr>
				<td><b>Số lượt test</b></td>
				<td><?php echo $testToDays[0][0]['total']; ?></td>
				<td><?php echo $testYesterday[0][0]['total']; ?></td>
				<td><?php echo $test7Days[0][0]['total']; ?></td>
				<td><?php echo $test30Days[0][0]['total']; ?></td>
				<td><?php echo $testAllDays[0][0]['total']; ?></td>
			</tr>
			<tr>
				<td><b>Số người test</b></td>
				<td><?php echo $testToDays[0][0]['users']; ?></td>
				<td><?php echo $testYesterday[0][0]['users']; ?></td>
				<td><?php echo $test7Days[0][0]['users']; ?></td>
				<td><?php echo $test30Days[0][0]['users']; ?></td>
				<td><?php echo $testAllDays[0][0]['users']; ?></td>
			</tr>
			<tr>
				<td><b>Số môn test</b></td>
				<td><?php echo $testToDays[0][0]['subjects']; ?></td>
				<td><?php echo $testYesterday[0][0]['subjects']; ?></td>
				<td><?php echo $test7Days[0][0]['subjects']; ?></td>
				<td><?php echo $test30Days[0][0]['subjects']; ?></td>
				<td><?php echo $testAllDays[0][0]['subjects']; ?></td>
			</tr>
			<tr>
				<td><b>Thời gian thực tế</b></td>
				<td><?php echo $testToDays[0][0]['time']; ?></td>
				<td><?php echo $testYesterday[0][0]['time']; ?></td>
				<td><?php echo $test7Days[0][0]['time']; ?></td>
				<td><?php echo $test30Days[0][0]['time']; ?></td>
				<td><?php echo $testAllDays[0][0]['time']; ?></td>
			</tr>
			<tr>
				<td><b>Thời gian cho phép</b></td>
				<td><?php echo $testToDays[0][0]['timelimit']; ?></td>
				<td><?php echo $testYesterday[0][0]['timelimit']; ?></td>
				<td><?php echo $test7Days[0][0]['timelimit']; ?></td>
				<td><?php echo $test30Days[0][0]['timelimit']; ?></td>
				<td><?php echo $testAllDays[0][0]['timelimit']; ?></td>
			</tr>
			<tr>
				<td><b>Thời gian trung bình</b></td>
				<td><?php echo $testToDays[0][0]['average']; ?></td>
				<td><?php echo $testYesterday[0][0]['average']; ?></td>
				<td><?php echo $test7Days[0][0]['average']; ?></td>
				<td><?php echo $test30Days[0][0]['average']; ?></td>
				<td><?php echo $testAllDays[0][0]['average']; ?></td>
			</tr>
			<tr>
				<td><b>Sử dụng thời gian</b></td>
				<td><?php echo $testToDays[0][0]['used']; ?></td>
				<td><?php echo $testYesterday[0][0]['used']; ?></td>
				<td><?php echo $test7Days[0][0]['used']; ?></td>
				<td><?php echo $test30Days[0][0]['used']; ?></td>
				<td><?php echo $testAllDays[0][0]['used']; ?></td>
			</tr>
		</table>
	</div>
	<div class="col-md-6">
		<table class="table table-bordered table-striped">
			<tr>
				<th>Môn học</th>
				<th>Số câu đã kiểm tra</th>
				<th>Tổng số câu</th>
			</tr>
			<?php foreach($countQuestion AS $subj){ ?>
				<tr>
					<td><?=$subj['subjects']['name'];?></td>
					<td><?php echo (isset($usedQuestion[$subj['subjects']['id']]))?$usedQuestion[$subj['subjects']['id']]:0; ?></td>
					<td><?=$subj[0]['total'];?></td>
				</tr>
			<?php } ?>	
		</table>	
	</div>
	
	<table class="table table-bordered table-striped">
		<tr>
			<th></th>
			<th colspan="5" class="success">Hôm nay</th>
			<th colspan="5" class="">Hôm qua</th>
			<th colspan="5" class="success">7 ngày</th>
			<th colspan="5" class="info">30 ngày</th>
			<th colspan="5" class="warning">Tất cả</th>
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
						default: $class=""; break;
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