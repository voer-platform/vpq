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
                    <div class="progress-bar progress-bar-striped" style="width: <?php echo $cover[1] == 0? 0 : round($cover[0]/$cover[1]*100); ?>%;" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    <?php echo $cover[0].'/'.$cover[1]; ?>
                </div>
            </div>
            <div class="pull-left">
                <div><?php echo __('Rating'); ?></div>
                <div class="progress">
                    <div class="progress-bar progress-bar-warning" style="width: <?php echo $scores[1] == 0? 0 : round($scores[0]/$scores[1]*100); ?>%;" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    <?php echo $scores[0].'/'.$scores[1]; ?>
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
        <div class="col-md-2 filters">
            <div class="well well-sm">
                <label for=""><?php echo __('Grades'); ?></label>
                <ul class="list-unstyled">
                    <li><input type="checkbox" name="checkbox-grade-10" id="checkbox-grade-10" value="" /><label for="checkbox-grade-10"><?php echo __('Grade').' '.'10'; ?></label></li>
                    <li><input type="checkbox" name="checkbox-grade-11" id="checkbox-grade-11" value="" /><label for="checkbox-grade-11"><?php echo __('Grade').' '.'11'; ?></label></li>
                    <li><input type="checkbox" name="checkbox-grade-12" id="checkbox-grade-12" value="" /><label for="checkbox-grade-12"><?php echo __('Grade').' '.'12'; ?></label></li>
                </ul>
            </div>
            <div class="well well-sm">
                <label for=""><?php echo __('Subjects') ?></label>
                <ul class="list-unstyled">
                    <li><input type="checkbox" name="checkbox-subject-maths" id="checkbox-subject-maths" value="" /><label for="checkbox-subject-maths"><?php echo __('Maths'); ?></label></li>
                    <li><input type="checkbox" name="checkbox-subject-physics" id="checkbox-subject-physics" value="" /><label for="checkbox-subject-physics"><?php echo __('Physics'); ?></label></li>
                    <li><input type="checkbox" name="checkbox-subject-chemists" id="checkbox-subject-chemists" value="" /><label for="checkbox-subject-chemists"><?php echo __('Chemists'); ?></label></li>
                    <li><input type="checkbox" name="checkbox-subject-biology" id="checkbox-subject-biology" value="" /><label for="checkbox-subject-biology"><?php echo __('Biology'); ?></label></li>
                </ul>
            </div>
        </div>
        <div class="col-md-10 dashboard-content">
            <label>Your Performance</label>
            <div id = 'chart'>
            </div>
            <hr />
            <label>Exams Took</label>
            <?php echo $this->element('table_score'); ?>
            <div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->HTML->script('https://www.google.com/jsapi'); ?>

<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);

    var ajaxData = null;
    var URL = "<?php echo Router::url(array('controller'=>'progresses','action'=>'performanceDetails'));?>"
    console.log();
    // get chart data from ajax call
    $.ajax({
        type: 'POST',
        url : URL,
        async : false,
        data: {
            'chartType' : 'ggChart',
            'subject'  : 2
        },
        success : function (msg) {
            if(msg != ''){
                ajaxData = JSON.parse(msg);
            }
            else {
                ajaxData = [];
            }
        }
    });

    // draw the data
    function drawChart(id){
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

        var chart = new google.visualization.LineChart(document.getElementById('chart'));
        chart.draw(data, options);
    }
</script>