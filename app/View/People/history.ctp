<div class='container'>

	<h2><?php echo __('Your tests history'); ?></h2>
	<table class = 'table table-striped table-condensed table-hover table-bordered'>
	<?php
		if( !empty($scores) ){
			echo $this->Html->tableHeaders(array(__('Test ID'), __('Time taken'), __('Time limit'),__('Score')));
			foreach($scores as $score){
				echo $this->Html->tableCells(array(
					$score['Score']['test_id'],
					$score['Score']['time_taken'],
					$score['Test']['time_limit'].' '.__('mins'),
					(round($score['Score']['score']/$score['Test']['number_questions'], 2)*100).'%'
					));
			}
		}
		else{
			echo __('Oops... It looks like you have no history....'), '<br>';
		}
	?>
	</table>

</div>