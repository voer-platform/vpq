<div class="questionsCategories view">
<h2><?php echo __('Questions Category'); ?></h2>
	<dl>
		<dt><?php echo __('Question'); ?></dt>
		<dd>
			<?php echo $this->Html->link($questionsCategory['Question']['id'], array('controller' => 'questions', 'action' => 'view', $questionsCategory['Question']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($questionsCategory['Category']['name'], array('controller' => 'categories', 'action' => 'view', $questionsCategory['Category']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Questions Category'), array('action' => 'edit', $questionsCategory['QuestionsCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Questions Category'), array('action' => 'delete', $questionsCategory['QuestionsCategory']['id']), null, __('Are you sure you want to delete # %s?', $questionsCategory['QuestionsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Questions Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
