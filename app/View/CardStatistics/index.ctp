<h2><span class="glyphicon glyphicon-stats"></span> <?php echo _('Card Logs'); ?></h2>
<hr/>
<form class="form-inline">
	<input type="text" class="form-control hasDatepick" name="from" placeholder="Từ ngày" <?php if(isset($from)) echo "value='$from'"; ?> />&nbsp;
	<input type="text" class="form-control hasDatepick" name="to" placeholder="Đến ngày" <?php if(isset($to)) echo "value='$to'"; ?> />&nbsp;
	<select name="card_type" class="form-control">
		<option value="">Loại thẻ</option>
		<?php foreach($cardtypes AS $id=>$types){ ?>
			<option value="<?php echo $id; ?>" <?php if(isset($card_type) && $card_type==$id) echo 'selected'; ?>><?php echo $types; ?></option>
		<?php } ?>
	</select>&nbsp;
	<select name="price" class="form-control">
		<option value="">Mệnh giá</option>
		<?php foreach($exchanges AS $price){ ?>
			<option value="<?php echo $price['ExchangeRate']['price']; ?>" <?php if(isset($cprice) && $cprice==$price['ExchangeRate']['price']) echo 'selected'; ?>><?php echo $price['ExchangeRate']['price']; ?></option>
		<?php } ?>
	</select>&nbsp;
	<button type="submit" name="filter" class="btn btn-primary" value="true">Xem</button>
	&nbsp;
	<a href="<?php echo $this->Html->url(array('controller'=>'cardStatistics')); ?>" class="btn btn-default">Xóa lọc</a>
</form>
<hr/>
<table class="table table-stripped table-bordered">
	<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('transref'); ?></th>
			<th><?php echo $this->Paginator->sort('Person.id', 'Person'); ?></th>
			<th><?php echo $this->Paginator->sort('CardType.id', 'Card Type'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th><?php echo $this->Paginator->sort('coin'); ?></th>
			<th><?php echo $this->Paginator->sort('Promotional.percent'); ?></th>
			<th><?php echo $this->Paginator->sort('card_code'); ?></th>
			<th><?php echo $this->Paginator->sort('card_serie'); ?></th>
			<th><?php echo $this->Paginator->sort('time'); ?></th>
		</tr>
		<?php foreach($statistics AS $card){ ?>
			<tr>
				<td><?php echo $card['RechargeLog']['transref']; ?></td>
				<td><?php echo $card['Person']['fullname']; ?></td>
				<td><?php echo $card['CardType']['name']; ?></td>
				<td><?php echo $card['RechargeLog']['price']; ?></td>
				<td><?php echo $card['RechargeLog']['coin']; ?></td>
				<td><?php echo ($card['Promotional']['percent'])?$card['Promotional']['percent'].'%':''; ?></td>
				<td><?php echo $card['RechargeLog']['card_code']; ?></td>
				<td><?php echo $card['RechargeLog']['card_serie']; ?></td>
				<td><?php echo date('d/m/Y h:i:s', strtotime($card['RechargeLog']['time'])); ?></td>
			</tr>
		<?php } ?>
	</thead>
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
<script>
	$('.hasDatepick').datepicker({format: "dd/mm/yyyy"}).on('changeDate', function(ev) {
		$(this).datepicker('hide');
	});
</script>