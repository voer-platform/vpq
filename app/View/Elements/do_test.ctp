<div class='doTest'>
    <center>
    <h1>Đang Kiểm Tra...<?php //echo __('Do your Test')?></h1>
    </center>

    <div class="test-info">
        <?php echo '<b>'.__('Test').'</b>: '.$this->Name->subjectToName($subject); ?> </br>
        <?php echo ' <b>'.__('Timelimit').'</b>: '.$duration.' '.__('minutes'); ?> </br>
        <?php echo ' <b>'.__('Number of questions').'</b>: '.$numberOfQuestions; ?> </br>
    </div>
    <hr>

    <?php echo $this->Form->create('TestAnswers', array( 'url' => 'score')); ?>
        <ul id="questions">
        <?php foreach ($questions as $index => $question): ?>
            <li id='dotestQuestions'>
                <fieldset>
                    <div class="question">
                        <?php echo "<b>", __('Question'), ' ', $index+1, "/", $numberOfQuestions, ":</b>  "; ?>
                        <br />
                        <?php echo html_entity_decode($question['Question']['content']); ?>
                    </div>
                    <?php $option = array(); ?>
                    <?php foreach ($question['Answer'] as $aindex => $answer): ?>
                        <?php $option[$aindex] = $answer['content']; //.'--'.$answer['correctness']; ?>
                    <?php endforeach; ?>
                    <div class="answer-heading">
                        <h5>Đáp án:</h5>
                    </div>
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
    <center>
        <hr />
        <label for="">Bạn có thể click nút bên cạnh nếu muốn kết thúc bài kiểm tra &nbsp;</label>
        <?php echo $this->Form->end(array(
            'label' => __('Submit your answers'), 
            'class' => 'btn btn-warning btn-lg', 
            'id' => 'btn-submit')); ?>
    </center>

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
