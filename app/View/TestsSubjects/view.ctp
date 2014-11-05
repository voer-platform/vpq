<div class="testsSubjects view">
<h2><?php echo __('Tests Subject'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($testsSubject['TestsSubject']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Test'); ?></dt>
		<dd>
			<?php echo $this->Html->link($testsSubject['Test']['id'], array('controller' => 'tests', 'action' => 'view', $testsSubject['Test']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subject'); ?></dt>
		<dd>
			<?php echo $this->Html->link($testsSubject['Subject']['name'], array('controller' => 'subjects', 'action' => 'view', $testsSubject['Subject']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tests Subject'), array('action' => 'edit', $testsSubject['TestsSubject']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tests Subject'), array('action' => 'delete', $testsSubject['TestsSubject']['id']), array(), __('Are you sure you want to delete # %s?', $testsSubject['TestsSubject']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tests Subjects'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tests Subject'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tests'), array('controller' => 'tests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Test'), array('controller' => 'tests', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Subjects'), array('controller' => 'subjects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subject'), array('controller' => 'subjects', 'action' => 'add')); ?> </li>
	</ul>
</div>
