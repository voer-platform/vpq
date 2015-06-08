<div class="people index">
	<h2><?php echo __('People'); ?></h2>
	<table cellpadding="0" cellspacing="0" class="table table-striped table table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('fullname', __('Fullname')); ?></th>
			<th><?php echo $this->Paginator->sort('birthday'); ?></th>
			<th><?php echo $this->Paginator->sort('date_created'); ?></th>
			<th><?php echo $this->Paginator->sort('gender'); ?></th>
			<th><?php echo $this->Paginator->sort('grade'); ?></th>
			<th><?php echo $this->Paginator->sort('school', __('school')); ?></th>
			<th><?php echo $this->Paginator->sort('address', __('address')); ?></th>
			<th><?php echo $this->Paginator->sort('role', __('role')); ?> </th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($people as $person): ?>
	<tr>
		<td><?php echo h($person['Person']['id']); ?></td>
		<td><a target="blank" href="<?=$this->Html->url(array('controller'=>'Log', 'action'=>'Person', $person['Person']['id']));?>"><?php echo h($person['Person']['fullname']); ?></a></td>
		<td><?php echo h($person['Person']['birthday']); ?></td>
		<td><?php echo h($person['Person']['date_created']); ?></td>
		<td><?php echo h($person['Person']['_gen']); ?></td>
		<td><?php echo h($person['Person']['grade']); ?></td>
		<td><?php echo h($person['Person']['school']); ?></td>
		<td><?php echo h($person['Province']['name']); ?></td>
		<td><?php echo h($person['Person']['role']); ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $person['Person']['id']), array('class'=>'btn btn-default btn-xs')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $person['Person']['id']), array('class'=>'btn btn-default btn-xs')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $person['Person']['id']), array('class'=>'btn btn-danger btn-xs'), __('Are you sure you want to delete # %s?', $person['Person']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
		<?php
			echo $this->Paginator->counter(array(
				'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
			));
		?>
	</p>
	<ul class="pagination mg0">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('tag'=>'li'), null, array('tag'=>'li', 'class' => 'disabled', 'disabledTag'=>'a'));
		echo $this->Paginator->numbers(array('separator' => '', 'tag'=>'li', 'currentClass' => 'active', 'currentTag' => 'a'));
		echo $this->Paginator->next(__('next') . ' >', array('tag'=>'li'), null, array('tag'=>'li', 'class' => 'disabled', 'disabledTag'=>'a'));
	?>
	</ul>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Person'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Progresses'), array('controller' => 'progresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Progress'), array('controller' => 'progresses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Scores'), array('controller' => 'scores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Score'), array('controller' => 'scores', 'action' => 'add')); ?> </li>
	</ul>
</div>
