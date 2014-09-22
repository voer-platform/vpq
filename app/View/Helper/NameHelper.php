<?php 

App::uses('AppHelper', 'View/Helper');
App::import('Model', 'Subject');
App::import('Model', 'Subcategory');

class NameHelper extends AppHelper {
	/**
	 * subject id to name
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
	 */ 
    public function subcategoryToName($subcategory_id) {
    	$Subcategory = new Subcategory();

        $subcategory = $Subcategory->find('first', array(
        	'conditions' => array('Subcategory.id' => $subcategory_id)
        	));
        return $subcategory['Subcategory']['name'];
    }
}