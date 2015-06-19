<?php

App::uses('AppController', 'Controller');
/**
 * People Controller
 * @property Person $Person
 * @property PaginatorComponent $Paginator
 */
class RankingController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
    public $helpers = array('Text');

	
	public function beforeFilter(){
        parent::beforeFilter();
        // Allow users to
        $this->Auth->allow('index');
    }
	
	public function index()
	{
		$this->set('title_for_layout',__("Ranking"));
		$this->loadModel('Person');
		$options = array(
						'limit'	=>	100,
						'order'	=>	'exp DESC',
						'recursive'	=>	0
					);
		$rankings = $this->Person->find('all', $options);
		
		$this->set('rankings', $rankings);
		
		$this->loadModel('Subject');
		$subjects = $this->Subject->find('list', array(
													'recursive'	=>	-1, 
													'conditions'=>	array('enabled'=>1),
													'order'		=>	array('order ASC')
												));
		$this->set('subjects', $subjects);

		$this->loadModel('Exp');
		$month = date('Y-m');
		$options = array(
						'conditions'	=>	array("Exp.date LIKE '$month%'"),
						'limit'	=>	100,
						'order'	=>	'Exp.exp DESC'
					);
		$monthRankings = $this->Exp->find('all', $options);
		$this->set('monthRankings', $monthRankings);
		
		$this->loadModel('Score');
		$options = array(
						'fields'	=>	array('Person.id, Person.fullname', 'Person.image', 'Test.time_limit', 'Subject.name'),
						'joins'	=>	array(
										array(
											'table'	=>	'tests_subjects',
											'alias'	=>	'TestSubject',
											'type'	=>	'INNER',
											'conditions'	=>	'TestSubject.test_id = Test.id'
										),
										array(
											'table'	=>	'subjects',
											'alias'	=>	'Subject',
											'type'	=>	'INNER',
											'conditions'	=>	'TestSubject.subject_id = Subject.id'
										)
									),
						'recursive'	=>	0,
						'limit'	=>	20,
						'order'	=>	array('Score.time_taken DESC'),
						'group'	=>	array('Person.id')
					);
		$activities = $this->Score->find('all', $options);
		$this->set('activities', $activities);
		
	}
}	