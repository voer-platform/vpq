<div class="row">
	<div class="col-md-12">
		<div class="personal-page-header clearfix">
			<div class="pull-left clearfix">
				<div class="avatar pull-left">
					<img src="<?php echo $person['Person']['image']; ?>" width="200px" height="200px">
				</div>
				<div class="user-info pull-right">
					<h3><?php echo h($person['Person']['fullname']); ?></h3>
					<p><span class="glyphicon glyphicon-gift"></span>&nbsp; <?php echo __('Birthday:'); ?> <?php echo h($person['Person']['birthday']); ?></p>
					<p><span class="glyphicon glyphicon glyphicon-heart"></span>&nbsp; <?php echo __('Gender:'); ?> <?php echo ($person['Person']['gender']==1)?'Nam':'Nữ'; ?></p>
					<p><span class="glyphicon glyphicon-education"></span>&nbsp; <?php echo __('Student:'); ?> <?php echo h($person['Person']['grade']); ?><?php if($person['Person']['school']){ echo ', '.h($person['Person']['school']); } ?></p>
					<p><span class="glyphicon glyphicon-home"></span>&nbsp; <?php echo __('Address:'); ?> <?php echo h($person['Province']['name']); ?></p>
					<?php if($user['id']== $person['Person']['id']){ ?>
						<button class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-cog"></span> Chỉnh sửa thông tin cá nhân</button></a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if($user['id']== $person['Person']['id']){ ?>
<!-- Modal -->
<div class="modal" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog w-550">
		<div class="modal-content">
			<form method="POST" class="form-horizontal" id="update-profile-form" action="<?php echo $this->Html->url(array('controller'=>'people', 'action'=>'update')); ?>">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-pencil"></span> Chỉnh sửa thông tin cá nhân</h4>
			</div>
			<div class="modal-body">

					<div class="form-group">
						<label class="col-sm-3 control-label">Họ tên</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="fullname" value="<?php echo h($person['Person']['fullname']); ?>" />
						</div>	
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Ngày sinh</label>
						<div class="col-sm-9">
							<?php $birthday = explode('/', $person['Person']['birthday']); ?>
							<?=$this->Form->day('birthday', array('value'=>$birthday[0], 'class'=>'form-control ib w-70'));?>
							<?=$this->Form->month('birthday', array('value'=>$birthday[1], 'monthNames'=>false, 'class'=>'form-control ib w-70'));?>
							<?=$this->Form->year('birthday', date('Y')-100, date('Y')-12, array('value'=>$birthday[2], 'empty'=>false, 'class'=>'form-control ib w-100'));?>
						</div>	
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Giới tính</label>
						<div class="col-sm-9">
							<select name="gender" class="form-control">
								<option value="1" <?php if($person['Person']['gender']==1) echo 'selected'; ?>>Nam</option>
								<option value="0" <?php if($person['Person']['gender']==0) echo 'selected'; ?>>Nữ</option>
							</select>
						</div>	
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Email</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="update-email" placeholder="Địa chỉ email" name="email" value="<?php echo h($person['Person']['email']); ?>" />
							<p class="text-error" id="email-error" style="display:none;"></p>
						</div>	
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Điện thoại</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="update-phone" placeholder="Số điện thoại" name="phone" value="<?php echo h($person['Person']['phone']); ?>" />
							<p class="text-error" id="phone-error" style="display:none;"></p>
						</div>	
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Đang là</label>
						<div class="col-sm-9">
							<select name="grade" class="form-control">
								<?php foreach($grades AS $grade){ ?>
									<option value="<?php echo $grade; ?>" <?php if($person['Person']['grade']==$grade) echo 'selected'; ?>>Học sinh lớp <?php echo $grade; ?></option>
								<?php } ?>
							</select>
						</div>	
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Tại trường</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="school" value="<?php echo h($person['Person']['school']); ?>" placeholder="Tên trường học của bạn" />
						</div>	
					</div>
					<div class="form-group mgb-0">
						<label class="col-sm-3 control-label">Địa chỉ</label>
						<div class="col-sm-9">
							<select name="address" class="form-control sl2">
								<?php foreach($provinces AS $province_id=>$province){ ?>
									<option value="<?php echo $province_id; ?>" <?php if($province_id==$person['Province']['id']) echo 'selected'; ?>><?php echo $province; ?></option>
								<?php } ?>
							</select>
						</div>	
					</div>
					
			</div>
			<div class="modal-footer">
				<button type="submit" id="update-profile" name="update_profile" value="update_profile" class="btn btn-primary"><?php echo __('Update'); ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
			</div>
			</form>
		</div>
		
	</div>
</div>
<?php } ?>
<script>
	$('.sl2').select2();
	
	$('#update-email').blur(function(){
		var email = $('#update-email').val();
		checkEmail(email);
	});
	
	$('#update-phone').blur(function(){
		var phone = $('#update-phone').val();	
		checkPhone(phone);
	});
	
	$('#update-profile').click(function(){
		if($('.text-error:visible').length>0)
		{
			return false;
		}
	});
</script>