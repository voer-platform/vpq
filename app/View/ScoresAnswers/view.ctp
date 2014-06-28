<div class="scoresAnswers view">
<h2><?php echo __('Scores Answer'); ?></h2>
	<dl>
		<dt><?php echo __('Score'); ?></dt>
		<dd>
			<?php echo $this->Html->link($scoresAnswer['Score']['id'], array('controller' => 'scores', 'action' => 'view', $scoresAnswer['Score']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Answer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($scoresAnswer['Answer']['id'], array('controller' => 'answers', 'action' => 'view', $scoresAnswer['Answer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Answer'); ?></dt>
		<dd>
			<?php echo h($scoresAnswer['ScoresAnswer']['answer']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Scores Answer'), array('action' => 'edit', $scoresAnswer['ScoresAnswer']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Scores Answer'), array('action' => 'delete', $scoresAnswer['ScoresAnswer']['id']), null, __('Are you sure you want to delete # %s?', $scoresAnswer['ScoresAnswer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Scores Answers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Scores Answer'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Scores'), array('controller' => 'scores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Score'), array('controller' => 'scores', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Answers'), array('controller' => 'answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
	</ul>
</div>
