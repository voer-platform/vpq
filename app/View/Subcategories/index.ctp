<div class="subcategories index">
	<h2>Bài học</h2>
	<hr/>
	<div class="row">
		<div class="col-md-12">
			<form class="form-inline" action="<?=$this->Html->url(array('controller' => 'Subcategories','action' => 'index'));?>">
				<label>Tìm kiếm </label>&nbsp;
				<select class="form-control" name="subject" id="subject">
					<option value="">Môn học</option>
					<?php foreach($subjects AS $id=>$subject){ ?>
						<option value="<?php echo $id; ?>" <?php if(isset($csubject) && $csubject==$id) echo 'selected'; ?>><?php echo $subject; ?></option>
					<?php } ?>
				</select>
				
				<select class="form-control" name="grade" id="grade">
					<option value="">Lớp</option>
					<?php foreach($grades AS $id=>$grade){ ?>
						<option value="<?php echo $id; ?>" <?php if(isset($cgrade) && $cgrade==$id) echo 'selected'; ?>><?php echo $grade; ?></option>
					<?php } ?>
				</select>
				
				<select class="form-control w-200 sl2" name="category" id="category">
					<option value="">Chương</option>
					<?php if(isset($cCategories) && !empty($cCategories)){ ?>
						<?php foreach($cCategories AS $category){ ?>
							<option value="<?php echo $category['Category']['id']; ?>" <?php if(isset($ccategory) && $ccategory==$category['Category']['id']) echo 'selected'; ?>><?php echo $category['Category']['name']; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
			
				<button type="submit" class="btn btn-primary" name="search" value="true">Tìm kiếm</button>
				<a href="<?php echo $this->Html->url(array('controller'=>'Subcategories')); ?>" class="btn btn-default">Xóa lọc</a>
			</form>
		</div>	
	</div>	
	<hr/>
	<table class="table table-stripped table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('number_question'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($subcategories as $subcategory): ?>
	<tr>
		<td><?php echo h($subcategory['Subcategory']['id']); ?>&nbsp;</td>
		<td><?php echo h($subcategory['Subcategory']['name']); ?>&nbsp;</td>
		<td>
			<?php echo h($subcategory['Subcategory']['number_question']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $subcategory['Subcategory']['id']), array('class'=>'btn btn-default btn-xs')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $subcategory['Subcategory']['id']), array('class'=>'btn btn-default btn-xs')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $subcategory['Subcategory']['id']), array('class'=>'btn btn-danger btn-xs'), __('Are you sure you want to delete # %s?', $subcategory['Subcategory']['id'])); ?>
		</td>
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
		echo $this->Paginator->prev('< ' . __('previous'), array('tag'=>'li'), null, array('tag'=>'li', 'class' => 'disabled', 'disabledTag'=>'a'));
		echo $this->Paginator->numbers(array('separator' => '', 'tag'=>'li', 'currentClass' => 'active', 'currentTag' => 'a'));
		echo $this->Paginator->next(__('next') . ' >', array('tag'=>'li'), null, array('tag'=>'li', 'class' => 'disabled', 'disabledTag'=>'a'));
	?>
	</ul>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Subcategory'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Grades'), array('controller' => 'grades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grade'), array('controller' => 'grades', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
