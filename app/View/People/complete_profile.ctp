<br/>
<div class="row">
	<div class="col-md-12">
		<div class="alert alert-success">
			Chào mừng <strong><?php echo $user['last_name'].' '.$user['first_name']; ?></strong>!
			<br/>
			Đây là lần đâu tiên bạn đăng nhập vào hệ thống, vui lòng hoàn thành thông tin của mình trước khi bắt đầu
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
		  <div class="panel-body">
			<div class="row">
				<div class="col-md-8">
					<form class="form-horizontal" method="POST">
						<div class="form-group">
							<label class="col-sm-3 control-label">Họ tên</label>
							<div class="col-sm-9">
								<input type="text" name="fullname" class="form-control" value="<?php echo $user['last_name'].' '.$user['first_name']; ?>" />
							</div>	
						</div>	
						<div class="form-group">
							<label class="col-sm-3 control-label">Ngày sinh</label>
							<div class="col-sm-9">
								<input type="text" name="birthday" class="form-control datepicker" value="<?php echo $this->Date->toVnDate($user['birthday']); ?>" />
							</div>	
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Giới tính</label>
							<div class="col-sm-9">
								<select name="gender" class="form-control">
									<option value="1" <?php if($user['gender']==1) echo 'selected'; ?>>Nam</option>
									<option value="0" <?php if($user['gender']==0) echo 'selected'; ?>>Nữ</option>
								</select>
							</div>	
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Đang là</label>
							<div class="col-sm-9">	
								<select name="grade" class="form-control">
									<?php foreach($grades AS $grade){ ?>
										<option value="<?php echo $grade; ?>">Học sinh lớp <?php echo $grade; ?></option>
									<?php } ?>
								</select>
							</div>	
						</div>	
						<div class="form-group">
							<label class="col-sm-3 control-label">Tại trường</label>
							<div class="col-sm-9">	
								<input type="text" name="school" class="form-control" placeholder="Tên trường học của bạn">
							</div>	
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Địa chỉ</label>
							<div class="col-sm-9">	
								<input type="text" name="address" class="form-control" placeholder="Nơi bạn đang sống">
							</div>	
						</div>
						<div class="form-group right">
							<div class="col-sm-12">	
								<button type="submit" class="btn btn-primary" id="complete-profile" name="complete_profile"><span class="glyphicon glyphicon-ok"></span> Hoàn thành</button>
								<a id="skip-profile" href="<?php echo $this->Html->url(array('controller'=>'people', 'action'=>'dashboard')); ?>"><button type="button" class="btn btn-default">Bỏ qua</button></a>
							</div>	
						</div>	
					</form>
				</div>
				<div class="col-md-4">
					<a style="width:190px;" href="#" class="thumbnail">
					  <img src="<?php echo $user['image']; ?>">
					</a>
				</div>
			</div>
		  </div>
		</div>
	</div>
</div>	
<script>
$('.datepicker').datepicker({format: "dd/mm/yyyy"}).on('changeDate', function(ev) {
		$(this).datepicker('hide');
	});
</script>