<center>
    <h3><?php echo __('Your status on ').' '.$this->Name->gradeToName($current_grade); ?></h3>
</center>
<div class='progress-container'>
    <!-- physics -->
    <div class ='row'>
        <div class = 'row row-1'>
            <div class='col-lg-1 col-lg-offset-2'>
                <h4><?php echo __('Physics'); ?></h4>
            </div>
            <div class='col-lg-5 col-md-8 col-sm-8 col-xs-9 '>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="63" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $coverage['physics'];?>%;">
                    </div>
                    <?php echo $this->Html->link(__('Covered').':'.$coverage['physics'].'%', array('controller' => 'people', 'action' => 'coverDetails', 2)); ?>
                </div>
            </div>
            <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                <?php echo $this->Html->link(__('Physics test'), array('controller' => 'tests', 'action' => 'chooseTest', 2), array('class' => 'btn btn-primary btn-md')); ?>
            </div>
        </div>
        <div class = 'row row-2'>
            <div class='col-lg-5 col-md-8 col-sm-8 col-xs-9 col-lg-5 col-lg-offset-3'>
                <?php echo __('Performance:'); ?>
                <?php echo $this->Html->link($performance['physics'].'%', array('controller' => 'People', 'action' => 'performanceDetails', 2) ) ?>
                <?php echo __('(latest 10 tests).'); ?>
            </div>
        </div>
    </div>
    <!-- maths -->
    <div class ='row'>
        <div class = 'row row-1'>
            <div class='col-lg-1 col-lg-offset-2'>
                <h4><?php echo __('Maths'); ?></h4>
            </div>
            <div class='col-lg-5 col-md-8 col-sm-8 col-xs-9'>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style='width:0%;'>
                    </div>
                </div>
            </div>
            <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                <?php echo $this->Html->link(__('Maths test'), array('controller' => 'tests', 'action' => 'chooseTest', 'maths'), array('class' => 'btn btn-primary btn-md', 'disabled' => 'disabled')); ?>
            </div>
        </div>
        <div class = 'row row-2'>
            <div class='col-lg-6 col-md-8 col-sm- col-xs-9 col-lg-offset-3 col-md-offset-3' id='physics-performace'>
            </div>
        </div>
    </div>
    <!-- chemists -->
    <div class ='row'>
        <div class = 'row row-1'>
            <div class='col-lg-1 col-lg-offset-2'>
                <h4><?php echo __('Chemist'); ?></h4>
            </div>
            <div class='col-lg-5 col-md-8 col-sm- col-xs-9'>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style='width:0%;'>
                    </div>
                </div>
            </div>
            <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                <?php echo $this->Html->link(__('Chemist test'), array('controller' => 'tests', 'action' => 'chooseTest', 'chemist'), array('class' => 'btn btn-primary btn-md', 'disabled' => 'disabled')); ?>
            </div>
        </div>
        <div class = 'row row-2'>
            <div class='col-lg-6 col-md-8 col-sm-8 col-xs-9 col-lg-offset-3 col-md-offset-3'>
            </div>
        </div>
    </div>
    <!-- bio -->
    <div class ='row'>
        <div class = 'row row-1'>
            <div class='col-lg-1 col-lg-offset-2'>
                <h4><?php echo __('Chemist'); ?></h4>
            </div>
            <div class='col-lg-5 col-md-8 col-sm- col-xs-9'>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style='width:0%;'>
                    </div>
                </div>
            </div>
            <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                <?php echo $this->Html->link(__('Bio test'), array('controller' => 'tests', 'action' => 'chooseTest', 'chemist'), array('class' => 'btn btn-primary btn-md', 'disabled' => 'disabled')); ?>
            </div>
        </div>
        <div class = 'row row-2'>
            <div class='col-lg-6 col-md-8 col-sm-8 col-xs-9 col-lg-offset-3 col-md-offset-3'>
            </div>
        </div>
    </div>    
</div>