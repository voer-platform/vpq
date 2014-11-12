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
        return $subject['Subject']['name'];
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
}