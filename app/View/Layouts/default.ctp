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
	<title><?php echo $title_for_layout; ?></title>

    <!-- meta -->
    <?php echo $this->Html->meta('viewport', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no');?>
    <?php echo $this->fetch('meta'); ?>

    <!-- css -->
	<?php echo $this->Html->css('bootstrap.min.css'); ?>
    <?php echo $this->HTML->css('jquery-ui.css'); ?>
    <?php echo $this->HTML->css('jquery.multiselect.css'); ?>
    <?php echo $this->HTML->css('global.css'); ?>
    <?php echo $this->HTML->css('style.css'); ?>

    <!-- javascript -->
    <?php echo $this->Html->script('jquery.min.js');?>
    <?php echo $this->Html->script('jquery.simplePaging.js');?>
    <?php echo $this->Html->script('bootstrap.min.js');?>
    <?php echo $this->Html->script('jquery-ui.min.js');?>
    <?php echo $this->Html->script('jquery.multiselect.js');?>

</head>
<body>
    <?php echo $this->Html->script('facebook.js'); ?>

    <?php //echo $this->element('login'); ?>
    <div class = "header">
        <div id = "menu">
            <?php echo $this->element('menu');?>
        </div>
    </div>

    <div class="home-banner">
        <?php echo $this->Html->image('banner.png', array('alt' => 'PLS')); ?>
    </div>

    <div class = "content container">
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
    </div>

    <?php echo $this->element('footer');?>
    <?php echo $this->Html->script('global.js'); ?>

</body>
</Html>
