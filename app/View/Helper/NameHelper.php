<?php 

App::uses('AppHelper', 'View/Helper');
App::import('Model', 'Subject');
App::import('Model', 'Subcategory');
App::import('Model', 'Grade');

class NameHelper extends AppHelper {
    /**
     * subject id"." ".__("to")." "."name
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
     * subcategory id"." ".__("to")." "."name
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
     * grade id"." ".__("to")." "."name
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
                "color" => "success",
                "rank" => __("Excellent"),
                "description" => __("Score from")." "."9/10"." ".__("to")." "."10/10"
            );
        }
        else if( 8 <= $score && $score < 9){
            return array(
                "color" => "primary",
                "rank" => __("Good"),
                "description" => __("Score from")." "."8/10"." ".__("to")." "."9/10"
            );
        }
        else if(6.5 <= $score && $score < 8){
            return array(
                "color" => "info",
                "rank" => __("Fair"),
                "description" => __("Score from")." "."6.5/10"." ".__("to")." "."8/10"
            );
        }
        else if(5 <= $score && $score < 6.5){
            return array(
                "color" => "warning",
                "rank" => __("Bad"),
                "description" => __("Score from")." "."6.5/10"." ".__("to")." "."5/10"
            );
        }
        else if(3.5 <= $score && $score < 5){
            return array(
                "color" => "danger",
                "rank" => __("Very bad"),
                "description" => __("Score from")." "."3.5/10"." ".__("to")." "."5/10"
            );
        }
        else if (0 <= $score && $score < 3.5){
            return array(
                "color" => "default",
                "rank" => __("Failed"),
                "description" => __("Score from")." "."0/10"." ".__("to")." "."3.5/10"
            );
        }
        else {
            return array(
                "color" => "default",
                "rank" => '',
                "description" => __("Score from")." "."..."." ".__("to")." "."..."
            );
        }
    }
/**
 * translate day of week short into full and translated string
 *    @param    dow(Sun, Mon, etc.)
 *    @return   dow(__('Sunday'), __('Monday'))
 */
    public function convertDayOfWeek($date){
        switch ($date) {
            case 'Sun':
                return __('Sunday');
                break;
            case 'Mon':
                return __('Monday');
                break;
            case 'Tue':
                return __('Tuesday');
                break;
            case 'Wed':
                return __('Wednesday');
                break;
            case 'Thu':
                return __('Thursday');
                break;
            case 'Fri':
                return __('Friday');
                break;
            case 'Sat':
                return __('Saturday');
                break;
            
            default:
                return __('None');
                break;
        }
    }
	/* Rank color from score */
    public function rankColor($score){
        if(9 <= $score && $score <= 10){
            return '#5CB85C';
        }
        else if( 8 <= $score && $score < 9){
           return '#337AB7';
        }
        else if(6.5 <= $score && $score < 8){
            return '#5BC0DE';
        }
        else if(5 <= $score && $score < 6.5){
           return '#F0AD4E';
        }
        else if(3.5 <= $score && $score < 5){
            return '#D9534F';
        }
        else if (0 <= $score && $score < 3.5){
            return '#777';
        }
    }
}