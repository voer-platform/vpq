<?php echo $this->Html->css('score'); ?>
<ol class="breadcrumb">
  <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php echo __('View Score'); ?></li>
</ol>

<div id = 'score'>
	<center>
	<h2><?php echo __('Your result'); ?></h2>

	<div class='score-result'>
	<?php echo __('Your score for this test:'); ?>
	<span id='result'>
		<?php echo $correct.'/'.$numberOfQuestions; ?>
	</span>
	<?php echo __('questions correct.'); ?>
	
	<?php
		$percentage = $numberOfQuestions==0?0:$correct/$numberOfQuestions;

		if($percentage == 1.0){
			echo __('Exellent, perfect!');
		}
		else if($percentage > 0.7){
			echo __('Good job!');
		}
		else if($percentage > 0.5){
			echo __('Keep going.');
		}
		else if($percentage > 0.3){
			echo __('Try harder.');
		}
		else{
			echo __('Do you need a tutor?');
		}
	?>
	</div>
	</center>
	</br>
	<center>
	<?php echo $this->Html->link(__('Return to Dashboard'), array('controller' => 'people', 'action' => 'dashboard'), array('class' => 'btn btn-primary btn-md') ); ?>
	</center>
	<hr>

	<center>
	<h2><?php echo __('Details'); ?></h2>
	</center>
	
	<?php echo $this->element('score_view'); ?>
	<hr>
	<center>
	<?php echo $this->Html->link(__('Return to Dashboard'), array('controller' => 'people', 'action' => 'dashboard'), array('class' => 'btn btn-primary btn-md') ); ?>
	</center>
</div>