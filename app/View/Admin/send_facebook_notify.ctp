<h2>Gửi thông báo tới Facebook</h2>
<hr/>
<div class="row">
	<div class="col-md-6">
		<b>Danh sách thành viên được gửi thông báo</b>
	</div>
	<div class="col-md-6">	
		<form action="" method="POST"><input type="submit" name="send_notify" value="Gửi thông báo" class="btn btn-danger pull-right" /></form>
	</div>
</div>
<br/>
<table class="table table-tripped table-bordered">
	<tr>
		<th>ID</th>
		<th>Username</th>
		<th>Facebook</th>
		<th>Đã tham gia</th>
		<th>Lần kiểm tra cuối</th>
		<th>Đã gửi</th>
		<th>Lần gửi cuối</th>
	</tr>
	<?php foreach($users AS $user){ ?>
	<tr>
		<td><?=$user['people']['id'];?></td>
		<td><?=$user['people']['fullname'];?></td>
		<td><a target="blank" href="http://facebook.com/<?=$user['people']['facebook'];?>">Xem</a></td>
		<td><?=$user[0]['joindate'];?> ngày</td>
		<td><?=(!empty($user[0]['lasttest']))?$user[0]['lasttest'].' ngày':'Chưa có';?> </td>
		<td><?=($user['fnp']['ttfn'])?$user['fnp']['ttfn']:0;?> tin</td>
		<td><?=(!empty($user['fnp']['lastsend']))?$user['fnp']['lastsend'].' ngày':'Chưa gửi';?></td>
	</tr>
	<?php } ?>
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
</p>	