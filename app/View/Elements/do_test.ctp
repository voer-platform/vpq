<div class='doTest'>
	<center>
	<h2><?php echo __('Do your Test')?></h2>
	</center>

	<?php echo '<b>'.__('Test').'</b>: '.$this->Name->subjectToName($subject); ?> </br>
	<?php echo ' <b>'.__('Timelimit').'</b>: '.$duration.' '.__('minutes'); ?> </br>
	<?php echo ' <b>'.__('Number of questions').'</b>: '.$numberOfQuestions; ?> </br>
	<hr>
	
	<?php echo $this->Form->create('TestAnswers', array( 'url' => 'score')); ?>
		<?php foreach ($questions as $index => $question): ?>
			<div id = 'dotestQuestions'>
				<fieldset>
					<?php echo "<b>",$index+1, "</b>  "; ?>
					<?php echo html_entity_decode($question['Question']['content']); ?>

					<!-- debug -->
					<?php echo '=='.$question['Question']['id'].'=='; ?>
					<?php foreach($question['Subcategory'] as $sub){
						echo $sub['id'].' ';
						} ?>

					<?php $option = array(); ?>
					<?php foreach ($question['Answer'] as $aindex => $answer): ?>
						<?php $option[$aindex] = $answer['content'].'--'.$answer['correctness']; ?>
					<?php endforeach; ?>
					
					<?php echo $this->Form->input( $index, array(
						'name' => $question['Question']['id'],
						'legend' => false,
						'options' => $option,
						'separator' => '</br>',
						'type' => 'radio',
						)); 
					?>
				</fieldset>
			</div>
		<?php endforeach; ?>
		<?php echo $this->Form->input( 'test_id', array(
				'name' => 'testID',
				'value' => $testID,
				'type' => 'hidden'
				));?>
		<?php echo $this->Form->input( 'number_of_questions', array(
				'name' => 'numberOfQuestions',
				'value' => $numberOfQuestions,
				'type' => 'hidden'
				));?>
		<?php echo $this->Form->input( 'duration', array(
				'name' => 'duration',
				'value' => 0,
				'type' => 'hidden'
				));?>				 
	<center>
	<?php echo $this->Form->end(array('label' => __('Submit your answers'), 'class' => 'btn btn-primary btn-lg', 'id' => 'btn-submit')); ?>
	</center>			
</div>
