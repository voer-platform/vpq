<div id='doTest'>
    <?php echo $this->Form->create('TestAnswers', array( 'url' => 'score')); ?>
    <div id="left">
        <ul id="questions">
        <?php foreach ($questions as $index => $question): ?>
            <li id='dotestQuestions' rel="<?php echo $index+1;?>">
                <fieldset>
                    <div class="question">
                        <div class="title"><?php echo "<b>", 'Câu ', $index+1, ":</b>  "; ?></div>
                        <div class="question-content"><?php echo html_entity_decode($question['Question']['content']); ?></div>
                    </div>
                    <?php $option = array(); ?>
                    <?php foreach ($question['Answer'] as $aindex => $answer): ?>
                        <?php $option[$aindex] = "<span>" . chr(97 + $aindex) . "</span>" . $answer['content']; //.'--'.$answer['correctness']; ?>
                    <?php endforeach; ?>
                    <div class="btn-group answer" data-toggle='buttons'>
                        <input type="hidden" value="" name="<?php echo $question['Question']['id']; ?>">
                    <?php echo $this->Form->input( $index, array(
                            'name' => $question['Question']['id'],
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
                'type' => 'submit',//__('Submit your answers'), 
                'class' => 'btn btn-warning btn-lg', 
                'id' => 'btn-submit')); ?>
        </div>   
    </div>
    <div style="clear:both;"></div>
    <?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">

    // add duration to form, when user submit score early
    // if timeout, it is 0 by default
    $('#TestAnswersDoTestForm').submit(function(){
        var clockMinutes = parseInt($("#clock-minutes").text());
        var clockSeconds = parseInt($('#clock-seconds').text());
        console.log(clockMinutes* 60 + clockSeconds);
        $('#TestAnswersDuration').val(clockMinutes* 60 + clockSeconds);
    });

    $(document).ready(function(){
        $('ul#questions').simplePaging({pageSize: "1"});

        $('ul#questions .answer').find('label.btn').on('click', function(){
            var li = $(this).closest('li');
            var q = li.attr('rel');
            var answer = 97 + parseInt($(this).find('input').val());
            li.find('.choose-answer').text("Bạn chọn phương án " + String.fromCharCode(answer)).show();
            $('ul.pagination').find('li:nth-child(' + q + ')').addClass('chose');
            setTimeout(function() {
                $('ul#questions').data('simplePaging').nextPage();      
            }, 500);
        });

        $('div.nav button.prev').on('click', function(){
            $('ul#questions').data('simplePaging').prevPage(); 
        });

        $('div.nav button.next').on('click', function(){
            $('ul#questions').data('simplePaging').nextPage(); 
        });
    })

</script>

