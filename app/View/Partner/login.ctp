<style>
	#box{
		border:2px solid #ccc;
		border-radius:5px;
	}
</style>
<!--<div id="banner">
	<div class="banner-overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<br/><br/><br/><br/><br/><br/><br/><br/>
				<h1 style="font-size:42px;font-weight:bold;"><strong>PLS</strong> - Học theo cách của bạn</h1>
				<p style="font-size: 20px;">Tham gia vào hệ thống để trải nghiệm nguồn kiến thức vô tận trên nhiều lĩnh vực</p>
				<a href="javascript:void(0);" class="login-open btn btn-ghost btn-lg" data-toggle="modal" data-target="#login-modal" data-section="home-banner">
					Đăng nhập <span class="glyphicon glyphicon-chevron-right"></span>
				</a>
				<br/><br/><br/><br/>
				
			</div>
		</div>	
	</div>	
</div>-->
<div class='container'>
	<form action="" method="POST" name="frmlogin" role="form"  enctype="multipart/form-data" class="form-horizontal">
	<div class='row'>
		<div class='col-sm-4 col-sm-offset-4' id='box' style='margin-top:100px;'>
			<div class='row'>
				<div class='col-sm-12'>
					<h4>Đăng nhập<h4/>
				</div>				
			</div>
			<hr/>
			<div class='row'>
				<div class='col-sm-12'>
					<div class="input-group">
					  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
					  <input type="text" class="form-control" name="user" id="user" placeholder="Username">
					</div>
				</div>
			</div>
			<br/>
			<div class='row'>
				<div class='col-sm-12'>
					<div class="input-group">
					  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
					  <input type="password" class="form-control" name="pass" id="pass" placeholder="Password">
					</div>
				</div>
			</div>
			<br/>
			<div class='row'>
				<div class='col-sm-12'>
					<input type='submit' class="btn btn-primary btn-block" name='login' id='login' value='Đăng nhập' />
				</div>
			</div>
			<hr/>
			<div class='row'>
				<div class='col-sm-12'>
					<a style='float:right;' id='link'>Tạo tài khoản</a>
				</div>
			</div>
			<br/>
		</div>
	</div>
	</form>
</div>
<div id="modalcreat" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width:400px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tạo tài khoản</h4>
            </div>
            <div class="modal-body"><div class="alert" id="dialog-alert" style="display:none;"></div>
				<form method="POST">
					<div class="form-group">
						<label class="control-label">Email</label>
						<input type="password" id="email" name="emailcreat" placeholder="Email" class="form-control">
					</div>
					<div class="form-group">
						<label class="control-label">Tên đăng nhập</label>
						<input type="password" id="usercreat" name="usercreat" placeholder="Tên đăng nhập" class="form-control">
					</div>
					<div class="form-group">
						<label class="control-label">Mật khẩu</label>
						<input type="password" id="passcreat" placeholder="Mật khẩu" class="form-control">
					</div>
					<div class="form-group">
						<label class="control-label">Xác nhận mật khẩu</label>
						<input type="password" id="confirmpass" placeholder="Xác nhận mật khẩu" class="form-control">
					</div>	
				</form>
			</div>
            <div class="modal-footer">
				<input type='submit' class='btn btn-primary' name='creat' id='creat' value='Đăng ký'/>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script>
	$(document).on('click','#link',function(){
		$('#modalcreat').modal({
				backdrop: true
			});	
	});
	$(document).ready(function(){
		mixpanel.track(
			"Enter Hompage"
		);
		
		var loginSection = '';
		$('.login-open').click(function(){
			loginSection = $(this).attr('data-section');
			console.log(loginSection);
		});
		mixpanel.track_links(".mix-login", "Login", function(e){
			return {"login_section": loginSection, "login_method": "facebook"};
		});	
		
		
		$('#login-btn').click(function(){
			email = $('#login-email').val();
			password = $('#login-password').val();
			if(email && password)
			{
				$.ajax({
					type: 'POST',
					url: '<?php echo $this->Html->url(array('controller'=>'people', 'action'=>'login')); ?>',
					data: {'email': email, 'password': password},
					success: function(response){
						response = JSON.parse(response);
						mess = '';
						if(parseInt(response.code)==1)
						{
							$('#login-mess').removeClass('alert-danger').addClass('alert-success');
							mixpanel.track("Login", {"login_section": loginSection, "login_method": "normal"});
							window.location.href = "/";
						}
						else
						{
							$('#login-mess').removeClass('alert-success').addClass('alert-danger');
						}
						$('#login-mess').html(response.mess).show();
					}
				});
			}
			else
			{
				$('#login-mess').removeClass('alert-success').addClass('alert-danger');
				$('#login-mess').html('<?php echo __('Please complete all field'); ?>').show();
			}
		});
		
		$('#forgot-btn').click(function(){
			email = $('#forgot-email').val();
			if(email)
			{
				$.ajax({
					type: 'POST',
					url: '<?php echo $this->Html->url(array('controller'=>'api', 'action'=>'forgotPassword')); ?>',
					data: {'email': email},
					success: function(response){
						response = JSON.parse(response);
						mess = '';
						if(parseInt(response.code)==1)
						{
							$('#forgot-mess').removeClass('alert-danger').addClass('alert-success');
						}
						else
						{
							$('#forgot-mess').removeClass('alert-success').addClass('alert-danger');
						}
						$('#forgot-mess').html(response.mess).show();
					}
				});
			}
			else
			{
				$('#forgot-mess').removeClass('alert-success').addClass('alert-danger');
				$('#forgot-mess').html('<?php echo __('Please complete all field'); ?>').show();
			}
		});
		
		$('#show-forgot-form, #show-login-form').click(function(){
			if($(this).attr('id')=='show-forgot-form')
			{
				el = $('#forgot-section').clone().appendTo('body');
				autoHeight = el.css('height', 'auto').height();
				el.remove();
				$('#login-section').animate({ height: 0, 'min-height': 0 }, 300);
				$('#forgot-section').animate({'min-height': autoHeight}, 300, function(){
					$(this).css('height', 'auto');
				});
				$('#login-modal-title').text('<?php echo __('Forgot password'); ?>');
			}
			else
			{
				el = $('#login-section').clone().appendTo('body');
				autoHeight = el.css('height', 'auto').height();
				el.remove();
				$('#forgot-section').animate({ height: 0, 'min-height': 0 }, 300);
				$('#login-section').animate({'min-height': autoHeight}, 300, function(){
					$(this).css('height', 'auto');
				});
				$('#login-modal-title').text('<?php echo __('Login'); ?>');
			}
		});
	});
</script>
