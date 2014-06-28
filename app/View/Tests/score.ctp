<div id = 'score'>
	<h2><?php echo 'Your result' ?></h2>
	<?php echo 'Your score for this test:'.$finalScore.'('.$correct[0].'/'.$correct[2].' questions correct).' ?>
	<?php
		$percentage = $correct[1]==0?0:$correct[0]/$correct[1];

		if($percentage == 1.0){
			echo 'Exellent, perfect!';
		}
		else if($percentage > 0.7){
			echo 'Good job!';
		}
		else if($percentage > 0.5){
			echo 'Keep going.';
		}
		else if($percentage > 0.3){
			echo 'Try harder.';
		}
		else{
			echo 'Do you need a tutor?';
		}
	?>
</div>