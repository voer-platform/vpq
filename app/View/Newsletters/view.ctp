<div class="newsletters view">
<h2><?php echo __('Newsletter'); ?></h2>
	<p><?php echo __('Id'); ?>: <?php echo h($newsletter['Newsletter']['id']); ?>, <?php echo __('Newsletter Category'); ?>: <?php echo $this->Html->link($newsletter['NewsletterCategory']['name'], array('controller' => 'newsletter_categories', 'action' => 'view', $newsletter['NewsletterCategory']['id'])); ?></p>
	<h4><?php echo __('Title'); ?>: <?php echo h($newsletter['Newsletter']['title']); ?></h4>
	<hr/>
	<p><?php echo __('Content'); ?></p>
	<div class="well">
		<?php echo $newsletter['Newsletter']['content']; ?>
	</div>	
	<hr/>
	<p>
		<?php echo __('Created'); ?>: <?php echo h($newsletter['Newsletter']['created']); ?>,
		<?php echo __('Modified'); ?>: <?php echo h($newsletter['Newsletter']['modified']); ?>
	</p>	
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
