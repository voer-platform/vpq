<?php 

App::uses('AppHelper', 'View/Helper');
App::import('Model', 'Person');

class PersonHelper extends AppHelper {
	/**
	 * get person by id
     * @param id of person
     * @return person record
	 */ 
    public function getById($id) {
        $Person = new Person();

        $person = $Person->find('first', array(
        	'conditions' => array('Person.id' => $id)
        	));
        return $person['Person'];
    }
}
