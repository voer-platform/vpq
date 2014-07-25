<?php echo $this->Html->css('dashboard.css');?>
<?php echo $this->Html->css('tree.css'); ?>

<div class='dashboard'>
    <div class ='head'>  
        <h2>Your subjects</h2>
    </div>
  
    <!-- Progress -->
    <div class='progress-container'>
        <div class ='row'>
            <div class ='row'>
            <div class = 'row row-1'>
                <div class='col-lg-6 col-md-8 col-sm- col-xs-9 col-lg-offset-3 col-md-offset-3'>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="63" aria-valuemin="0" aria-valuemax="100" style='width:63%;'>
                        Covered: 63%
                        </div>
                    </div>
                </div>
                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                    <?php echo $this->Html->link(__('Take a Physics test'), array('controller' => 'tests', 'action' => 'chooseTest', 'physics'), array('class' => 'btn btn-primary btn-sm')); ?>
                </div>
            </div>
            <div class = 'row row-2'>
                <div class='col-lg-6 col-md-8 col-sm- col-xs-9 col-lg-offset-3 col-md-offset-3'>
                    Performance:
                    <?php echo $this->Html->link($performance['physics'].'%', array('controller' => 'People', 'action' => 'performanceDetails', 'physics') ) ?>
                    (latest 10 tests).
                </div>
            </div>
        </div>
        <div class ='row'>
            <div class = 'row row-1'>
                <div class='col-lg-6 col-md-8 col-sm- col-xs-9 col-lg-offset-3 col-md-offset-3'>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style='width:0%;'>
                        </div>
                    </div>
                </div>
                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                    <?php echo $this->Html->link(__('Take a Maths test'), array('controller' => 'tests', 'action' => 'chooseTest', 'maths'), array('class' => 'btn btn-primary btn-sm')); ?>
                </div>
            </div>
            <div class = 'row row-2'>
                <div class='col-lg-6 col-md-8 col-sm- col-xs-9 col-lg-offset-3 col-md-offset-3' id='physics-performace'>
                </div>
            </div>
        </div>
        <div class ='row'>
            <div class = 'row row-1'>
                <div class='col-lg-6 col-md-8 col-sm- col-xs-9 col-lg-offset-3 col-md-offset-3'>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style='width:0%;'>
                        </div>
                    </div>
                </div>
                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                    <?php echo $this->Html->link(__('Take a Chemist test'), array('controller' => 'tests', 'action' => 'chooseTest', 'chemist'), array('class' => 'btn btn-primary btn-sm')); ?>
                </div>
            </div>
            <div class = 'row row-2'>
                <div class='col-lg-6 col-md-8 col-sm- col-xs-9 col-lg-offset-3 col-md-offset-3'>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->HTML->script('d3.min.js'); ?>
<?php echo $this->HTML->script('tree.js'); ?>