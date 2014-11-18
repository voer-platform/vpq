<div class='score-view'>
	<?php foreach($scoreData as $index => $data): ?>
		<?php echo '<b>'.($index+1).'</b>'; ?>
		<?php echo $questionsData[$index]['Question']['content']; ?>
		</br>
		<div class='input radio'>
			<?php foreach($questionsData[$index]['Answer'] as $answerId => $answer): ?>
				<!-- correct answer -->
				<?php if( $answer['correctness'] == 1): ?>
					<div class='score-answer-correct'>
				<!-- else -->
				<?php else: ?>
					<div class='score-answer-normal'>
				<?php endif; ?>
				
				<!-- answer of user -->
				<?php if($data['ScoresQuestion']['answer'] == '' ): ?>
					<input type='radio' name='<?php echo $data['ScoresQuestion']['question_id']; ?>' id='<?php echo "TestAnswer".$answerId; ?>' disabled >
				<?php elseif( $data['ScoresQuestion']['answer'] == $answerId): ?>
					<input type='radio' name='<?php echo $data['ScoresQuestion']['question_id']; ?>' id='<?php echo "TestAnswer".$answerId; ?>' checked='checked' disabled >
				<!-- normal answer -->
				<?php else: ?>
					<input type='radio' name='<?php echo $data['ScoresQuestion']['question_id']; ?>' id='<?php echo "TestAnswer".$answerId; ?>' disabled >
				<?php endif; ?>
				<!-- label -->
				<label for='<?php echo "TestAnswer".$answerId; ?>'> <?php echo $answer['content']; ?></label>

				</div>
			<?php endforeach;?>
		</div>
		<?php $index++; ?>
	<?php endforeach;?>
</div>