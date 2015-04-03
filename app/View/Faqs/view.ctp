<div class="faqs view">
<h2><?php echo __('Faq'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($faq['Faq']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo h($faq['Faq']['content']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Person'); ?></dt>
		<dd>
			<?php echo $this->Html->link($faq['Person']['id'], array('controller' => 'people', 'action' => 'view', $faq['Person']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Answer'); ?></dt>
		<dd>
			<?php echo h($faq['Faq']['answer']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($faq['Faq']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Created'); ?></dt>
		<dd>
			<?php echo h($faq['Faq']['date_created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Answered'); ?></dt>
		<dd>
			<?php echo h($faq['Faq']['date_answered']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Faq'), array('action' => 'edit', $faq['Faq']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Faq'), array('action' => 'delete', $faq['Faq']['id']), array(), __('Are you sure you want to delete # %s?', $faq['Faq']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Faqs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Faq'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List People'), array('controller' => 'people', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Person'), array('controller' => 'people', 'action' => 'add')); ?> </li>
	</ul>
</div>
