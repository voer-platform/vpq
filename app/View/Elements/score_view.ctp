<div id='doTest'>
    <div id="left">
        <ul id="questions">
        <?php foreach($scoreData as $index => $data): ?>
            <li id='dotestQuestions' rel="<?php echo $index+1;?>">
                <fieldset>
                    <div class="question">
                        <div class="title"><?php echo "<b>", 'Câu ', $index+1, ":</b>  "; ?></div>
                        <div class="question-content"><?php echo html_entity_decode($questionsData[$index]['Question']['content']); ?></div>
                    </div>
                    <div class="btn-group answer" data-toggle="buttons">
                        <?php foreach($questionsData[$index]['Answer'] as $answerId => $answer): ?>
                            <!-- correct answer -->
                            <?php //if( $answer['correctness'] == 1): ?>
                                <!-- <label class='btn btn-answer active'> -->
                            <!-- else -->
                            <?php if( $data['ScoresQuestion']['answer'] == $answerId): ?>
                                <label class='btn-answer active'>
                            <?php else: ?>
                                <label class='btn-answer'>
                            <?php endif; ?>          
                                <span><?php echo chr(97 + $answerId); ?></span><?php echo $answer['content']; ?>
                            </label>
                        <?php endforeach;?>
                    </div>
                </fieldset>
                <?php
                    $a = $data['ScoresQuestion']['answer'];
                    $r = "Bạn đã chọn đáp án " . chr($a + 97) . ". ";
                    $true = $questionsData[$index]['Answer'][$a]['correctness'];
                    $class = "";
                    if ($true == 1){
                        $r .= "Đây là đáp án đúng.";
                    }else{
                        $r .= "Đây là đáp án sai.";
                        $class = "incorrect";
                    }
                ?>
                <div class="choose-answer <?php echo $class; ?>"><?php echo $r; ?></div>
                <div id="ask-for-help">
                    <a href="<?php echo '/ask4Help/index/'.$questionsData[$index]['Question']['id']; ?>"><?php echo __('Ask for help'); ?></a>
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
                    <td><?php //echo $this->Name->subjectToName($subject); ?> </td>
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
            <div>Tổng điểm</div>
            <div id="countdown"><?php echo $correct.'/'.$numberOfQuestions; ?></div>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('ul#questions').simplePaging({pageSize: "1"});

        $('div.nav button.prev').on('click', function(){
            $('ul#questions').data('simplePaging').prevPage(); 
        });

        $('div.nav button.next').on('click', function(){
            $('ul#questions').data('simplePaging').nextPage(); 
        });
    })

</script>

