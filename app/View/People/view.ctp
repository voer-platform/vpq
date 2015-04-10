<h2 class="page-heading heading"><?php echo __('Personal Page'); ?></h2>
<div class="row">
	<div class="col-md-12">
		<div class="personal-page-header clearfix">
			<div class="pull-left clearfix">
				<div class="avatar pull-left">
					<img src="<?php echo $person['Person']['image']; ?>" width="200px" height="200px">
				</div>
				<div class="user-info pull-right">
					<h3><?php echo h($person['Person']['fullname']); ?></h3>
					<p><span class="glyphicon glyphicon-gift"></span>&nbsp; <?php echo __('Birthday:'); ?> <?php echo h($person['Person']['birthday']); ?></p>
					<p><span class="glyphicon glyphicon-education"></span>&nbsp; <?php echo __('Student:'); ?> <?php echo h($person['Person']['grade']); ?><?php if($person['Person']['school']){ echo ', '.h($person['Person']['school']); } ?></p>
					<p><span class="glyphicon glyphicon-home"></span>&nbsp; <?php echo __('Address:'); ?> <?php echo h($person['Person']['address']); ?></p>
					<button class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-cog"></span> Chỉnh sửa thông tin cá nhân</button></a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog w-450">
		<form method="POST" action="<?php echo $this->Html->url(array('controller'=>'people', 'action'=>'update')); ?>">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-pencil"></span> Chỉnh sửa thông tin cá nhân</h4>
			</div>
			<div class="modal-body">
					<div class="form-group">
						<label class="form-label">Họ tên</label>
						<input type="text" class="form-control" name="fullname" value="<?php echo h($person['Person']['fullname']); ?>" />
					</div>
					<div class="form-group">
						<label class="form-label">Ngày sinh</label>
						<input type="text" class="form-control" name="birthday" value="<?php echo h($person['Person']['birthday']); ?>" />
					</div>
					<div class="form-group">
						<label class="form-label">Đang là</label>
						<select name="grade" class="form-control">
							<?php foreach($grades AS $grade){ ?>
								<option value="<?php echo $grade; ?>" <?php if($person['Person']['grade']==$grade) echo 'selected'; ?>>Học sinh lớp <?php echo $grade; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label class="form-label">Tại trường</label>
						<input type="text" class="form-control" name="school" value="<?php echo h($person['Person']['school']); ?>" placeholder="Tên trường học của bạn" />
					</div>
					<div class="form-group">
						<label class="form-label">Địa chỉ</label>
						<input type="text" name="address" class="form-control" placeholder="Nơi bạn đang sống" value="<?php echo h($person['Person']['address']); ?>">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" name="update_profile" value="update_profile" class="btn btn-primary"><?php echo __('Update'); ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
			</div>
		</div>
		</form>
	</div>
</div>
<!--<div class="people view">
<h2></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($person['Person']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($person['Person']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($person['Person']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Grade'); ?></dt>
		<dd>
			<?php echo h($person['Person']['grade']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Birthday'); ?></dt>
		<dd>
			<?php echo h($person['Person']['birthday']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Created'); ?></dt>
		<dd>
			<?php echo h($person['Person']['date_created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Role'); ?></dt>
		<dd>
			<?php echo h($person['Person']['role']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Facebook'); ?></dt>
		<dd>
			<?php echo h($person['Person']['facebook']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Person'), array('action' => 'edit', $person['Person']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Person'), array('action' => 'delete', $person['Person']['id']), null, __('Are you sure you want to delete # %s?', $person['Person']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List People'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Person'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Progresses'), array('controller' => 'progresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Progress'), array('controller' => 'progresses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Scores'), array('controller' => 'scores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Score'), array('controller' => 'scores', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Progresses'); ?></h3>
	<?php if (!empty($person['Progress'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Person Id'); ?></th>
		<th><?php echo __('Sub Category Id'); ?></th>
		<th><?php echo __('Progress'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($person['Progress'] as $progress): ?>
		<tr>
			<td><?php echo $progress['person_id']; ?></td>
			<td><?php echo $progress['sub_category_id']; ?></td>
			<td><?php echo $progress['progress']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'progresses', 'action' => 'view', $progress['person_id'],$progress['sub_category_id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'progresses', 'action' => 'edit', $progress['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'progresses', 'action' => 'delete', $progress['id']), null, __('Are you sure you want to delete # %s?', $progress['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Progress'), array('controller' => 'progresses', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Scores'); ?></h3>
	<?php if (!empty($person['Score'])): ?>
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
	<?php foreach ($person['Score'] as $score): ?>
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
-->