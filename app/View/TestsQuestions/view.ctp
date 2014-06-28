<div class="testsQuestions view">
<h2><?php echo __('Tests Question'); ?></h2>
	<dl>
		<dt><?php echo __('Test'); ?></dt>
		<dd>
			<?php echo $this->Html->link($testsQuestion['Test']['id'], array('controller' => 'tests', 'action' => 'view', $testsQuestion['Test']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Question'); ?></dt>
		<dd>
			<?php echo $this->Html->link($testsQuestion['Question']['id'], array('controller' => 'questions', 'action' => 'view', $testsQuestion['Question']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tests Question'), array('action' => 'edit', $testsQuestion['TestsQuestion']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tests Question'), array('action' => 'delete', $testsQuestion['TestsQuestion']['id']), null, __('Are you sure you want to delete # %s?', $testsQuestion['TestsQuestion']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tests Questions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tests Question'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tests'), array('controller' => 'tests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Test'), array('controller' => 'tests', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
