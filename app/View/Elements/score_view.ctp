<?php echo $this->Html->css('score_view.css'); ?>
<?php $this->start('meta'); ?>
<link href="<?php echo Router::url( $this->here, true ); ?>" rel="canonical">
<meta property="og:url" content="<?php echo Router::url( $this->here, true ); ?>" />
<meta property="og:title" content="<?php printf(__('%s has just scored %d on %s.'), $userInfo['fullname'], round($correct/$numberOfQuestions, 1)*10, $subject['Subject']['name']); ?>" />
<meta property="og:description" content="<?php printf(__('Test on PLS. Subject: %s. Number of question: %d. Correct questions: %d. Wrong questions: %d.'), $subject['Subject']['name'], $numberOfQuestions, $correct, $numberOfQuestions - $correct); ?>" />
<meta property="og:image" content="<?php echo Router::url('/', true).'/img/review/'.(round($correct/$numberOfQuestions, 1)*10).'.png'; ?>" />
<?php $this->end(); ?>

<!-- do not display if not logged in -->
<?php if(isset($user)): ?>
<div id='doTest'>
    <div id="left">
        <ul id="questions">
        <?php $wrong_list = array(); ?>
		<?php $true_list = array(); ?>
        <?php foreach($scoreData as $index => $data): ?>
            <li id='dotestQuestions' rel="<?php echo $index+1;?>">
                <?php $correct_answer = -1; ?>
                <fieldset>
                    <div class="question">
                        <div class="title"><?php echo "<b>", 'Câu ', $index+1, ":</b>  "; ?></div>
                        <div class="question-content"><?php echo html_entity_decode($questionsData[$index]['Question']['content']); ?></div>
                    </div>
                    <div class="btn-group answer" data-toggle="buttons">
                        <?php foreach($questionsData[$index]['Answer'] as $answerId => $answer): ?>
                            <!-- correct answer -->
                            <?php if( $answer['correctness'] == 1): ?>
                                <?php $correct_answer = $answerId; ?>
                                <!-- user choose correct answer -->
                                <?php if($data['ScoresQuestion']['answer'] == $answerId && isset($data['ScoresQuestion']['answer'])): ?>
                                    <label class="btn-answer active">
									<?php $true_list[] = $index;?>
									<button style='float:right;display:none;' data-id='<?php echo $data['ScoresQuestion']['question_id'] ?>' type='button' class='btn btn-danger report glyphicon glyphicon-bullhorn' data-container="body" data-toggle="popover" data-placement="right" data-content="Đây là nút báo đáp án sai, bạn chỉ click khi chắc chắn là đáp án sai."></button>
                                <?php else: ?>
                                    <label class="btn-answer" correct="true">
									<button style='float:right;display:none;' data-id='<?php echo $data['ScoresQuestion']['question_id'] ?>' type='button' class='btn btn-danger report glyphicon glyphicon-bullhorn' data-container="body" data-toggle="popover" data-placement="right" data-content="Đây là nút báo đáp án sai, bạn chỉ click khi chắc chắn là đáp án sai."></button>
                                <?php endif; ?>
                            <!-- not correct answer -->
                            <!-- user choose wrong -->
                            <?php elseif( $data['ScoresQuestion']['answer'] == $answerId && isset($data['ScoresQuestion']['answer'])): ?>
                                <label class="btn-answer wrong">
                                <?php $wrong_list[] = $index;?>
                            <?php else: ?>
                                <label class="btn-answer">
                            <?php endif; ?>          
                                <span><?php echo chr(97 + $answerId); ?></span><?php echo $answer['content']; ?>
                            </label>
                        <?php endforeach;?>
                    </div>
                </fieldset>
                <?php
                    $a = $data['ScoresQuestion']['answer'];
                    $class = "";
                    if (!isset($a)){
                        $class = "incorrect";                        
                        $r = "Bạn không chọn đáp án.";
                    }else{
                        $r = "Bạn đã chọn đáp án " . chr($a + 97) . ". ";
                        $true = $questionsData[$index]['Answer'][$a]['correctness'];
                        if ($true == 1){
                            $r .= "Đây là đáp án đúng.";
                        }else{
                            $r .= "Đây là đáp án sai.";
                            $class = "incorrect";
                        }
                    }
                ?>
                <div class="choose-answer <?php echo $class; ?>">
                    <div class="correct-answer"><?php echo "Đáp án đúng là ". chr($correct_answer + 97) . ". ".'</br>'; ?></div>
                    <?php echo $r; ?>
                </div>
                <!-- <div id="ask-for-help">
                    <a href="<?php # echo '/ask4Help/index/'.$questionsData[$index]['Question']['id']; ?>"><?php echo __('Ask for help'); ?></a>
                </div> -->
                <div class="question solution">
                    <div class="title"><?php echo __("Solution:") ?></div>
                    <div class="solution question-content">
                        <?php echo $questionsData[$index]['Question']['solution']; ?>
                    </div>
                </div>
                <div class="nav">
                    <button class="btn pull-left prev" type="button">Câu hỏi trước</button>
                    <button class="btn pull-right next" type="button">Câu hỏi sau</button>
                </div>
            </li>           
        <?php endforeach;?>
        </ul>
    </div>
    <div id="right">
        <div class="test-info">
            <div class="title">Thông tin</div>
            <table>
                <tr>
                    <td class="first"><?php echo __('Test'); ?>:</td>
                    <td><?php echo $subject['Subject']['name']; ?> </td>
                </tr>
                <tr>
                    <td class="first"><?php echo __('Timelimit'); ?>:</td>
                    <td><?php echo $duration.' '.__('minutes'); ?></td>
                </tr>
                <tr>
                    <td class="first"><?php echo __('Number of questions'); ?>:</td>
                    <td><?php echo $numberOfQuestions; ?></td>
                </tr>
            </table>
        </div> 
        <div class="clock">
            <div><b><?php echo __('Score'); ?></b></div>
            <div id="countdown">
				<?php echo round($correct/$numberOfQuestions,2)*10; ?>				
			</div>
            <div id="details"><?php echo __('Correct').': '.'<b>'.$correct.'</b>'.' '.__('on').' '.__('Total').': '.'<b>'.$numberOfQuestions.'</b>'.' '.__('questions').'.'; ?></div>
            <div class="fb-share-button" data-href="<?php echo Router::url($this->here, true); ?>" data-layout="button_count"></div>            
            <div class="btn-questions">
               <button class="btn show-answers" id="btn-show-answers"><?php echo __('Show Answers'); ?></button>
               <button class="btn show-solutions" id="btn-show-solutions"><?php echo __('Show Solutions'); ?></button>
            </div>
        </div>
        <div class="options">
            <?php echo $this->Html->link(__('Go to dashboard'), array('controller' => 'people', 'action' => 'dashboard'), array('class' => 'btn btn-dashboard')) ?>
            <!--<?php echo $this->Html->link(__('Take this test again'), array('controller' => 'tests', 'action' => 'doTest', 0, 0, $test_id), array('class' => 'btn btn-retake')) ?>-->
        </div>
    </div>
    <div style="clear:both;"></div>
