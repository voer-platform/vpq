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
					<form id="complete-profile-form" class="form-horizontal" method="POST">
						<div class="form-group">
							<label class="col-sm-3 control-label">Họ tên</label>
							<div class="col-sm-9">
								<input type="text" name="fullname" class="form-control" value="<?php echo $user['last_name'].' '.$user['first_name']; ?>" />
							</div>	
						</div>	
						<div class="form-group">
							<label class="col-sm-3 control-label">Ngày sinh</label>
							<div class="col-sm-9">
								<input type="text" name="birthday" class="form-control hasDatepick" value="<?php echo $user['birthday']; ?>" />
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
								<select name="address" class="form-control sl2">
									<?php foreach($provinces AS $province_id=>$province){ ?>
										<option value="<?php echo $province_id; ?>" <?php if($province_id=='hanoi') echo 'selected'; ?>><?php echo $province; ?></option>
									<?php } ?>
								</select>
							</div>	
						</div>
						<hr/>
						<div class="form-group">
							<label class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<input type="email" required name="email" id="email" class="form-control" placeholder="Email" value="<?php echo $user['email']; ?>" />
								<p class="text-error" id="email-error" style="display:none;"></p>
							</div>	
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Mật khẩu</label>
							<div class="col-sm-9">
								<input type="password" required placeholder="Mật khẩu" id="password" name="password" class="form-control" />
							</div>	
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Xác nhận mật khẩu</label>
							<div class="col-sm-9">
								<input type="password" required placeholder="Gõ lại mật khẩu phía trên" id="repassword" name="password" class="form-control" />
								<p class="text-error" id="password-error" style="display:none;"></p>
							</div>	
						</div>
						<div class="form-group right">
							<div class="col-sm-12">	
								<button type="button" class="btn btn-primary" id="complete-profile" name="complete_profile"><span class="glyphicon glyphicon-ok"></span> Hoàn thành</button>
								<!--<a id="skip-profile" href="<?php echo $this->Html->url(array('controller'=>'people', 'action'=>'dashboard')); ?>"><button type="button" class="btn btn-default">Bỏ qua</button></a>-->
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

<div id="modalmessages" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style='margin-top:150px;'>
			<div class="modal-header" style='text-align:center'>
                <h3 class="modal-title" id="myModalLabel" style='color:#428bca;'>Chào mừng bạn đến với PLS</h3>
            </div>
            <div class="modal-body" style='text-align:center'>
                <h3></h3>
				<p style='font-size:12pt;'>
					<b style='color:#428bca;'>PLS</b> tặng bạn <b style='color:red;'>150 Xu</b> cho lần đăng nhập đầu tiên.
				</p>
				<p style='font-size:12pt;'>
					<b style='color:red;'>Xu</b> dùng để duy trì tài khoản, mỗi ngày tài khoản của bạn sẽ bị giảm <b style='color:red;'>5 Xu</b>.
				</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo __('Close'); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
	$('.hasDatepick').datepicker({format: "dd/mm/yyyy"}).on('changeDate', function(ev) {
		$(this).datepicker('hide');
	});
	$('.sl2').select2();
	$(document).ready(function(){
		$('#modalmessages').modal({
					backdrop: true
				});
	});
	$('#complete-profile').click(function(){
		if(!validateEmail($('#email').val()))
		{
			$('#email-error').html('Email không hợp lệ').show();
			return false;
		}
		else
		{
			$('#email-error').hide();
		}
		
		if($('#password').val()=='')
		{
			$('#password-error').html('Mật khẩu không được bỏ trống').show();
		}
		else if($('#password').val() == $('#repassword').val())
		{
			$('#password-error').hide();
			$.ajax({
				type: 'POST',
				url: '<?php echo $this->Html->url(array('controller'=>'people', 'action'=>'emailCheck')); ?>',
				data: {'email': $('#email').val()},
				success: function(response){
					response = JSON.parse(response);
					if(response.code==0)
					{
						$('#email-error').html('Email này đã được sử dụng').show();
					}
					else
					{
						$('#email-error').hide();
						$('#complete-profile-form').submit();
					}
				}
			});
		}
		else
		{
			$('#password-error').html('Hai mật khẩu không khớp').show();
		}
	});
</script>