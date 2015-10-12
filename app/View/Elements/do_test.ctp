<script type="text/javascript"
	  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
	</script>
<div id='doTest'>
    <?php echo $this->Form->create('TestAnswers', array( 'url' => 'score')); ?>
    <div id="left">
        <ul id="questions">
        <?php foreach ($questions as $index => $question): ?>
            <li id='dotestQuestions<?php echo $index+1;?>' rel="<?php echo $index+1;?>" data-id='<?php echo $question['Question']['id'];?>'>
                <fieldset>
                    <div class="question">
                        <div class="title"><?php echo "<b>", 'Câu ', $index+1, ":</b>  "; ?></div>
                        <div class="question-content"><?php echo html_entity_decode($question['Question']['content']); ?></div>
                    </div>
                    <?php $option = array(); ?>
                    <?php foreach ($question['Answer'] as $aindex => $answer): ?>
                        <?php $option[$aindex] = "<span class='lbanswer'>" . chr(97 + $aindex) . "</span>" . $answer['content']; //.'--'.$answer['correctness']; ?>
                    <?php endforeach; ?>
                    <div class="btn-group answer" data-toggle='buttons'>
                        <input type="hidden" value="" name="<?php echo $question['Question']['id']; ?>">
                    <?php echo $this->Form->input( $index, array(
                            'name' => $question['Question']['id'],
							'class' => 'input-answer',
                            'label' => false,
                            'legend' => false,
                            'options' => $option,
                            'before' => '<label class="btn btn-answer">',
                            'after' => '</label>',
                            'separator' => '</label><label class="btn btn-answer">',
                            'type' => 'radio',
                            'hiddenField' => false,
                            'div' => ''
                        ));
                    ?>
                    </div>
                </fieldset>
                <div class="choose-answer">&nbsp;</div>
                <div class="nav">
                    <button class="btn pull-left prev" type="button">Câu hỏi trước</button>
                    <button class="btn pull-right next" type="button">Câu hỏi sau</button>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
        <?php echo $this->Form->input( 'test_id', array(
                'name' => 'testID',
                'value' => $testID,
                'type' => 'hidden'
                ));?>
        <?php echo $this->Form->input( 'number_of_questions', array(
                'name' => 'numberOfQuestions',
                'value' => $numberOfQuestions,
                'type' => 'hidden'
                ));?>
        <?php echo $this->Form->input( 'duration', array(
                'name' => 'duration',
                'value' => 0,
                'type' => 'hidden'
                ));?>
    </div>
    <div id="right">
        <div class="test-info">
            <div class="title">Thông tin</div>
            <table>
                <tr>
                    <td class="first"><?php echo __('Test'); ?>:</td>
                    <td><?php echo $this->Name->subjectToName($subject); ?> </td>
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
            <?php echo $this->element('clock'); ?>
        </div>
        <div id="submitTest">
            <?php echo $this->Form->button("Nộp bài", array(
                'type' => 'button',//__('Submit your answers'), 
                'class' => 'btn btn-warning btn-lg nb', 
                'onclick' => 'submitTest()',
                'id' => 'btn-submit')); ?>
        </div>   
    </div>
    <div style="clear:both;"></div>
    <?php echo $this->Form->end(); ?>
</div>
<div id="msgNotice" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Chú ý</h4>
            </div>
            <div class="modal-body">
                Bạn chưa trả lời hết các câu hỏi. Bạn chắc chắn muốn nộp bài không?
            </div>
            <div class="modal-footer">
                <button id="autoSubmit" type="button" class="btn btn-default lt" data-dismiss="modal">Làm tiếp</button>
                <button id="sureSubmit" type="button" class="btn btn-danger nb" data-dismiss="modal">Nộp bài</button>
            </div>
        </div>
    </div>
