<div class="fw center">
	<h3>Bạn cần đăng nhập trước khi xem nội dung này</h3>
	<hr/>
	<div class="w-450 mga">
		<div class="login-form-container">
			<div id="login-section" style="overflow:hidden;">
				<div class="alert alert-warning">Nếu chưa có tài khoản, bạn hãy đăng nhập bằng Facebook</div>
				<div class="form-group">
					<a href="<?php echo $fb_login_url; ?>" class="btn btn-facebook btn-lg btn-block mix-login">
						<div><span class="f-icon"><b class="fs-22">f</b></span>Đăng nhập bằng tài khoản Facebook</div>
					</a>
					<br/>
					<p class="center">
						<a href="javascript:void(0);" class="show-normal-login">Đăng nhập bằng email hoặc số điện thoại</a>
					</p>
				</div>
				<!--
				<div class="center" style="position: relative;margin: 20px 0;border-bottom: solid 1px #dedede;">
				  <span class="login-or" style="
					position: absolute;
					width: 100%;
					left: 0;
					top: -10px;
					text-align: center;"><span style="background-color: #fff;color: #C0C0C0;">( or )</span></span>
				</div>
				-->
				<div class="normal-login-container" style="display:none;">
					<div class="alert" id="login-mess" style="display:none;"></div>
					<div class="form-group">
						<div class="input-group">
						  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						  <input type="text" class="form-control" name="email" id="login-email" placeholder="Email hoặc số điện thoại">
						</div>
					</div>
					
					<div class="form-group">
						<div class="input-group">
						  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
						  <input type="password" class="form-control" name="password" id="login-password" placeholder="<?php echo __('Password'); ?>">
						</div>
					</div>	
					<div class="form-group">
						<button class="btn btn-primary btn-block" id="login-btn"><?php echo __('Login'); ?></button>
					</div>	
				</div>
				
				
				<hr/>
				
				<div class="right">
					<a href="javascript:void(0);" id="show-forgot-form"><?php echo __('Forgot password?'); ?></a>
				</div>
			</div>	
			<!-- forgot section -->
			<div id="forgot-section" style="height:0;overflow:hidden;">
				<div class="alert alert-danger" id="forgot-mess" style="display:none;"></div>
				<div class="form-group">
					<div class="input-group">
					  <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
					  <input type="text" class="form-control" name="email" id="forgot-email" placeholder="<?php echo __('Email'); ?>">
					</div>
				</div>
				<div class="form-group">
					<button class="btn btn-primary btn-block" id="forgot-btn"><?php echo __('Reset password'); ?></button>
				</div>	
				<hr/>
				<div class="right">
					<a href="javascript:void(0);" id="show-login-form">Quay về đăng nhập</a>
				</div>
			</div>
		</div>	
	</div>	
</div>	