<div class="tests index">
	
	
	
	<h2><?php echo __('Tests'); ?></h2>
	<hr/>
	<table class="table table-striped table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
			<th><?php echo $this->Paginator->sort('Subject.id', __('Subject')); ?></th>
			<th><?php echo $this->Paginator->sort('Person.id', __('Person')); ?></th>
			<th><?php echo $this->Paginator->sort('Score.score', __('Score')); ?></th>
			<th><?php echo $this->Paginator->sort('time_limit'); ?></th>
			<th><?php echo $this->Paginator->sort('Score.duration', 'Test time'); ?></th>
			<th><?php echo $this->Paginator->sort('number_questions'); ?></th>
			<th><?php echo $this->Paginator->sort('Score.time_taken', 'Date'); ?></th>
	</tr>
	<?php foreach ($tests as $test): ?>
	<tr>
		<td><?php echo h($test['Test']['id']); ?></td>
		<td><?php echo h($test['Subject']['name']); ?></td>
		<td><?php echo h($test['Person']['fullname']); ?></td>
		<td><?php echo round(($test['Score']['score']/$test['Test']['number_questions'])*10, 1); ?></td>
		<td><?php echo h($test['Test']['time_limit']); ?> phút</td>
		<td><?php echo gmdate('H:i:s', $test['Score']['duration']); ?></td>
		<td><?php echo h($test['Test']['number_questions']); ?></td>
		<td><?php echo h($test['Score']['time_taken']); ?></td>
	</tr>
<?php endforeach; ?>
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

