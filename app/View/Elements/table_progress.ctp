<table class = 'table table-striped table-condensed table-hover table-bordered'>
<?php
    if( !empty($progresses) ){
        echo $this->Html->tableHeaders(array(__('Name'), __('Score'), __('Correct'), __('Wrong'), __('Total'), __('Rank'), __('Last tried')));
        foreach($progresses as $progress){
            $score = round($progress['0']['progress']/$progress['0']['total']*100,0);
            echo $this->Html->tableCells(array(
                $this->Html->link($progress['Subcategory']['name'], array('controller' => 'Subcategories', 'action' => 'viewScoresSubcategory', $progress['Subcategory']['id'])),
                "<span title='".__('Score based on latest 10 tests on the subject')."'>".$score.'/100'."</span>",
                $progress['0']['progress'],
                $progress['0']['total'] - $progress['0']['progress'],
                $progress['0']['total'],
                "<span class = 'label label-".$this->Name->determineRank($score)["color"]."'>".$this->Name->determineRank($score)["rank"]."</span>",
                $progress['Progress']['date']   
                ));
        }
    }
    else{
        echo __('Oops... It looks like you have no progresses at all....'), '<br>';
    }
?>
</table>