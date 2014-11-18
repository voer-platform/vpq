<?php echo $this->Html->css('dashboard.css');?>
<div class='dashboard'>
    <h2 class="page-heading heading"><?php echo __('Dashboard');?></h2>
    <div class="dashboard-header clearfix">
        <div class="pull-left clearfix">
            <div class="avatar pull-left">
                <?php echo $this->Html->image($user['image'], array('width' => '60px', 'height' => '60px')); ?>
            </div>
            <div class="user-name pull-right">
                <h4><?php echo $user['first_name'].' '.$user['last_name'] ?></h4>
                <div>
                    <?php echo $this->Html->link(__('Edit Profile'),array('controller'=> 'people','action'=> 'view', $user['id'])); ?>
                </div>
            </div>
        </div>
        <div class="overall-rating clearfix pull-right">
            <div class="pull-left">
                <div><?php echo __('Completeness'); ?></div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped" style="width: <?php echo $cover[1] == 0? 0 : round($cover[0]/$cover[1]*100); ?>%;" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" id="preogressbar-cover"><?php echo $cover[0].'/'.$cover[1]; ?></div>
                    
                </div>
            </div>
            <div class="pull-left">
                <div><?php echo __('Rating'); ?></div>
                <div class="progress">
                    <div class="progress-bar progress-bar-warning" style="width: <?php echo $scores[1] == 0? 0 : round($scores[0]/$scores[1]*100); ?>%;" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" id="preogressbar-rating"><?php echo $scores[0].'/'.$scores[1]; ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="time-range clearfix">
        <a class="pull-right btn btn-default btn-xs"><?php echo __('Custom'); ?></a>
        <a class="pull-right btn btn-primary btn-xs"><?php echo __('1 Week'); ?></a>
        <a class="pull-right btn btn-default  btn-xs"><?php echo __('1 Month'); ?></a>
        <a class="pull-right btn btn-default btn-xs"><?php echo __('All time'); ?></a>
        <h5 class="pull-right"><?php echo __('Time range'); ?></h5>
    </div>
    <div class="row">
        <?php echo $this->Html->link(__("Test"), array("controller" => "tests", "action" => "chooseTest", 2), array("class" => "btn btn-lg btn-primary")) ?>
        <div class="col-md-2 filters">
            <div class="well well-sm">
                <label for=""><?php echo __('Grades'); ?></label>
                <ul class="list-unstyled">
                    <li><input type="checkbox" name="checkbox-grade-10" id="checkbox-grade-10" value="1" class="checkbox-grade"/><label for="checkbox-grade-10"><?php echo __('Grade').' '.'10'; ?></label></li>
                    <li><input type="checkbox" name="checkbox-grade-11" id="checkbox-grade-11" value="2" class="checkbox-grade"/><label for="checkbox-grade-11"><?php echo __('Grade').' '.'11'; ?></label></li>
                    <li><input type="checkbox" name="checkbox-grade-12" id="checkbox-grade-12" value="3" class="checkbox-grade"/><label for="checkbox-grade-12"><?php echo __('Grade').' '.'12'; ?></label></li>
                </ul>
            </div>
            <div class="well well-sm">
                <label for=""><?php echo __('Subjects') ?></label>
                <ul class="list-unstyled">
                    <li><input type="checkbox" name="checkbox-subject-maths" id="checkbox-subject-maths" value="1" class="checkbox-subject"/><label for="checkbox-subject-maths"><?php echo __('Maths'); ?></label></li>
                    <li><input type="checkbox" name="checkbox-subject-physics" id="checkbox-subject-physics" value="2" class="checkbox-subject"/><label for="checkbox-subject-physics"><?php echo __('Physics'); ?></label></li>
                    <li><input type="checkbox" name="checkbox-subject-chemists" id="checkbox-subject-chemists" value="3" class="checkbox-subject"/><label for="checkbox-subject-chemists"><?php echo __('Chemists'); ?></label></li>
                    <li><input type="checkbox" name="checkbox-subject-biology" id="checkbox-subject-biology" value="4" class="checkbox-subject"/><label for="checkbox-subject-biology"><?php echo __('Biology'); ?></label></li>
                </ul>
            </div>
        </div>
        <div class="col-md-10 dashboard-content">
            <label><?php echo __("Your Performance"); ?></label>
            <div id = 'chart'>
            </div>
            <hr/>
            <label><?php echo __("Exams Took"); ?></label>
            <?php echo $this->element('table_score'); ?>
        </div>
    </div>