</div>
<div id="msgNotice2" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Chú ý</h4>
            </div>
            <div class="modal-body">
                <p id='tb'></p>
            </div>
            <div class="modal-footer">
                <button id="autoSubmit2" type="button" class="btn btn-default lt" data-dismiss="modal">Xem lại</button>
                <button id="sureSubmit2" type="button" class="btn btn-danger nb" data-dismiss="modal">Nộp bài</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	var tgc=parseInt("<?php echo $duration ?>");
	tgc=tgc*60;
	var datatime=[];
	var timequestion=[];
	var id_question,endtime=0;
	var ht=0;
	var starttime = tgc;
	var reSubmit = 0;
	var $count = parseInt("<?php echo $duration ?>");
    // add duration to form, when user submit score early
    // if timeout, it is 0 by default
    $('#TestAnswersDoTestForm').submit(function(){
        var clockMinutes = parseInt($("#clock-minutes").text());
        var clockSeconds = parseInt($('#clock-seconds').text());
        $('#TestAnswersDuration').val(parseInt("<?php echo $duration; ?>")*60 - clockMinutes* 60 - clockSeconds);
    });

    function submitTest(){
        $answered = $('ul.pagination').find('li.chose');
        if ($count == $answered.size()){
			$('.nb').attr('disabled','disabled');
			$('.nb').text('Đang nộp bài');
			var a = {};
			for(i=0;i<datatime.length;i++){
				a[datatime[i]['id']] = datatime[i]['time']
			}
			$.ajax({
				type:'POST',
				data: a,
				url:"<?php echo Router::url(array('controller'=>'tests','action'=>'timeQuestion'));?>/",
				success:function(data){
					$('#TestAnswersDoTestForm').submit();
				}				
			});	            			
        }else{
			window.clearInterval(countdown);
            $('#msgNotice').modal({
                backdrop: false
            });
        }
    }
	
	function question_data(){
		for(i=0;i<$count;i++){
			var s=i+1;
			var id = $('#dotestQuestions'+s).attr('data-id');
			timequestion={id:id,time:0};
			datatime[i]=timequestion;
		}
		id_question=datatime[0]['id'];
	}

    $(document).ready(function(){
	
		question_data();
		
        $('ul#questions').simplePaging({pageSize: "1"});

        $('button#sureSubmit').on('click', function(){
			submitTest();	            
        });
		
		$('button#sureSubmit2').on('click', function(){
            submitTest();
        });
		
		function submitTest() {
			$('.nb').attr('disabled','disabled');
			$('.nb').text('Đang nộp bài');
			var a = {};
			for(i=0;i<datatime.length;i++){
				a[datatime[i]['id']] = datatime[i]['time']
			}
			$.ajax({
				type:'POST',
				data: a,
				url:"<?php echo Router::url(array('controller'=>'tests','action'=>'timeQuestion'));?>/",
				success:function(data){
					$('#TestAnswersDoTestForm').submit();
				},
				error: function(){
					if (reSubmit == 0) {
						reSubmit = 1;
						submitTest();
					}	
				}
			});
		}

        $('ul#questions .answer').find('label.btn').on('click', function(){
            var li = $(this).closest('li');
            var q = li.attr('rel');
            var answer = 97 + parseInt($(this).find('input').val());
            li.find('.choose-answer').text("Bạn chọn phương án " + String.fromCharCode(answer)).show();
            $('ul.pagination').find('li:nth-child(' + q + ')').addClass('chose');
            $('ul#questions').data('simplePaging').nextPage();  
            // setTimeout(function() {
            //     $('ul#questions').data('simplePaging').nextPage();      
            // }, 0);
        });

        $('div.nav button.prev').on('click', function(){
            $('ul#questions').data('simplePaging').prevPage(); 
        });

        $('div.nav button.next').on('click', function(){
            $('ul#questions').data('simplePaging').nextPage(); 
        });
		
		$(document).on('click','#autoSubmit',function(){
			 var countdown = setInterval(function(){
				seconds -= 1;
				clockMinutes.html(zeroPad(Math.floor(seconds/60), 2));
				clockSeconds.html(zeroPad(seconds%60, 2));

				if(seconds == 0){
					window.clearInterval(countdown);
					$('#msgTimeout').modal({
						backdrop: false
					});
					$('#clock-time').val(seconds);
				}
			}, 1000);
		});
		
		$(document).on('click','.btn-answer',function(){	
			$answered = $('ul.pagination').find('li.chose');	
			id = $(this).find('input').attr('name');
			var ktg=tgc-seconds;
				tgc=seconds;
			if ($count == $answered.size()){
				if(ht==0){
					mystopcountdown();
					var Minutes=(zeroPad(Math.floor(seconds/60), 2));
					var Seconds=(zeroPad(seconds%60, 2));
					document.getElementById("tb").innerHTML='Bạn đã làm hết các câu hỏi. Bạn vẫn còn '+'<span style="color:red">'+Minutes+':'+Seconds+'</span> .Bạn muốn xem lại hay nộp bài luôn?';
					$('#msgNotice2').modal({
						backdrop: false
					});		
				}
				ht+=1;
			}
			for(i=0;i<datatime.length;i++){
				if(datatime[i]['id']==id){
					datatime[i]['time']=datatime[i]['time']+ktg;
					if(i!=datatime.length-1){
					id_question=datatime[i+1]['id'];
					}
				}
			}
		});

		$('ul.simplePagerNav li a').click(function(){			
			tgc = seconds;
			endtime = seconds;
			var ktg= starttime - endtime;
			for(i=0;i<datatime.length;i++){
					if(datatime[i]['id']==id_question){
						datatime[i]['time']=datatime[i]['time']+ktg;
					}
				}
			starttime=endtime;
			var rel = $(this).attr('rel');
			id_question = $('.simplePagerPage'+rel).attr('data-id');		
		});
		
		$(document).on('click','#autoSubmit2',function(){
			 var countdown = setInterval(function(){
				seconds -= 1;
				clockMinutes.html(zeroPad(Math.floor(seconds/60), 2));
				clockSeconds.html(zeroPad(seconds%60, 2));

				if(seconds == 0){
					window.clearInterval(countdown);
					$('#msgTimeout').modal({
						backdrop: false
					});
					$('#clock-time').val(seconds);
				}
			}, 1000);
		});
    });
	
</script>

