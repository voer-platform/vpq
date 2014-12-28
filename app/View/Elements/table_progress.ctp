<table class = 'table table-striped table-condensed table-hover table-bordered'>
<?php
    if( !empty($progresses) ){
        echo $this->Html->tableHeaders(array(__('Subcategory'), __('Score'), __('Correct'), __('Wrong'), __('Total'), __('Rank'), __('Last tried')));
        foreach($progresses as $progress){
            $score = round($progress['0']['progress']/$progress['0']['total']*100,0);
            echo $this->Html->tableCells(array(
                $this->Html->link($progress['Subcategory']['name'], array('controller' => 'Subcategories', 'action' => 'viewScoresSubcategory', $progress['Subcategory']['id'])),
                $score,
                $progress['0']['progress'],
                $progress['0']['total'] - $progress['0']['progress'],
                $progress['0']['total'],
                $this->Name->determineRank($score),
                $progress['Progress']['date']   
                ));
        }
    }
    else{
        echo __('Oops... It looks like you have no progresses at all....'), '<br>';
    }
?>
</table>