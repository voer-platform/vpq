<div class="scoresQuestions view">
<h2><?php echo __('Scores Question'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($scoresQuestion['ScoresQuestion']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Score'); ?></dt>
		<dd>
			<?php echo $this->Html->link($scoresQuestion['Score']['id'], array('controller' => 'scores', 'action' => 'view', $scoresQuestion['Score']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Question'); ?></dt>
		<dd>
			<?php echo $this->Html->link($scoresQuestion['Question']['id'], array('controller' => 'questions', 'action' => 'view', $scoresQuestion['Question']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Answer Id'); ?></dt>
		<dd>
			<?php echo h($scoresQuestion['ScoresQuestion']['answer_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Scores Question'), array('action' => 'edit', $scoresQuestion['ScoresQuestion']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Scores Question'), array('action' => 'delete', $scoresQuestion['ScoresQuestion']['id']), array(), __('Are you sure you want to delete # %s?', $scoresQuestion['ScoresQuestion']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Scores Questions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Scores Question'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Scores'), array('controller' => 'scores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Score'), array('controller' => 'scores', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
