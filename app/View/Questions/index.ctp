<div class="questions index">
	<h2><?php echo __('Questions'); ?></h2>
	<hr/>
	<div class="row">
		<div class="col-md-12">
			<form class="form-inline">
				<label>Tìm kiếm </label>&nbsp;
				<input type="text" class="form-control" name="keyword" placeholder="Từ khóa trong nội dung" <?php if(isset($ckeyword) && $ckeyword!='') echo "value='$ckeyword'"; ?> />&nbsp;
				
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
				
				<select class="form-control w-200 sl2" name="subcategory" id="subcategory">
					<option value="">Bài</option>
					<?php if(isset($cSubcategories) && !empty($cSubcategories)){ ?>
						<?php foreach($cSubcategories AS $subcategory){ ?>
							<option value="<?php echo $subcategory['Subcategory']['id']; ?>" <?php if(isset($csubcategory) && $csubcategory==$subcategory['Subcategory']['id']) echo 'selected'; ?>><?php echo $subcategory['Subcategory']['name']; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
			
				<button type="submit" class="btn btn-primary" name="search" value="true">Tìm kiếm</button>
				<a href="<?php echo $this->Html->url(array('controller'=>'Questions')); ?>" class="btn btn-default">Xóa lọc</a>
			</form>
		</div>	
	</div>	
	<hr/>
	<table cellpadding="0" cellspacing="0" class="table table-striped table table-bordered">
	<thead>
	<tr>
			<th class="center"><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('content'); ?></th>
			<th class="center"><?php echo $this->Paginator->sort('count', __('Total')); ?></th>
			<th class="center"><?php echo $this->Paginator->sort('wrong'); ?></th>
			<th class="center"><?php echo $this->Paginator->sort('_difficulty', 'difficulty'); ?></th>
			<th class="center"><?php echo $this->Paginator->sort('time', 'Total time'); ?></th>
			<th class="center"><?php echo $this->Paginator->sort('_averange_time', 'Average time'); ?></th>
			<th class="actions center"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($questions as $question): ?>
	<tr>
		<td class="center"><?php echo h($question['Question']['id']); ?>&nbsp;</td>
		<td width="500"><?php echo html_entity_decode($question['Question']['content']); ?>&nbsp;</td>
		<td class="center"><?php echo $question['Question']['count']; ?></td>
		<td class="center"><?php echo $question['Question']['wrong']; ?></td>
		<td class="center"><?php echo ($question['Question']['count']>0)?$question['Question']['_difficulty']:'0'; ?></td>
		<td class="center"><?php echo $question['Question']['time']; ?></td>
		<td class="center"><?php echo ($question['Question']['count']>0)?$question['Question']['_averange_time']:'0'; ?></td>
		<td class="actions center">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $question['Question']['id']), array('class'=>'btn btn-default btn-xs')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $question['Question']['id']), array('class'=>'btn btn-default btn-xs')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $question['Question']['id']), array('class'=>'btn btn-danger btn-xs'), __('Are you sure you want to delete # %s?', $question['Question']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Question'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Answers'), array('controller' => 'answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Subcategories'), array('controller' => 'subcategories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subcategory'), array('controller' => 'subcategories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tests'), array('controller' => 'tests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Test'), array('controller' => 'tests', 'action' => 'add')); ?> </li>
	</ul>
</div>
<script>
	$('.sl2').select2();
	$('#subject, #grade').change(function(){
		if($(this).attr('id')=='grade' || $('#grade').val()!='')
		{
			handle_url = '<?php echo $this->Html->url(array('controller'=>'Categories', 'action' => 'byGrade')); ?>/'+$(this).val()+'/'+$('#subject').val();
		}
		else
		{
			handle_url = '<?php echo $this->Html->url(array('controller'=>'Categories', 'action' => 'bySubject')); ?>/'+$(this).val();
		}
		$.ajax({
			type: 'GET',
			url: handle_url,
			success: function(response)
			{
				response = JSON.parse(response);
				categoryOptions = '<option value="">Chọn chương</option>';
				
				$.each(response, function(key, obj){
					categoryOptions+='<option value="'+obj.Category.id+'">'+obj.Category.name+'</option>';
				});
				$('#category').select2('destroy');
				$('#category').html(categoryOptions);
				$('#category').select2();
				$('#category').trigger('change');
			}
		});
	});
	$('#category').change(function(){
		catID = $(this).val();
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->Html->url(array('controller'=>'Subcategories', 'action' => 'get_subcategories')); ?>/'+catID,
			success: function(response)
			{
				response = JSON.parse(response);
				subcategoryOptions = '<option value="">Chọn bài</option>';
				$.each(response, function(key, obj){
					subcategoryOptions+='<option value="'+obj.Subcategory.id+'">'+obj.Subcategory.name+'</option>';
				});
				$('#subcategory').select2('destroy');
				$('#subcategory').html(subcategoryOptions);
				$('#subcategory').select2();
			}
		});
	});
</script>