<?php
/**
* @var $this HintView
*/
?>


<!DOCTYPE Html>

<Html>
<head>

    <!-- charset -->
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_layout; ?></title>

    <!-- meta -->
    <?php echo $this->Html->meta('viewport', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no');?>

    <!-- css -->
	<?php echo $this->Html->css('bootstrap.min.css'); ?>
    <?php echo $this->HTML->css('global.css'); ?>

    <!-- javascript -->
    <?php echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');?>
    <?php echo $this->Html->script('bootstrap.min.js');?>

</head>
<body>
    <?php echo $this->element('login'); ?>
    <div class = "header">
        <div id = "menu">
            <?php echo $this->element('menu');?>
        </div>
    </div>

    <div class = "content container">
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
    </div>

    <?php echo $this->element('footer');?>
    <?php //echo $this->element('sql_dump'); ?>
    
</body>
</Html>