</div>

<div id="modalicon" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm" style='margin-top:100px;'>
        <div class="modal-content">
			<div class="modal-body" style='text-align:center'>
				<table style='border:0px;width:100%;'>
					<tr>
						<td rowspan='2' style='width:40%;'>
							<?php if(round($correct/$numberOfQuestions,2)*10>=8): ?>
								<?php echo $this->Html->image('icon1.png',array('style'=>'max-width:224px')); ?>
							<?php endif; ?>
							<?php if(round($correct/$numberOfQuestions,2)*10<8 && round($correct/$numberOfQuestions,2)*10>4): ?>
								<?php echo $this->Html->image('icon7.png',array('style'=>'max-width:224px')); ?>
							<?php endif;?>
							<?php if(round($correct/$numberOfQuestions,2)*10<5): ?>
								<?php echo $this->Html->image('icon8.png',array('style'=>'max-width:224px')); ?>
							<?php endif;?>
						</td>
						<td style='text-align:center;width:60%;'>
							<?php if(round($correct/$numberOfQuestions,2)*10>=8): ?>
							<span style='color:red;font-size:30px;'>Chúc mừng bạn!<span><br/>
							<?php endif;?>
							<?php if(round($correct/$numberOfQuestions,2)*10<8 && round($correct/$numberOfQuestions,2)*10>4): ?>
							<span style='color:red;font-size:30px;'>Cố gắng lên bạn nhé!<span><br/>
							<?php endif;?>
							<?php if(round($correct/$numberOfQuestions,2)*10<5): ?>
							<span style='color:red;font-size:30px;'>Cố gắng hết mình nào!<span><br/>
							<?php endif;?>
							<span style='color:#259013;font-size:120px;'>
								<?php echo round($correct/$numberOfQuestions,2)*10 ?>
							</span>						
						</td>
					</tr>
					<tr>
						<td>
							<?php echo __('Correct').': '.'<b>'.$correct.'</b>'.' '.__('on').' '.__('Total').': '.'<b>'.$numberOfQuestions.'</b>'.' '.__('questions').'.'; ?>
						</td>
					</tr>
				</table>					
			</div>
			<div class="modal-footer">
				<button class="btn show-answers btn-primary" id="btn-show-answers" data-dismiss="modal"><?php echo __('Show Answers'); ?></button>
               <button class="btn show-solutions btn-primary" id="btn-show-solutions" data-dismiss="modal"><?php echo __('Show Solutions'); ?></button>
			   <?php echo $this->Html->link(__('Go to dashboard'), array('controller' => 'people', 'action' => 'dashboard'), array('class' => 'btn btn-dashboard btn-primary')) ?>
			</div>
        </div>
    </div>
