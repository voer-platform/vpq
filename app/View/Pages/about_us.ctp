<div class = "about_us" id = 'about_us_container' >
	<center>
		<h1><?php echo __('About us'); ?></h1>
	</center>
	<hr>

	<h4><?php echo '1.'.__('What is PLS?'); ?></h4>
	<?php echo __('PLS - Personal Learning System, is a system help you review your knowledge by doing tests. System will help you keep track of your study and know what, where needs improvement. ') ?>

	<h4><?php echo '2.'.__('What kind of knowledge?'); ?></h4>
	<?php echo __('Any kind, it could be school subjects, language, IT, industry, soft-skills, etc. anything. However, currently the system only support high school physics at the moment. '); ?>

	<h4><?php echo '3. '.__('Who should use PLS?') ?></h4>
	<?php echo __('Anyone is welcome.') ?>

	<h4><?php echo '4.'.__('Contacts'); ?></h4>
	<?php 
		echo __('For any questions, email us at: '); 
		echo $this->Html->link('support@pls.edu.vn', 'mailto:support@pls.edu.vn');?>
</div>