<div class='container'>

	<h2><?php echo __('Your performance'); ?></h2>
	<table class = 'table table-striped table-condensed table-hover table-bordered'>
	<?php
		if( !empty($progresses) ){
			echo $this->Html->tableHeaders(array(__('Subcategory'), __('Progress'), __('Date')));
			foreach($progresses as $progress){
				echo $this->Html->tableCells(array(
					$this->Html->link($progress['Subcategory']['name'], array('controller' => 'Subcategories', 'action' => 'viewScoresSubcategory', $progress['Subcategory']['id'])),
					round($progress['0']['progress'] / $progress['0']['total']*100, 2).'%',
					$progress['Progress']['date']	
					));
			}
		}
		else{
			echo __('Oops... It looks like you have no progresses at all....'), '<br>';
		}
	?>
	</table>

</div>