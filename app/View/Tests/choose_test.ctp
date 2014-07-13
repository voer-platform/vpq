<div class="chooseTest">
	<p><?php echo '<b>'.__('Type: '). '</b>' . ucfirst($category) ?></p>
	<h2><?php echo 'Choose your test duration' ?></h2>
	<?php echo $this->Form->create('Test', array('url' => 'doTest')); ?>
		<fieldset>
		<?php
			$timeOptions = array(5,10,15,30,60);
			echo $this->Form->input('time_limit', array(
					'label' => 'Time limit(in minutes)',
					'legend' => false,
					'type' => 'radio',
					'separator' => '</br>',
					'options' => array_combine($timeOptions, $timeOptions)
				)
			);
			/**
			 * depreceated, user only choose for time
			 */
			// echo $this->Form->input('number_of_questions',array(
			// 		'label' => 'Number of questions',
			// 		'type' => 'select',
			// 		'options' => array_combine($questionOptions, $questionOptions)
			// 	)
			// );
		?>
		</fieldset>
	<?php echo $this->Form->end(array('label' => __('Start'), 'class' => 'btn btn-lg btn-success')); ?>
</div>
