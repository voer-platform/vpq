<table class = 'table table-striped table-condensed table-hover table-bordered'>
<?php
    if( !empty($progresses) ){
        echo $this->Html->tableHeaders(array(__('Name'), __('Score'), __('Correct'), __('Wrong'), __('Total'), __('Rank'), __('Last tried')));
        foreach($progresses as $key => $progress){
            $score = round($progress['Progress']['sum_progress']/$progress['Progress']['sum_total']*100,0);
            $name   = $this->Name->determineRank($score);
            echo $this->Html->tableCells(array(
                $progress['Subcategory']['name'],
                "<span title='".__('Score based on latest 10 tests on the subject')."'>".$score.'/100'."</span>",
                $progress['Progress']['sum_progress'],
                $progress['Progress']['sum_total'] - $progress['Progress']['sum_progress'],
                $progress['Progress']['sum_total'],
                "<span class = 'label label-".$name["color"]."' title='".$name['description']."'>".$name["rank"]."</span>",
                $progress['Progress']['date']   
                ));
        }
    }
    else{
        echo __('Oops... It looks like you have no progresses at all....'), '<br>';
    }
?>
</table>