</div>
<?php echo $this->HTML->script('https://www.google.com/jsapi'); ?>

<script type="text/javascript">

    var ajaxData = null;
    var chart = null;
    var currentGrade = 0;      //current grade, 0 = all
    var currentSubject = 0;     // current grade, 0 = all
    var cover = [];             // current cover
    var rating = [];            // current rating

    //
    // Draw chart
    //
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(loadData);

    function loadData(){
        ajaxLoad(0);
        drawChart();
    }

    function ajaxLoad(subject_id){
        var URL = "<?php echo Router::url(array('controller'=>'scores','action'=>'performanceDetails'));?>"
        // get chart data from ajax call
        $.ajax({
            type: 'POST',
            url : URL,
            async : false,
            data: {
                'chartType' : 'ggChart',
                'subject'  : subject_id,
                // 'grade' : grade_id
            },
            success : function (msg) {
                if(msg != ''){
                    ajaxData = JSON.parse(msg);

                    // if empty, create a fake object, to void fault
                    if( ajaxData.length == 1){
                        ajaxData.push([0,0]);
                    }
                }
                else {
                    ajaxData = [];
                }
            }
        });
    }

    // draw the data
    function drawChart(){
        var data = google.visualization.arrayToDataTable(ajaxData);

        var options = {
            title : '',
            vAxis:{
                format: '##%',
                maxValue: 1,
                minValue: 0
            },
            hAxis:{
                format: "MM/dd/yy"
            }
        };
        data.addColumn({type: 'string', role: 'annotation'});

        chart = new google.visualization.LineChart(document.getElementById('chart'));
        chart.draw(data, options);
    }

    // listener
    $(".checkbox-subject").each(function()
    {
        $(this).change(function()
        {
            $(".checkbox-subject").prop('checked',false);
            $(this).prop('checked',true);
            currentSubject = this.value;
            ajaxLoadChange(currentSubject, currentGrade);
            drawChart();
        });
    });
    
    $(".checkbox-grade").each(function()
    {
        $(this).change(function()
        {
            $(".checkbox-grade").prop('checked',false);
            $(this).prop('checked',true);
            currrentGrade = this.value;
            ajaxLoadChange(currentSubject, currentGrade);
            drawChart();
        });
    });

    // ajax load
    // whenever user change options, call ajax and change content
    // finally, redraw and apply changes
    function ajaxLoadChange(subject, grade){
        var URL1 = "<?php echo Router::url(array('controller'=>'scores','action'=>'ajaxOverall'));?>";
        var URL2 = "<?php echo Router::url(array('controller'=>'questions','action'=>'ajaxCover'));?>";
        // get chart data from ajax call
        $.ajax({
            type: 'POST',
            url : URL1,
            async : false,
            data: {
                'subject'  : subject,
                'grade' : grade
            },
            success : function (msg) {
                if(msg != ''){
                    var data = JSON.parse(msg);
                    rating = ajaxData;
                }
                else {
                    ajaxData = [];
                }
            }
        });
        // get chart data from ajax call
        $.ajax({
            type: 'POST',
            url : URL2,
            async : false,
            data: {
                'subject'  : subject,
                'grade' : grade
            },
            success : function (msg) {
                if(msg != ''){
                    var data = JSON.parse(msg);
                    cover = ajaxData;
                }
                else {
                    ajaxData = [];
                }
            }
        });
    }

</script>