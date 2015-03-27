<?php 

App::uses('AppHelper', 'View/Helper');
App::import('Model', 'Subject');
App::import('Model', 'Subcategory');
App::import('Model', 'Grade');

class NameHelper extends AppHelper {
    /**
     * subject id to name
     * @param id of the subject
     * @return string reperesent name of subject
     */ 
    public function subjectToName($subject_id) {
        $Subject = new Subject();

        $subject = $Subject->find('first', array(
            'conditions' => array('Subject.id' => $subject_id)
            ));
        if($subject){
            return $subject['Subject']['name'];    
        }
        else{
            return '';
        }
    }

    /**
     * subcategory id to name
     * @param id of the subcategory
     * @return string reperesent name of subcategory
     */ 
    public function subcategoryToName($subcategory_id) {
        $Subcategory = new Subcategory();

        $subcategory = $Subcategory->find('first', array(
            'conditions' => array('Subcategory.id' => $subcategory_id)
            ));
        return $subcategory['Subcategory']['name'];
    }
    /**
     * grade id to name
     * @param id of the rade
     * @return string reperesent name of grade
     */ 
    public function gradeToName($grade_id){
        if($grade_id == 0) return __('All Grade');
        $Grade = new Grade();

        $grade = $Grade->find('first', array(
            'conditions' => array('Grade.id' => $grade_id)
            ));
        return __('Grade').' '.$grade['Grade']['name'];
    }

    /**
     * determine rank
     * @param score
     * @return rank in string
     */ 
    public function determineRank($score){
        if(9 <= $score && $score <= 10){
            return array(
                "color" => "danger",
                "rank" => __("Excellent"),
                "description" => __("Score from")." 9/10 ".__("to")." 10/10"
            );
        }
        else if( 8 <= $score && $score < 9){
            return array(
                "color" => "warning",
                "rank" => __("Good"),
                "description" => __("Score from")." 8/10 ".__("to")." 9/10"
            );
        }
        else if(6.5 <= $score && $score < 8){
            return array(
                "color" => "success",
                "rank" => __("Fair"),
                "description" => __("Score from")." 6.5/10 ".__("to")." 8/10"
            );
        }
        else if(5 <= $score && $score < 6.5){
            return array(
                "color" => "info",
                "rank" => __("Bad"),
                "description" => __("Score from")." 6.5/10 ".__("to")." 5/10"
            );
        }
        else if(3.5 <= $score && $score < 5){
            return array(
                "color" => "primary",
                "rank" => __("Very bad"),
                "description" => __("Score from")." 3.5/10 ".__("to")." 5/10"
            );
        }
        else if (0 <= $score && $score < 3.5){
            return array(
                "color" => "default",
                "rank" => __("Failed"),
                "description" => __("Score from")." 0/10 ".__("to")." 3.5/10"
            );
        }
        else {
            return array(
                "color" => "default",
                "rank" => '',
                "description" => __("Score from")." ... ".__("to")." ..."
            );
        }
    }
}