<?php 

App::uses('AppHelper', 'View/Helper');
App::import('Model', 'Subject');
App::import('Model', 'Subcategory');
App::import('Model', 'Grade');

class DateHelper extends AppHelper {
    /**
     * subject id to name
     * @param id of the subject
     * @return string reperesent name of subject
     */ 
    public function toVnDate($date) {
		return date('d/m/Y', strtotime($date));
	}
}	