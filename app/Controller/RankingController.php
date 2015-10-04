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
						'recursive'	=>	0,
						'conditions'	=>	array('Person.exp > 0')
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
						'conditions'	=>	array("Exp.date LIKE '$month%'", 'Exp.exp > 0'),
						'limit'	=>	100,
						'order'	=>	'Exp.exp DESC'
					);
		$monthRankings = $this->Exp->find('all', $options);
		$this->set('monthRankings', $monthRankings);
		
		$this->loadModel('Ranking');
		$options = array(
						//'conditions'	=>	array("Exp.date LIKE '$month%'"),
						'fields'	=>	array('Person.id, Person.fullname', 'Person.image', 'Province.name', 'Ranking.score'),
						'joins'	=>	array(
										array(
											'table'	=>	'provinces',
											'alias'	=>	'Province',
											'type'	=>	'left',
											'conditions'	=>	'Province.id = Person.address'
										)
									),
						'recursive'	=>	0,
						'limit'	=>	100,
						'order'	=>	'Ranking.score DESC',
						'conditions'	=>	array('Ranking.subject_id' => key($subjects), 'Ranking.score > 5', "Person.role = 'user'")
					);
		$scoreRankings = $this->Ranking->find('all', $options);
		 // pr($scoreRankings);
		$this->set('scoreRankings', $scoreRankings);
		
	}
}	