<div class="faqs index">
	<h2><?php echo __('Faqs'); ?></h2>
	<table cellpadding="0" cellspacing="0" class="table table-striped table-condensed table-hover table-bordered">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('content'); ?></th>
			<th><?php echo $this->Paginator->sort('person_id'); ?></th>
			<th><?php echo $this->Paginator->sort('answer'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('date_created'); ?></th>
			<th><?php echo $this->Paginator->sort('date_answered'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($faqs as $faq): ?>
	<tr>
		<td><?php echo h($faq['Faq']['id']); ?>&nbsp;</td>
		<td><?php echo h($faq['Faq']['content']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($faq['Person']['first_name'].' '.$faq['Person']['last_name'], array('controller' => 'people', 'action' => 'view', $faq['Person']['id'])); ?>
		</td>
		<td><?php echo h($faq['Faq']['answer']); ?>&nbsp;</td>
		<td><?php echo h($faq['Faq']['status']); ?>&nbsp;</br><?php echo $this->Html->link(__('Answer FAQ'), array('action' => 'edit', $faq['Faq']['id']), array('class' => 'btn btn-sm btn-primary')); ?></td>
		<td><?php echo h($faq['Faq']['date_created']); ?>&nbsp;</td>
		<td><?php echo h($faq['Faq']['date_answered']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $faq['Faq']['id']), array('class' => 'btn btn-sm btn-success')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $faq['Faq']['id']), array('class' => 'btn btn-sm btn-danger'), __('Are you sure you want to delete # %s?', $faq['Faq']['id'])); ?>
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
		echo $this->Paginator->prev('< ' . __('previous'), array('tag'=>'li'), null, array('class' => 'disabled', 'disabledTag'=>'a'));
		echo $this->Paginator->numbers(array('separator' => '', 'tag'=>'li', 'currentClass' => 'active', 'currentTag' => 'a'));
		echo $this->Paginator->next(__('next') . ' >', array('tag'=>'li'), null, array('class' => 'disabled', 'disabledTag'=>'a'));
	?>
	</ul>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Faq'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List People'), array('controller' => 'people', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Person'), array('controller' => 'people', 'action' => 'add')); ?> </li>
	</ul>
</div>
