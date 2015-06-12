<?php
App::uses('AppController', 'Controller');
/**
 * People Controller
 * @property Person $Person
 * @property PaginatorComponent $Paginator
 */
class LogController extends AppController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');

/**
 * Helpers
 *
 * @var array
 */
    public $helpers = array('Name');
/*
 * authorization
 *
 */
    public function isAuthorized($user) {
        // user can logout, dashboard, progress, history, suggest
        return parent::isAuthorized($user);
    }
/*
* beforeFilter
*/
    public function beforeFilter(){
        parent::beforeFilter();
        // Allow users to
        $this->Auth->allow('register', 'login');

        Security::setHash('md5');
    }
	
	public function person($id)
	{
		$conditions = array("Score.person_id='$id'");
		if(isset($this->request->query['search']) && $this->request->query['search']!='')
		{
			$subject = $this->request->query['subject'];
			if($subject)
				$conditions['Subject.id'] = $subject;
			$this->set('csubject', $subject);
			
			$duration = $this->request->query['duration'];
			if($duration)
				$conditions['Test.time_limit'] = $duration;
			$this->set('cduration', $duration);
			
		}
        $this->loadModel('Score');
		$this->Paginator->settings  = array(
							'fields'	=>	array('Score.*, Subject.*, Test.*'),
							'recursive'	=>	-1,
							'escape'=>false,
							'joins'	=>	array(
											array(
												'table'	=>	'tests',
												'alias'	=>	'Test',
												'type'	=>	'inner',
												'conditions'	=>	'Test.id = Score.test_id'
											),
											array(
												'table'	=>	'tests_subjects',
												'type'	=>	'inner',
												'conditions'	=>	'Test.id=tests_subjects.test_id'
											),
											array(
												'table'	=>	'subjects',
												'type'	=>	'inner',
												'alias'	=>	'Subject',
												'conditions'	=>	'Subject.id=tests_subjects.subject_id'
											)
										),
							'conditions'	=>	$conditions,
							'order'	=>	array('Score.time_taken DESC'),
							'limit'	=>	10
						);
         
        $this->set('scores', $this->Paginator->paginate('Score'));
		
		$this->loadModel('Person');
		$person = $this->Person->find('first', array('recursive'=>-1, 'conditions'=>array('id'=>$id)));
		$this->set('person', $person);
		
		$this->loadModel('Subject');
		$subjects = $this->Subject->find('list');
		$this->set('subjects', $subjects);
	}
	
}	