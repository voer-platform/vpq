<div class="newslettercategories view">
<h2><?php echo __('Newslettercategory'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($newslettercategory['Newslettercategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($newslettercategory['Newslettercategory']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Newslettercategory'), array('action' => 'edit', $newslettercategory['Newslettercategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Newslettercategory'), array('action' => 'delete', $newslettercategory['Newslettercategory']['id']), array(), __('Are you sure you want to delete # %s?', $newslettercategory['Newslettercategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Newslettercategories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Newslettercategory'), array('action' => 'add')); ?> </li>
	</ul>
</div>
