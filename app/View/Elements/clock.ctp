<?php echo $this->Html->css('clock'); ?>

<div id='clock-container' class='panel panel-default'>
    <div class="panel-body">
        <!--<h4><?php echo __('Time remains').': '; ?></h4> -->
        <span id='clock-minutes'></span>:<span id='clock-seconds'></span>
    </div>
</div>

<script type="text/javascript">
    function zeroPad(num, places) {
        var zero = places - num.toString().length + 1;
        return Array(+(zero > 0 && zero)).join("0") + num;
    };

    var seconds = parseInt($('#clock-time').text()) * 60;
    var clockMinutes = $("#clock-minutes");
    var clockSeconds = $('#clock-seconds');

    clockMinutes.html(zeroPad(Math.floor(seconds/60),2));
    clockSeconds.html(zeroPad(seconds%60, 2));

    setInterval(function(){
        seconds -= 1;
        clockMinutes.html(zeroPad(Math.floor(seconds/60), 2));
        clockSeconds.html(zeroPad(seconds%60, 2));

        if(seconds == 0){
            window.clearInterval();
            alert("<?php echo __('Time\'s up!'); ?>");

            $('#TestAnswersDuration').val(seconds);
            alert($('#TestAnswersDuration'));
            $('#btn-submit').click()
        }
    }, 1000);


</script>
