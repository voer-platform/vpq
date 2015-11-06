<div class='col-lg-2'>
	<div class="list-group">
		<?php echo $this->Html->link(__('Manage People'), array('controller' => 'people', 'action' => 'index'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Manage Questions'), array('controller' => 'questions', 'action' => 'index'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link('Bài học', array('controller' => 'subcategories', 'action' => 'index'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Categorize'), array('controller' => 'Admin', 'action' => 'manualCategorized'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Analystic'), array('controller' => 'Admin', 'action' => 'analystics'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Send Facebook Notify'), array('controller' => 'Admin', 'action' => 'sendFacebookNotify'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('FAQ'), array('controller' => 'Faqs', 'action' => 'index'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Ranking Data'), array('controller' => 'Admin', 'action' => 'ranking'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Static pages'), array('controller' => 'StaticPages', 'action' => 'index'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link('Promotional', array('controller' => 'Admin', 'action' => 'promotional'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Card'), array('controller' => 'cardStatistics'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Import Excel'), array('controller' => 'Admin', 'action' => 'import_excel'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Check Questions'), array('controller' => 'Admin', 'action' => 'check_question'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Pull Questions'), array('controller' => 'Admin', 'action' => 'pull_question'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Tests'), array('controller' => 'Tests'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Test Stats'), array('controller' => 'Tests', 'action' => 'stats'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Newsletter'), array('controller' => 'Newsletters', 'action' => 'index'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Announcement'), array('controller' => 'Announcements', 'action' => 'index'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Classify Questions'), array('controller' => 'Admin', 'action' => 'reportclassify'), array('class'=>'list-group-item')); ?>
	</div>
</div>

<!-- set active for current tag -->
<script>
	$(document).ready(function(){
		var path = window.location.pathname;
	    path = path.replace(/\/$/, "");
	    path = decodeURIComponent(path);

	    $("#admin-left-nav a").each(function () {
	        var href = $(this).attr('href');
	        if (path.substring(0, href.length) === href) {
	            $(this).closest('li').addClass('active');
	        }
	    });
	});
</script>