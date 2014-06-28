<div class="testsCategories view">
<h2><?php echo __('Tests Category'); ?></h2>
	<dl>
		<dt><?php echo __('Test'); ?></dt>
		<dd>
			<?php echo $this->Html->link($testsCategory['Test']['id'], array('controller' => 'tests', 'action' => 'view', $testsCategory['Test']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($testsCategory['Category']['name'], array('controller' => 'categories', 'action' => 'view', $testsCategory['Category']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tests Category'), array('action' => 'edit', $testsCategory['TestsCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tests Category'), array('action' => 'delete', $testsCategory['TestsCategory']['id']), null, __('Are you sure you want to delete # %s?', $testsCategory['TestsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tests Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tests Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tests'), array('controller' => 'tests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Test'), array('controller' => 'tests', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
