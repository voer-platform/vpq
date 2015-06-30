<!--<div style='background-image:url(<?php echo Router::fullbaseUrl();?>/app/webroot/img/vienngoai.jpg);background-size:100%;'>-->
<style>
	td{
		height:40px;
	}
	td{
		height:40px;
	}
</style>
<br/>
<div class='row' style='border:4px solid;height:950px'>
<div class='col-sm-10' style='border-left:1px solid;height:950px;margin-left:2px;'>
<div class='row'>
<div class='col-sm-12 col-sm-offset-1'>
	
	<div class='row' style='text-align:right'>
		<span style='line-height:20px;margin-right:35px;'><?php echo 'Ngày '.$datenow[0].' tháng '.$datenow[1].' năm '.$datenow[2].' '?></span>		
	</div>
	<br/>
	<div class='row' style='text-align:center;'>
		<span style='font-size:18px;'>HỆ THỐNG HỌC TRỰC TUYẾN PLS</span>		
	</div>
	<div class='row' style='text-align:center;margin-left:200px;margin-right:200px;'>
		<hr />
	</div>
	<div class='row' style='text-align:center;'>
		<h3 >Báo cáo kết quả học tập</h3>		
	</div>
	<div class='row' style='margin-left:20px;'>
		<h4 style='line-height:20px;'>I. thông tin cá nhân:</h4>		
	</div>
	<div class='row' style='margin-left:30;'>
		<span 4 style='line-height:20px;'>- Học sinh: Nguyễn Quang Trung <?php // echo $user['fullname']; ?></span>		
	</div>
	<div class='row' style='margin-left:30px;'>
		<span style='line-height:20px;'>- Ngày sinh: 17/12/1993 <?php // echo $user['birtdday']; ?></span>		
	</div>
	<div class='row' style='margin-left:20px;'>
		<h4 style='line-height:20px;'>II. thành tích hiện tại:</h4>		
	</div>
	<div class='row' style='text-align:center; margin-left:20px;margin-right:20px;'>
		<table class='table table-striped table-bordered' id='table_pdf'>
			<tr>
				<td style='text-align:center;width:30%;'>Môn</td>
				<td style='text-align:center;'>Điểm TB</td>				
				<td style='text-align:center;'>Xếp hạng</td>
			</tr>
			<tr>
				<td style='padding-left:10px;'>Vật lý</td>
				<td style='text-align:center;'><?php echo ($overv[2]['Score']!=''?$overv[2]['Score']:'-') ?></td>
				<td style='text-align:center;'><?php echo (array_key_exists('2',$rankings)?$rankings[2]:'-') ?></td>
			</tr>
			<tr>
				<td style='padding-left:10px;'>Hóa</td>
				<td style='text-align:center;'><?php echo ($overv[4]['Score']!=''?$overv[4]['Score']:'-') ?></td>
				<td style='text-align:center;'><?php echo (array_key_exists('4',$rankings)?$rankings[2]:'-') ?></td>
			</tr>
			<tr>
				<td style='padding-left:10px;'>Sinh</td>
				<td style='text-align:center;'><?php echo ($overv[8]['Score']!=''?$overv[8]['Score']:'-') ?></td>
				<td style='text-align:center;'><?php echo (array_key_exists('8',$rankings)?$rankings[2]:'-') ?></td>
			</tr>
		</table>
	</div>
	<div class='row' style='margin-left:20px;'>
		<h4 style='line-height:20px;'>III. Bảng điểm trong tháng:</h4>		
	</div>
	<div class='row' style='text-align:center; margin-left:20px;margin-right:20px;'>
		<table class='table table-striped table-bordered' id='table_pdf'>
			<tr>
				<td style='text-align:center;width:30%;'>Môn</td>
				<td style='text-align:center;'>Số lần kiểm tra</td>
				<td style='text-align:center;'>Điểm TB</td>				
				<td style='text-align:center;'>Tổng thời gian</td>
			</tr>
			<tr>
					<td style='padding-left:10px;'>Vật lý</td>
					<td style='text-align:center;'><?php echo $now[2]['0']['count'] ?></td>
					<td style='text-align:center;'><?php echo $now[2]['0']['score'] ?></td>
					<td style='text-align:center;'><?php echo $now[2]['0']['total_time'].' Phút' ?> </td>
				</tr>
				<tr>
					<td style='padding-left:10px;'>Hóa học</td>
					<td style='text-align:center;'><?php echo $now[4]['0']['count'] ?></td>
					<td style='text-align:center;'><?php echo $now[4]['0']['score'] ?></td>
					<td style='text-align:center;'><?php echo $now[4]['0']['total_time'].' Phút' ?></td>
				</tr>
				<tr>
					<td style='padding-left:10px;'>Sinh học</td>
					<td style='text-align:center;'><?php echo $now[8]['0']['count'] ?></td>
					<td style='text-align:center;'><?php echo $now[8]['0']['score'] ?></td>
					<td style='text-align:center;'><?php echo $now[8]['0']['total_time'].' Phút' ?></td>
				</tr>
		</table>
	</div>
	<div class='row' style='margin-left:20px;'>
		<h4 style='line-height:20px;'>IV. So sánh kết quả tháng trước:</h4>		
	</div>
	<div class='row' style='text-align:center; margin-left:20px;margin-right:20px;'>
		<table class='table table-striped table-bordered' id='table_pdf'>
			<tr>
				<td style='text-align:center;width:30%'>Môn</td>
				<td style='text-align:center;'>Số lần kiểm tra</td>
				<td style='text-align:center;'>Điểm TB</td>				
				<td style='text-align:center;'>Tổng thời gian</td>
			</tr>
			<tr>
				<td style='padding-left:10px;'>Vật lý</td>
				<td style='text-align:center;'><?php echo $last[2]['count'] ?></td>
				<td style='text-align:center;'><?php echo $last[2]['score'] ?></td>
				<td style='text-align:center;'><?php echo $last[2]['total_time'].' Phút' ?></td>
			</tr>
			<tr>
				<td style='padding-left:10px;'>Hóa học</td>
				<td style='text-align:center;'><?php echo $last[4]['count'] ?></td>
				<td style='text-align:center;'><?php echo $last[4]['score'] ?></td>
				<td style='text-align:center;'><?php echo $last[4]['total_time'].' Phút' ?></td>
			</tr>
			<tr>
				<td style='padding-left:10px;'>Sinh học</td>
				<td style='text-align:center;'><?php echo $last[8]['count'] ?></td>
				<td style='text-align:center;'><?php echo $last[8]['score'] ?></td>
				<td style='text-align:center;'><?php echo $last[8]['total_time'].' Phút' ?></td>
			</tr>
		</table>
	</div>
	
</div>
</div>
</div>
</div>