<div class="questionsSubcategories view">
<h2><?php echo __('Questions Subcategory'); ?></h2>
	<dl>
		<dt><?php echo __('Question'); ?></dt>
		<dd>
			<?php echo $this->Html->link($questionsSubcategory['Question']['id'], array('controller' => 'questions', 'action' => 'view', $questionsSubcategory['Question']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subcategory'); ?></dt>
		<dd>
			<?php echo $this->Html->link($questionsSubcategory['Subcategory']['name'], array('controller' => 'subcategories', 'action' => 'view', $questionsSubcategory['Subcategory']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Questions Subcategory'), array('action' => 'edit', $questionsSubcategory['QuestionsSubcategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Questions Subcategory'), array('action' => 'delete', $questionsSubcategory['QuestionsSubcategory']['id']), null, __('Are you sure you want to delete # %s?', $questionsSubcategory['QuestionsSubcategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions Subcategories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Questions Subcategory'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Subcategories'), array('controller' => 'subcategories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subcategory'), array('controller' => 'subcategories', 'action' => 'add')); ?> </li>
	</ul>
</div>
