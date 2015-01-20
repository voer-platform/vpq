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
        <center>
            <?php echo $this->Html->link(__("Test"), array("controller" => "tests", "action" => "chooseTest", 2), array("class" => "btn btn-lg btn-primary")) ?>
        </center>
        
        <div class='row dashboard-chart-score'>
            <div class='col-lg-3'>
                <div class='score-container'>
                    <div class='title' id='title-overall'><?php echo __('Score'); ?></div>                    
                    <div class='score' id='score-overall'><?php $score = round($scores[0]/$scores[1], 2)*10; echo $score; ?></div>
                    <div class='description' id='descripion-overall'><?php echo __('Your overall score on all subject. Calculated on latest 10 tests.'); ?></div>
                </div>
                <div class='chart-description pull-right'>
                    <?php echo __('* Score on chart shows average score latest 10 tests.'); ?>
                </div>
            </div>    
            <div class='col-lg-9'>
                <label for='chart'><?php echo __("Your Performance chart"); ?></label>
                <div id ='chart'></div>
            </div>
        </div> 
        
        <hr/>
        <div class='row'>
            <ol class="breadcrumb" id="breadcrumb-list">
              <li class='active'><?php echo __("Subjects"); ?></li>
            </ol>    
        </div>
        <div>
            <div class="filter well well-md">
                <!-- <label for=""><?php echo __('Grades'); ?></label> -->
                <ul class="list-unstyled">
                    <li><button class='progess-table btn btn-sm btn-primary btn-test' id='load-all-progress' type='0'><?php echo __('Load All'); ?></button></li>
                    <li><input type="checkbox" name="checkbox-grade-10" id="checkbox-grade-10" value="1" class="checkbox-grade" grade='1' /><label for="checkbox-grade-10"><?php echo __('Grade').' '.'10'; ?></label></li>
                    <li><input type="checkbox" name="checkbox-grade-11" id="checkbox-grade-11" value="2" class="checkbox-grade" grade='2' /><label for="checkbox-grade-11"><?php echo __('Grade').' '.'11'; ?></label></li>
                    <li><input type="checkbox" name="checkbox-grade-12" id="checkbox-grade-12" value="3" class="checkbox-grade" grade='3' /><label for="checkbox-grade-12"><?php echo __('Grade').' '.'12'; ?></label></li>
                </ul>
            </div>
            <div id ='dashboard-table'>
                <?php echo $this->element('progress_subject'); ?>                   
            </div>
        </div>
        <div class='hiddenRow accordion-body collapse' id='demo1' style='padding:0; !important'>Demo1</div>
    </div>
</div>

