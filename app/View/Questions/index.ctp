<div class="questions index">
	<h2><?php echo __('Questions'); ?></h2>
	<table cellpadding="0" cellspacing="0" class="table table-striped table table-bordered">
	<thead>
	<tr>
			<th class="center"><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('content'); ?></th>
			<th class="center"><?php echo $this->Paginator->sort('total'); ?></th>
			<th class="center"><?php echo $this->Paginator->sort('wrong'); ?></th>
			<th class="center"><?php echo $this->Paginator->sort('_difficulty', 'difficulty'); ?></th>
			<th class="center"><?php echo $this->Paginator->sort('time', 'Total time'); ?></th>
			<th class="center"><?php echo $this->Paginator->sort('_averange_time', 'Average time'); ?></th>
			<th class="actions center"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($questions as $question): ?>
	<tr>
		<td class="center"><?php echo h($question['Question']['id']); ?>&nbsp;</td>
		<td width="500"><?php echo html_entity_decode($question['Question']['content']); ?>&nbsp;</td>
		<td class="center"><?php echo $question['Question']['count']; ?></td>
		<td class="center"><?php echo $question['Question']['wrong']; ?></td>
		<td class="center"><?php echo ($question['Question']['count']>0)?$question['Question']['_difficulty']:'0'; ?></td>
		<td class="center"><?php echo $question['Question']['time']; ?></td>
		<td class="center"><?php echo ($question['Question']['count']>0)?$question['Question']['_averange_time']:'0'; ?></td>
		<td class="actions center">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $question['Question']['id']), array('class'=>'btn btn-default btn-xs')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $question['Question']['id']), array('class'=>'btn btn-default btn-xs')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $question['Question']['id']), array('class'=>'btn btn-danger btn-xs'), __('Are you sure you want to delete # %s?', $question['Question']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
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
		<li><?php echo $this->Html->link(__('New Question'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Answers'), array('controller' => 'answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Subcategories'), array('controller' => 'subcategories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subcategory'), array('controller' => 'subcategories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tests'), array('controller' => 'tests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Test'), array('controller' => 'tests', 'action' => 'add')); ?> </li>
	</ul>
</div>
