<div id='doTest'>
    <?php echo $this->Form->create('TestAnswers', array( 'url' => 'score')); ?>
    <div id="left">
        <ul id="questions">
        <?php foreach ($questions as $index => $question): ?>
            <li id='dotestQuestions'>
                <fieldset>
                    <div class="question">
                        <div class="title"><?php echo "<b>", __('Question'), ' ', $index+1, "/", $numberOfQuestions, ":</b>  "; ?></div>
                        <div class="question-content"><?php echo html_entity_decode($question['Question']['content']); ?></div>
                    </div>
                    <?php $option = array(); ?>
                    <?php foreach ($question['Answer'] as $aindex => $answer): ?>
                        <?php $option[$aindex] = $answer['content']; //.'--'.$answer['correctness']; ?>
                    <?php endforeach; ?>
                    <?php echo $this->Form->input( $index, array(
                            'name' => $question['Question']['id'],
                            'legend' => false,
                            'options' => $option,
                            'separator' => '</br>',
                            'type' => 'radio',
                            'div' => array(
                                'class' => 'choices well well-sm'
                            )
                        ));
                    ?>
                </fieldset>
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
</script>
