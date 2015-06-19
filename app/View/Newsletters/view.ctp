<div class="newsletters view">
<h2><?php echo __('Newsletter'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Newsletter Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($newsletter['NewsletterCategory']['name'], array('controller' => 'newsletter_categories', 'action' => 'view', $newsletter['NewsletterCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['content']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($newsletter['Newsletter']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Newsletter'), array('action' => 'edit', $newsletter['Newsletter']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Newsletter'), array('action' => 'delete', $newsletter['Newsletter']['id']), array(), __('Are you sure you want to delete # %s?', $newsletter['Newsletter']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Newsletters'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Newsletter'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Newsletter Categories'), array('controller' => 'newsletter_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Newsletter Category'), array('controller' => 'newsletter_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
