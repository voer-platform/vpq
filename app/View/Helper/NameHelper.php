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
        if(90 <= $score && $score <= 100){
            return array(
                "color" => "danger",
                "rank" => __("Excellent"),
                "description" => __("Score from 90/100 to 100/100")
            );
        }
        else if( 80 <= $score && $score < 90){
            return array(
                "color" => "warning",
                "rank" => __("Good"),
                "description" => __("Score from 80/100 to 90/100")
            );
        }
        else if(65 <= $score && $score < 80){
            return array(
                "color" => "success",
                "rank" => __("Fair"),
                "description" => __("Score from 65/100 to 80/100")
            );
        }
        else if(50 <= $score && $score < 65){
            return array(
                "color" => "info",
                "rank" => __("Bad"),
                "description" => __("Score from 65/100 to 50/100")
            );
        }
        else if(35 <= $score && $score < 50){
            return array(
                "color" => "primary",
                "rank" => __("Very bad"),
                "description" => __("Score from 35/100 to 50/100")
            );
        }
        else{
            return array(
                "color" => "default",
                "rank" => __("Failed"),
                "description" => __("Score from 0/100 to 35/100")
            );
        }
    }
}