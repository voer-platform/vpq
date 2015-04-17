
<div class="row">
	<div class="col-md-8">
		<h2><?php echo __('Ranking'); ?></h2>
	</div>
	<div class="col-md-4">
	<h2 class="right">
		<div class="form-inline">
			<select class="form-control w-200 inline" onChange="window.location.href='<?php echo $this->Html->url(array('controller'=>'admin', 'action'=>'ranking')); ?>'+this.value;">
				<option value="">Tất cả môn học</option>
				<?php foreach($subjects AS $subject_id=>$subject){ ?>
					<option value="/subject:<?php echo $subject_id; ?>" <?php if(isset($current_subject) && $subject_id==$current_subject) echo 'selected'; ?>><?php echo $subject; ?></option>
				<?php } ?>
			</select>
			<a class="btn btn-danger" href="<?php echo $this->Html->url(array('controller'=>'admin', 'action'=>'rebuildRanking')); ?>" onClick="return confirm('<?php echo __('Are you sure?'); ?>');"><?php echo __('Rebuild data'); ?></a>
		</div>	
	</h2>	
	</div>	
</div>
<br/>
<table class="table table-striped table table-bordered">
	<thead>
		<th><?php echo $this->Paginator->sort('person_id', 'ID'); ?></th>
		<th><?php echo $this->Paginator->sort('Person.fullname', __('Name')); ?></th>
		<th><?php echo $this->Paginator->sort('Person.gender', __('Gender')); ?></th>
		<th><?php echo $this->Paginator->sort('Person.grade', __('Grade')); ?></th>
		<th><?php echo $this->Paginator->sort('Person.school', __('School')); ?></th>
		<th><?php echo $this->Paginator->sort('Subject.id', __('Subject')); ?></th>
		<th><?php echo $this->Paginator->sort('score'); ?></th>
	</thead>
	<tbody>
		<?php foreach($rankings AS $score){ ?>
			<tr>
				<td><?php echo $score['Ranking']['person_id']; ?></td>
				<td><?php echo $score['Person']['fullname']; ?></td>
				<td><?php echo ($score['Person']['gender'])?'Nam':'Nữ'; ?></td>
				<td><?php echo $score['Person']['grade']; ?></td>
				<td><?php echo $score['Person']['school']; ?></td>
				<td><?php echo $score['Subject']['name']; ?></td>
				<td><?php echo $score['Ranking']['score']; ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>