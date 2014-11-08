<?php echo $this->Html->css('home.css');?>

<div class='container'>
    <?php if(empty($user)): ?>
        <div id="middle-tagline"><span id="slogan">Tham gia vào hệ thống để truy cập lương lớn câu hỏi trên nhiều lĩnh vực!</span></div>
        <div id="register-methods" class="row">
            <div class="col-md-6">
                <?php echo $this->Html->link($this->Html->image('facebook-login-button.png', array('class' => 'facebook-btn', 'alt' => __('Login with Facebook'))), $fb_login_url, array('escape' => false)); ?>
            </div>
             <div class="col-md-6">
                <?php echo $this->Html->link($this->Html->image('google-login-button.png', array('class' => 'google-btn', 'alt' => 'Login with Google')), '#', array('escape' => false)); ?>
             </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
              <div class="about-pls">
                <h5>PLS là gì?</h5>
                <div class="well">
                  PLS - <strong>Personal Learning System</strong> - Hệ thống hỗ trợ học trực tuyến. Hệ thống sẽ giúp bạn theo dõi quá trình học, từ đó quyết định cần bổ sung kiến thức ở phần nào.
                </div>
                <h5>Ai có thể dùng PLS?</h5>
                <div class="well">
                  Mọi người đều có thể dùng và được chào đón.
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="about-pls">
                <h5>Những loại kiến thức gì?</h5>
                <div class="well">
                  Bất kỳ lĩnh vực nào: gkiến thức ở trường, ngôn ngữ, IT, công nghiệp, kỹ năng mềm, v.v. Nhưng hiện tại, hệ thống chỉ hỗ trợ lĩnh vực Vật lý, THPT.
                </div>
                <h5>Liên hệ</h5>
                <div class="well">
                  Nếu có bất kỳ câu hỏi nào, xin liên hệ chúng tôi tại địa chỉ: <a href="mailto:support@pls.edu.vn">support@pls.edu.vn</a>
                </div>
              </div>
            </div>
          </div>
        </div>

    <?php else: ?>
        <div class="jumbotron">
            <h1><?php echo __('How is your study?'); ?></h1>
            <p class="lead"><?php  echo __('Keep it up!'); ?></p>
            <?php echo $this->Html->link(__('Take a look'), array('controller' => 'people', 'action' => 'dashboard'), array('class' => "btn btn-lg btn-primary")); ?>
        </div>
    <?php endif; ?>
</div>