</div>

<div id="msgNotice" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width:30%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Thông báo</h4>
            </div>
            <div class="modal-body" style='text-align:center'>
                <p id='tb'>Cảm ởn sự đóng góp của bạn!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $(document).ready(function(){
		$('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'right'});
		$('#modalicon').modal({
                backdrop: true
            });
        //fb share
        var FBShare = function () {
            FB.ui({
                method: 'share',
                href: '<?php echo Router::url('/'); ?>',
            }, function(response) {
                if (response && !response.error_code) {
                    alert('Posting completed.');
                } else {
                    alert('Error while posting.');
                }
            });
        };
        <?php //if ( count($explanationsData) < 1 ): ?>
          //setTimeout(FBShare, 1000);
        <?php //endif; ?>
        $('.fb-share-button').click(function() {
            FBShare();
        });

        var showAnswer = false;
        var showSolution = false;
        $('ul#questions').simplePaging({pageSize: "1"});

        $('div.nav button.prev').on('click', function(){
            $('ul#questions').data('simplePaging').prevPage(); 
        });

        $('div.nav button.next').on('click', function(){
            $('ul#questions').data('simplePaging').nextPage(); 
        });

        $('.show-answers').on('click', function(){
            if( showAnswer == false){
                $('[correct=true]').addClass('active');
				$('.report').css('display', 'block');
                $('.correct-answer').css('display', 'block');
                $('#btn-show-answers').text("<?php echo __('Hide Answers'); ?>");
                showAnswer = true;
            }
            else{
                $('[correct=true]').removeClass('active');	
				$('.report').css('display', 'none');
                $('.correct-answer').css('display', 'none');
                $('#btn-show-answers').text("<?php echo __('Show Answers'); ?>");
                showAnswer = false;				
            }
        });

         $('.show-solutions').on('click', function(){
            if( showSolution == false){
				$('[correct=true]').addClass('active');
				$('.correct-answer').css('display', 'block');
				$('.report').css('display', 'block');
                $('.solution').css('display', 'block');
                $('#btn-show-solutions').text("<?php echo __('Hide Solutions'); ?>");
                showSolution = true;
            }
            else{
				$('[correct=true]').removeClass('active');
				$('.correct-answer').css('display', 'none');
				$('.report').css('display', 'none');
                $('.solution').css('display', 'none'); 
                $('#btn-show-solutions').text("<?php echo __('Show Solutions'); ?>");
                showSolution = false;
            }
        });

        // label for question suer choose wrong
        var wrong = JSON.parse("<?php echo json_encode($wrong_list); ?>");
        for (var i = wrong.length - 1; i >= 0; i--) {
            $('.simplePageNav' + (wrong[i] + 1)).addClass('wrong');
        };
		
		var truee = JSON.parse("<?php echo json_encode($true_list); ?>");
        for (var i = truee.length - 1; i >= 0; i--) {
            $('.simplePageNav' + (truee[i] + 1)).addClass('true');
        };

        //mixpanel
        $('.btn-dashboard').click(function(){
            mixpanel.track('Review.go_to_dashboard', {
                'Test ID' : "<?php echo $test_id; ?>",
                'user ID' : "<?php echo $user['id']; ?>"
            });
        });

        $('.btn-retake').click(function(){
            mixpanel.track('Review.re-test', {
                'Test ID' : "<?php echo $test_id; ?>",
                'user ID' : "<?php echo $user['id']; ?>"
            });
        });
		
		$(document).on('click','.report',function(){
			$question_id = $(this).attr('data-id');
			var url = '<?php echo Router::url(array('controller'=>'scores','action'=>'report'));?>/' + $question_id;
			$.getJSON(url, function( data ) {
			});
			$('#msgNotice').modal({
                backdrop: false
            });
		});

    });

</script>

<!-- if not logged in, let's do it! -->
<?php else: ?>
    <center>
        <h2><?php echo __('Please login to view the content!'); ?></h2>
        <a href="<?php echo $fb_login_url; ?>" class="mix-login" data-section="home-footer">
            <?php echo $this->Html->image('facebook-login-button.png', array('style'=> 'width:100%;','class' => 'facebook-btn', 'alt' => __('Login with Facebook'))); ?>
        </a>
        </br>
        <h2><?php echo __('And learn a lot from PLS!'); ?></h2>
        <div class="container advantage-image">
            
            <div class="row">
                <div class="col-md-4">
                    <div class="advantages-container">
                        <div class="advantages-image">
                            <?php echo $this->Html->image('statistic.jpg'); ?>
                        </div>  
                        <div class="advantages-text">
                            <p><b>Theo dõi kết quả học tập</b></p>
                            <p>Giúp bạn nắm bắt được tình hình và cải tiến chất lượng học tập của mình</p>
                        </div>
                    </div>  
                </div>
                <div class="col-md-4">
                    <div class="advantages-container">
                        <div class="advantages-image">
                            <?php echo $this->Html->image('responsive.png'); ?>
                        </div>  
                        <div class="advantages-text">
                            <p><b>Học mọi lúc mọi nơi</b></p>
                            <p>Hỗ trợ đa nền tảng cho phép bạn có thể làm bài trên bất cứ thiết bị nào và bất cứ nơi đâu</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="advantages-container">
                        <div class="advantages-image">
                            <?php echo $this->Html->image('ask.jpg'); ?>
                        </div>  
                        <div class="advantages-text">
                            <p><b>Cộng đồng hỗ trợ học tập</b></p>
                            <p>Kết bạn, trò chuyện và trao đổi bài tập với giáo viên, bạn bè trên hệ thống</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </center>
    <script type="text/javascript">
        mixpanel.track('Review.not-login', {
            'referer': "<?php echo $user['facebook']; ?>" 
        });
    </script>
<?php endif; ?>

