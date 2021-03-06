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
    <?php echo $this->HTML->css('global.css'); ?>
    <?php echo $this->HTML->css('style.css'); ?>
	<?php echo $this->HTML->css('datepicker.css'); ?>
	<?php echo $this->HTML->css('select2.css'); ?>
	
    <!-- javascript -->
	<script>var PLS = {ajaxUrl: '<?php echo $this->Html->url('/', true); ?>'};</script>
    <?php echo $this->Html->script('jquery.min.js');?>
    <?php echo $this->Html->script('jquery.simplePaging.js');?>
    <?php echo $this->Html->script('bootstrap.min.js');?>
    <?php echo $this->Html->script('jquery-ui.min.js');?>
    <?php echo $this->Html->script('jquery.multiselect.js');?>
	<?php echo $this->Html->script('bootstrap-datepicker.js');?>
	<?php echo $this->Html->script('select2.min.js');?>
	<?php echo $this->Html->script('global.min.js');?>
	<?php echo $this->Html->script('jquery.slimscroll.min.js');?>
    <!-- if production server -->
</head>
<body>
    <?php echo $this->Html->script('facebook.js'); ?>

    <?php //echo $this->element('login'); ?>
    <div class = "header">
        <div id = "menu">
            <?php  echo $this->element('menuexcel');?>
        </div>
    </div>

    <div>
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
    </div>

    <?php echo $this->element('footerpartner');?>
    <?php if(isset($user)): ?>
        <?php // echo $this->element('faq');?>
    <?php endif;?>

</body>
</Html>
