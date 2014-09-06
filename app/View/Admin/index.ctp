<div class='admin-index container'>
	<div class='row'>
		<!-- left nav -->
		<div class='col-lg-2'>
			<ul class="nav nav-pills nav-stacked">
				<li><?php echo $this->Html->link(__('Add Questions'), array('controller' => 'Admin', 'action' => 'insertQuestions')); ?></li>
				<li><?php echo $this->Html->link(__('Add Subcategories'), array('controller' => 'Admin', 'action' => 'insertQuestions')); ?></li>
				<li><?php echo $this->Html->link(__('Add Categories'), array('controller' => 'Admin', 'action' => 'insertQuestions')); ?></li>
				<li><?php echo $this->Html->link(__('Add Subjects'), array('controller' => 'Admin', 'action' => 'insertQuestions')); ?></li>
			</ul>
		</div>

		<!-- right nav -->
		<div class='col-lg-10'>
			<?php echo __('Select one of functions on the left'); ?>
		</div>
	</div>
</div>