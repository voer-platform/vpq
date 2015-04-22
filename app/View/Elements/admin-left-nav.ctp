<div class='col-lg-2'>
	<div class="list-group">
		<?php echo $this->Html->link(__('Add Questions'), array('controller' => 'Admin', 'action' => 'insertQuestions'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Add Mutiple Questions'), array('controller' => 'Admin', 'action' => 'insertMultipleQuestions'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Manage People'), array('controller' => 'people', 'action' => 'index'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Manage Questions'), array('controller' => 'questions', 'action' => 'index'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Manage SubCategories'), array('controller' => 'subcategories', 'action' => 'index'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Categorize'), array('controller' => 'Admin', 'action' => 'manualCategorized'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Analystic'), array('controller' => 'Admin', 'action' => 'analystics'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('FAQ'), array('controller' => 'Faqs', 'action' => 'index'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Ranking Data'), array('controller' => 'Admin', 'action' => 'ranking'), array('class'=>'list-group-item')); ?>
		<?php echo $this->Html->link(__('Static pages'), array('controller' => 'StaticPages', 'action' => 'index'), array('class'=>'list-group-item')); ?>
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