<div class="chooseTest">
	<h2><?php echo 'Choose your test type' ?></h2>
	<?php echo $this->Form->create('Test', array('url' => 'doTest')); ?>
		<fieldset>
		<?php

			$timeOptions = array(5,10,15,30,60);
			$questionOptions = array(5,10,15,20,30,60);
			echo $this->Form->input('time_limit', array(
					'label' => 'Time limit(in minutes)',
					'type' => 'select',
					'options' => array_combine($timeOptions,$timeOptions)
				)
			);
			echo $this->Form->input('number_of_questions',array(
					'label' => 'Number of questions',
					'type' => 'select',
					'options' => array_combine($questionOptions, $questionOptions)
				)
			);
		?>
		</fieldset>
	<?php echo $this->Form->end(__('Start')); ?>
</div>