<script type="text/javascript">
    /**
     * get data from ajax for table
     */
    var currentSubject      = null;
    var currentSubjectID    = null
    var currentCategory     = null;
    var currentCategoryID   = null;
    var curerentLoadAll     = false;
    var currentChecked      = [];

    /**
     * Filters
     */

    $('.checkbox-grade').change(function(){
        console.log('change');
        currentChecked = [];
        $('.checkbox-grade:checkbox:checked').each(function(){
            currentChecked[currentChecked.length] = $(this).attr('grade');
        });

        if(currentChecked.length == 0){
            currentChecked = null;
        }
        else {
            currentChecked = currentChecked.join();
        }

        ajaxLoad(currentSubjectID, currentChecked, currentCategoryID);
    });

    /**
     * Tables
     */ 

    function tableClick(){
        var type = parseInt($(this).attr('type'));
        // subject
        if(type == 0){
            currentSubject      = null;
            currentSubjectID    = null;
            currentCategory     = null;
            currentCategoryID   = null;

            // ajax
            ajaxLoad(currentSubjectID, currentChecked, currentCategoryID);

            // breadcrumb
            $('#breadcrumb-list').html("<li class='active'><?php echo __('Subjects'); ?></li>");
            console.log('before' + curerentLoadAll);
            if(curerentLoadAll == false){
                ajaxTable(0);
                $('#load-all-progress').text("<?php echo __('Load Subjects'); ?>");
                curerentLoadAll = true;
            }
            else if(curerentLoadAll == true){
                ajaxTable(1);
                $('#load-all-progress').text("<?php echo __('Load All'); ?>");
                curerentLoadAll = false;
            }
        }
        else if(type == 1){
            currentSubject      = null;
            currentSubjectID    = null;
            currentCategory     = null;
            currentCategoryID   = null;

            // breadcrumb
            $('#breadcrumb-list').html("<li class='active'><?php echo __('Subjects'); ?></li>");

            // ajax
            ajaxLoad(currentSubjectID, currentChecked, currentCategoryID);

            // table
            ajaxTable(1);
        }
        // category
        else if (type == 2){
            currentSubject      = this.text;
            currentSubjectID    = $(this).attr('subject');
            currentCategory     = null;
            currentCategoryID   = null;

            // breadcrumb
            $('#breadcrumb-list').html(
                "<li><a href='javascript:void(0);' class='breadcrumb-link' type='1'><?php echo __('Subjects'); ?></a></li>" + 
                "<li class='active'>" + currentSubject + "</li>");

            // ajax
            ajaxLoad(currentSubjectID, currentChecked, currentCategoryID);

            // table
            ajaxTable(2, $(this).attr('subject'));
        }
        // subcategory
        else if(type == 3){
            currentCategory     = this.text;
            currentCategoryID   = $(this).attr('category')

            // breadcrumb
            $('#breadcrumb-list').html(
                "<li><a href='javascript:void(0);' class='breadcrumb-link' type='1'><?php echo __('Subjects'); ?></a></li>" +
                "<li><a href='javascript:void(0);' class='breadcrumb-link' type='2' subject="+currentSubjectID+">" + currentSubject + "</a></li>" + 
                "<li class='active'>"+ currentCategory + "</li>");

            // ajax
            ajaxLoad(currentSubjectID, currentChecked, currentCategoryID);

            // table
            ajaxTable(3, $(this).attr('category'));
        }
    }
    
    $('.progress-table').click(tableClick);
    $('#load-all-progress').click(tableClick);
    $('.breadcrumb-link').click(tableClick);

    // get table from ajax
    function ajaxTable(type, id){
        var url = "<?php echo Router::url(array('controller'=>'progresses','action'=>'ajaxTable'));?>"
        $.ajax({
            type : 'GET',
            url : url,
            data : {
                type : type,
                id : id
            },
            success : function(msg){
                $('#dashboard-table').html(msg);
                $('.progress-table').click(tableClick);
                $('.breadcrumb-link').click(tableClick);   
            }
        });
    }

</script>

<?php echo $this->HTML->script('http://www.google.com/jsapi'); ?>
<script type="text/javascript">
    /**
     * Ajax on chart data
     */
    var chart           = null;
    var currentGrade    = 0;                //current grade, 0 = all
    // var currentSubject = 0;              // current subject, 0 = all
    var cover           = [];               // current cover
    var rating          = [];               // current rating

    //
    // Draw chart
    //
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(loadAndDraw);

    // load data for draw chart and draw
    function loadAndDraw(){
        console.log('call load ajax');
        ajaxLoad();
    }

    function ajaxLoad(subjectID, gradeID, categoryID){
        console.log('gradeID : ' + gradeID);
        console.log(gradeID);

        // load chart data by ajax
        var URL = "<?php echo Router::url(array('controller'=>'scores','action'=>'ajaxCallHandler'));?>"
        // get chart data from ajax call
        $.ajax({
            type: 'POST',
            url : URL,
            data: {
                'subject'   : subjectID,
                'gradeID'   : gradeID,
                'categorydID' : categoryID
            },
            success : function (msg) {
                if(msg != ''){
                    var jsonData = JSON.parse(msg);

                    drawChart(jsonData.chart);

                    $('#score-overall').text(jsonData.score);
                }
            }
        });
    }

    // draw the data
    function drawChart(inputData){
        var data = google.visualization.arrayToDataTable(inputData);

        var options = {
            title : '',
            vAxis:{
                format: '#.#',
                maxValue: 10,
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
</script>