<?php
/**
 * @var $this View
 */
?>

<div class='dashboard container'>
    <div class='row'>
        <div class="col-md-6">
            <div id="tree-container"></div>
        </div>

        <div class="col-md-6">
            <div class='row'>
                <div id = "chart" class = "dashboard"></div>
            </div>
            <div class='row'>
                <div id = "performance" class = "dashboard">
                    <p class = 'hint'>Your overall performance: </p>
                    <p id = 'performance_value'></p>
                    <p id = 'ranking'>rank #125/582 users on VPQ</p>
                    <p id = 'rating'>You are doing: well!</p>
                    <p class = 'hint'>share this! on <a href="">FB</a></p>

                    <p id = 'suggestion'>Want to improve your result?</p>
                    <p class = 'hint'>try our <?php echo $this->HTML->link('suggestion', array('controller' => 'people', 'action'=>'suggestion'));?></p>
                </div>
            </div>    
        </div>
    </div>
</div>

<?php echo $this->HTML->script('https://www.google.com/jsapi'); ?>
<?php echo $this->HTML->script('chart.js'); ?>
<?php echo $this->HTML->script('d3.min.js'); ?>
<?php echo $this->HTML->script('tree.js'); ?>

<?php echo $this->HTML->css('dashboard.css'); ?>
<?php echo $this->HTML->css('tree.css'); ?>