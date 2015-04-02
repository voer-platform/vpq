<div class='col-sm-6'>
	<table class="table table-striped table table-bordered">
		<?php
			if( !empty($scores) ){
				echo $this->Html->tableHeaders(array( __('Time taken'), __('Time limit'),__('Score')));
				foreach($scores as $score){
					echo $this->Html->tableCells(array(
						$this->Html->link(date('D, d-m-y', strtotime($score['Score']['time_taken'])), array('controller' => 'scores', 'action' => 'viewDetails', $score['Score']['id'])),
						$score['Test']['time_limit'].' '.__('mins'),
						$score['Test']['number_questions'] != 0? round($score['Score']['score']/$score['Test']['number_questions'], 2)*10 : 0
						));
				}
			}
			else{
				echo __('Oops... It looks like you have no scores on this....'), '<br>';
			}
		?>
	</table>
</div>