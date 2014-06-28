<div class="progresses view">
<h2><?php echo __('Progress'); ?></h2>
	<dl>
		<dt><?php echo __('Person'); ?></dt>
		<dd>
			<?php echo $this->Html->link($progress['Person']['id'], array('controller' => 'people', 'action' => 'view', $progress['Person']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sub Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($progress['SubCategory']['name'], array('controller' => 'sub_categories', 'action' => 'view', $progress['SubCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Progress'); ?></dt>
		<dd>
			<?php echo h($progress['Progress']['progress']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Progress'), array('action' => 'edit', $progress['Progress']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Progress'), array('action' => 'delete', $progress['Progress']['id']), null, __('Are you sure you want to delete # %s?', $progress['Progress']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Progresses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Progress'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List People'), array('controller' => 'people', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Person'), array('controller' => 'people', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sub Categories'), array('controller' => 'sub_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sub Category'), array('controller' => 'sub_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
