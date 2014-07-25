<?php echo $this->Html->css('choose_test.css'); ?>

<div class="chooseTest">
	<h2>Choose time for a <?php echo ucfirst($category); ?> test</h2>
	<div class='btn-groups'>
		<?php
			$times = array(5, 10, 15, 30, 60);
			foreach($times as $time){
				echo $this->Html->link($time . ' mins', array('controller' => 'Tests', 'action' => 'doTest', $time, $category), array('class' => 'btn btn btn-primary btn-lg'));
			}
		?>
	</div>
</div>
