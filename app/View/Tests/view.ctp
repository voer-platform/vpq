<div class="tests view">
<h2><?php echo __('Test'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($test['Test']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Time Limit'); ?></dt>
		<dd>
			<?php echo h($test['Test']['time_limit']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Allow Attemps'); ?></dt>
		<dd>
			<?php echo h($test['Test']['allow_attemps']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Test'), array('action' => 'edit', $test['Test']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Test'), array('action' => 'delete', $test['Test']['id']), null, __('Are you sure you want to delete # %s?', $test['Test']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tests'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Test'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Scores'), array('controller' => 'scores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Score'), array('controller' => 'scores', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Scores'); ?></h3>
	<?php if (!empty($test['Score'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Test Id'); ?></th>
		<th><?php echo __('Person Id'); ?></th>
		<th><?php echo __('Score'); ?></th>
		<th><?php echo __('Duration'); ?></th>
		<th><?php echo __('Time Taken'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($test['Score'] as $score): ?>
		<tr>
			<td><?php echo $score['id']; ?></td>
			<td><?php echo $score['test_id']; ?></td>
			<td><?php echo $score['person_id']; ?></td>
			<td><?php echo $score['score']; ?></td>
			<td><?php echo $score['duration']; ?></td>
			<td><?php echo $score['time_taken']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'scores', 'action' => 'view', $score['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'scores', 'action' => 'edit', $score['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'scores', 'action' => 'delete', $score['id']), null, __('Are you sure you want to delete # %s?', $score['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Score'), array('controller' => 'scores', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Categories'); ?></h3>
	<?php if (!empty($test['Category'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($test['Category'] as $category): ?>
		<tr>
			<td><?php echo $category['id']; ?></td>
			<td><?php echo $category['name']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'categories', 'action' => 'view', $category['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'categories', 'action' => 'edit', $category['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'categories', 'action' => 'delete', $category['id']), null, __('Are you sure you want to delete # %s?', $category['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Questions'); ?></h3>
	<?php if (!empty($test['Question'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Content'); ?></th>
		<th><?php echo __('Difficulty'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($test['Question'] as $question): ?>
		<tr>
			<td><?php echo $question['id']; ?></td>
			<td><?php echo $question['content']; ?></td>
			<td><?php echo $question['difficulty']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'questions', 'action' => 'view', $question['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'questions', 'action' => 'edit', $question['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'questions', 'action' => 'delete', $question['id']), null, __('Are you sure you want to delete # %s?', $question['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
