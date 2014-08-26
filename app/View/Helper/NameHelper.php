<?php 

App::uses('AppHelper', 'View/Helper');
App::import('Model', 'Subject');

class NameHelper extends AppHelper {
    public function subjectToName($subject_id) {
        $Subject = new Subject();

        $subject = $Subject->find('first', array(
        	'conditions' => array('Subject.id' => $subject_id)
        	));
        return $subject['Subject']['name'];
    }
}