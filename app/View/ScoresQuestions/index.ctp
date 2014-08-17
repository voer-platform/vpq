<div class="scoresQuestions index">
	<h2><?php echo __('Scores Questions'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('score_id'); ?></th>
			<th><?php echo $this->Paginator->sort('question_id'); ?></th>
			<th><?php echo $this->Paginator->sort('answer_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($scoresQuestions as $scoresQuestion): ?>
	<tr>
		<td><?php echo h($scoresQuestion['ScoresQuestion']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($scoresQuestion['Score']['id'], array('controller' => 'scores', 'action' => 'view', $scoresQuestion['Score']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($scoresQuestion['Question']['id'], array('controller' => 'questions', 'action' => 'view', $scoresQuestion['Question']['id'])); ?>
		</td>
		<td><?php echo h($scoresQuestion['ScoresQuestion']['answer_id']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $scoresQuestion['ScoresQuestion']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $scoresQuestion['ScoresQuestion']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $scoresQuestion['ScoresQuestion']['id']), array(), __('Are you sure you want to delete # %s?', $scoresQuestion['ScoresQuestion']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Scores Question'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Scores'), array('controller' => 'scores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Score'), array('controller' => 'scores', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
