<?php
/**
* @var $this HintView
*/
?>


<!DOCTYPE html>

<html>
    
<head>
    <!-- charset -->
	<?php echo $this->Html->charset(); ?>
	<title><?php echo 'PLS - '.$title_for_layout; ?></title>

    <!-- meta -->
    <?php echo $this->Html->meta('icon', $this->Html->url(Router::url('/', true).'img/favicon.png')); ?>
    <?php echo $this->element('mixpanel_init'); ?>
    <?php echo $this->Html->meta('viewport', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no');?>
    <?php echo $this->fetch('meta'); ?>

    <!-- css -->
	<?php echo $this->Html->css('bootstrap.min.css'); ?>
    <?php echo $this->HTML->css('jquery-ui.css'); ?>
    <?php echo $this->HTML->css('jquery.multiselect.css'); ?>
    <?php echo $this->HTML->css('global.css?v=1.4'); ?>
    <?php echo $this->HTML->css('style.css'); ?>
	<?php echo $this->HTML->css('datepicker.css'); ?>
	<?php echo $this->HTML->css('select2.css'); ?>
	<?php echo $this->HTML->css('dataTables.bootstrap.min.css'); ?>
	
	
    <!-- javascript -->
	<script>var PLS = {ajaxUrl: '<?php echo $this->Html->url('/', true); ?>'};</script>
    <?php echo $this->Html->script('jquery.min.js');?>
    <?php echo $this->Html->script('jquery.simplePaging.js');?>
    <?php echo $this->Html->script('bootstrap.min.js');?>
    <?php echo $this->Html->script('jquery-ui.min.js');?>
    <?php echo $this->Html->script('jquery.multiselect.js');?>
	<?php echo $this->Html->script('bootstrap-datepicker.js');?>
	<?php echo $this->Html->script('select2.min.js');?>
	<?php echo $this->Html->script('global.min.js?v=1.5');?>
	<?php echo $this->Html->script('jquery.slimscroll.min.js');?>
	<?php echo $this->Html->script('jquery.dataTables.min.js');?>
	<?php echo $this->Html->script('dataTables.bootstrap.min.js');?>
</head>
<body>
    <div class = "header">
        <div id = "menu">
            <?php  echo $this->element('menuexcel');?>
        </div>
    </div>

    <div class = "content container">
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
    </div>

    <?php echo $this->element('footer');?>

</body>
</Html>
