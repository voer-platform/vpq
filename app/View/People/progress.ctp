<div class='container'>

	<h2>Your performance</h2>
	<table class = 'table table-striped table-condensed table-hover table-bordered'>
	<?php
		if( !empty($progresses) ){
			echo $this->Html->tableHeaders(array('SubCategory', 'Progress', 'Date'));
			foreach($progresses as $progress){
				echo $this->Html->tableCells(array(
					$progress['SubCategory']['name'],
					round($progress['Progress']['progress'] / $progress['Progress']['total']*100, 2).'%',
					$progress['Progress']['date']	
					));
			}
		}
		else{
			echo 'Oops... It looks like you have no progresses at all....', '<br>';
		}
	?>
	</table>

</div>