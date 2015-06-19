<div class="newsletters index">
	<h2><?php echo __('Newsletters'); ?></h2>
	<table class="table table-bordered table-stripped">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('newsletter_category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($newsletters as $newsletter): ?>
	<tr>
		<td><?php echo h($newsletter['Newsletter']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($newsletter['NewsletterCategory']['name'], array('controller' => 'newsletter_categories', 'action' => 'view', $newsletter['NewsletterCategory']['id'])); ?>
		</td>
		<td><?php echo h($newsletter['Newsletter']['title']); ?>&nbsp;</td>
		<td><?php echo h($newsletter['Newsletter']['created']); ?>&nbsp;</td>
		<td><?php echo h($newsletter['Newsletter']['modified']); ?>&nbsp;</td>
		<td><?php echo h($newsletter['Newsletter']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $newsletter['Newsletter']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $newsletter['Newsletter']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $newsletter['Newsletter']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $newsletter['Newsletter']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Newsletter'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Newsletter Categories'), array('controller' => 'newsletter_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Newsletter Category'), array('controller' => 'newsletter_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
