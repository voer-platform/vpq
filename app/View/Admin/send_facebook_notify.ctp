<h2>Gửi thông báo tới Facebook</h2>
<hr/>

<div class="row">
	
	<div class="col-md-12">
		<form action="<?=$this->Html->url(array("controller" => "Admin/sendFacebookNotify"));?>">
			Đã gửi tin cách đây > <input type="text" class="form-control inline w-50" value="<?=$lastsend;?>" name="lastsend" /> ngày &nbsp;|&nbsp; đã tham gia < <input type="text" class="form-control inline w-50" value="<?=$maxjoindate;?>" name="maxjoindate" /> ngày &nbsp;|&nbsp; Kiểm tra lần cuối từ <input type="text" class="form-control inline w-50" value="<?=$minlasttest;?>" name="minlasttest" /> đến <input type="text" class="form-control inline w-50" value="<?=$maxlasttest;?>" name="maxlasttest" /> ngày
			&nbsp;&nbsp;&nbsp;<input type="submit" value="Lọc thành viên" class="btn btn-primary" name="filter" />
		</form>
		
		<hr/><br/>
	</div>
	<div class="col-md-6">
		<b>Danh sách thành viên được gửi thông báo</b>
	</div>
	<div class="col-md-6">	
		<form action="<?=$this->Html->url(array("controller" => "Admin/sendFacebookNotify"));?>" method="POST">
			<input type="hidden" name="minlasttest" value="<?=$minlasttest;?>" />
			<input type="hidden" name="maxlasttest" value="<?=$maxlasttest;?>" />
			<input type="hidden" name="maxjoindate" value="<?=$maxjoindate;?>" />
			<input type="hidden" name="lastsend" value="<?=$lastsend;?>" />
			
			
			<input type="submit" name="send_notify" value="Gửi thông báo" class="btn btn-danger pull-right" />
			
			<select class="form-control pull-right inline w-200 mglr-10" name="type">
				<option value="3">Thông báo sự kiện tháng 10</option>
				<option value="1">Gửi nhắc nhở học tập</option>
			</select>
			
		</form>	
	</div>
</div>
<br/>
</form>
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