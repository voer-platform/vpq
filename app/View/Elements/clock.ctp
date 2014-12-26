
<div><?php echo __('Time remains').': '; ?></div>
<div id="countdown"><span id='clock-minutes'></span>:<span id='clock-seconds'></span></div>

<div id="msgTimeout" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Hết giờ</h4>
            </div>
            <div class="modal-body">
                Thời gian làm bài đã hết!
            </div>
            <div class="modal-footer">
                <button id="autoSubmit" type="button" class="btn btn-default" data-dismiss="modal">Xem kết quả</button>
            </div>
        </div>
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

    $(document).ready(function() {
        $('#autoSubmit').click(function(){
            $('#btn-submit').click();
        });
    });


</script>
