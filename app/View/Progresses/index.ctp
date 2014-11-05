<div class="progresses index">
	<h2><?php echo __('Progresses'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('person_id'); ?></th>
			<th><?php echo $this->Paginator->sort('sub_category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('progress'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($progresses as $progress): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($progress['Person']['id'], array('controller' => 'people', 'action' => 'view', $progress['Person']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($progress['SubCategory']['name'], array('controller' => 'sub_categories', 'action' => 'view', $progress['SubCategory']['id'])); ?>
		</td>
		<td><?php echo h($progress['Progress']['progress']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $progress['Progress']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $progress['Progress']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $progress['Progress']['id']), null, __('Are you sure you want to delete # %s?', $progress['Progress']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Progress'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List People'), array('controller' => 'people', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Person'), array('controller' => 'people', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sub Categories'), array('controller' => 'sub_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sub Category'), array('controller' => 'sub_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
