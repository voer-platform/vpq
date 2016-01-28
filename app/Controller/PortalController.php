<?php

App::uses('AppController', 'Controller');
/**
 * People Controller
 * @property Person $Person
 * @property PaginatorComponent $Paginator
 */
class PortalController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
    public $helpers = array('Text');

	public $components = array('Paginator');
	
	public function beforeFilter(){
        parent::beforeFilter();
        // Allow users to
        $this->Auth->allow('index', 'viewPost', 'listNews');
    }
	
	public function index()
	{
		$this->set('title_for_layout', 'Mạng xã hội học trực tuyến');
		
		$this->loadModel('Newsletter');
		$this->loadModel('NewsletterCategory');
		$newsletterCategories = $this->NewsletterCategory->find('all', 
					array(
						'conditions'=>array('status'=>1),
						'order'	=>	array('order ASC')
					)
				);
		
		foreach($newsletterCategories AS $k=>$category){
			$newsletter = $this->Newsletter->find('all', array(
															'conditions'=>array('newsletter_category_id'=>$category['NewsletterCategory']['id'], 'Newsletter.status' => 1),
															'limit'	=>	6,
															'order'	=>	array('created DESC')
														)
													);
													
			$newsletterCategories[$k]['Newsletters']	=	$newsletter;									
		}
		
		$this->loadModel('Subject');
		$subjects = $this->Subject->find('list', array(
													'recursive'	=>	-1, 
													'conditions'=>	array('enabled'=>1),
													'order'		=>	array('order ASC')
												));
		
		$this->set('newsletterCategories', $newsletterCategories);
		$this->set('activities', $this->getActivities());
		$this->set('subjects', $subjects);
		$this->set('rankings', $this->getRankings(date('Y-m')));
		$this->set('questionStatistic', $this->questionStatistic());
	}
	
	public function listNews()
	{
		$this->set('title_for_layout', 'Tin tức');
		$this->loadModel('Newsletter');
		$this->Newsletter->recursive = -1;
		$this->paginate = array(
							'conditions' => array('status' => 1, 'newsletter_category_id' => 1),
							'order'	=>	array('created' => 'DESC')
						);
		$this->set('newsletters', $this->Paginator->paginate('Newsletter'));
		
		$breadcrumbs[] = array('url' => '/tin-tuc', 'text'=> 'Tin tức');
		
		$this->set('breadcrumbs', $breadcrumbs);
		$this->set('activities', $this->getActivities());
	}
	
	public function viewPost($slug)
	{
		$this->loadModel('Newsletter');
		$newsletter = $this->Newsletter->find('first', array('conditions'=>array('Newsletter.slug'=>$slug)));
		
		if(empty($newsletter)){
			$this->redirect('/');
		}	
		
		$this->set('title_for_layout', $newsletter['Newsletter']['title']);
		
		$breadcrumbs[] = array('url' => '/tin-tuc', 'text'=>$newsletter['NewsletterCategory']['name']);
		
		$this->set('breadcrumbs', $breadcrumbs);
		$this->set('newsletter', $newsletter);
		$this->set('activities', $this->getActivities());
		$this->set('rankings', $this->getRankings(date('Y-m')));
	}
	
	
	private function getActivities()
	{
		$this->loadModel('Score');
		$options = array(
						'fields'	=>	array('Person.id, Person.fullname', 'Person.image', 'Test.time_limit', 'Subject.name'),
						'joins'	=>	array(
										array(
											'table'	=>	'tests',
											'alias'	=>	'Test',
											'type'	=>	'INNER',
											'conditions'	=>	'Score.test_id =  Test.id'
										),
										array(
											'table'	=>	'people',
											'alias'	=>	'Person',
											'type'	=>	'INNER',
											'conditions'	=>	"Score.person_id` = Person.id AND Person.role = 'user'"
										),
										array(
											'table'	=>	'(SELECT person_id, MAX(time_taken) AS maxtime FROM scores GROUP BY person_id ORDER BY maxtime DESC LIMIT 20)',
											'alias'	=>	'MaxTime',
											'type'	=>	'INNER',
											'conditions'	=>	array(
																	'Score.person_id = MaxTime.person_id',
																	'Score.time_taken = MaxTime.maxtime'
																)	
										),
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
						'recursive'	=>	-1,
						'limit'	=>	20,
						'order'	=>	array('Score.time_taken DESC'),
						'group'	=>	array('Person.id')
					);
		$activities = $this->Score->find('all', $options);
		return $activities;
	}
	
	private function getRankings($month)
	{
		$this->loadModel('Exp');
		$options = array(
						'conditions'	=>	array("Exp.date LIKE '$month%'", "Exp.exp > 0"),
						'limit'	=>	10,
						'order'	=>	'Exp.exp DESC'
					);
		$rankings = $this->Exp->find('all', $options);
		return $rankings;
	}
	
	/*private function getRankings($month)
	{
		$this->loadModel('Exp');
		$options = array(
						'conditions'	=>	array("Exp.date >= '2016-01-18'", "Exp.date <= '2016-01-25'", "Exp.exp > 0"),
						'limit'	=>	50,
						'order'	=>	'Exp.exp DESC'
					);
		$rankings = $this->Exp->find('all', $options);
		return $rankings;
	}*/
	
	private function questionStatistic()
	{
		$this->loadModel('Question');
		$this->Question->recursive = -1;
		$countQuestion = $this->Question->find('all', array(
										'escape'=>false,
										'fields'=>array('COUNT(DISTINCT Question.id) AS total', 'subjects.name', 'subjects.id'), 
										'joins'	=>	array(
														array(
															'table'	=>	'questions_subcategories',
															'type'	=>	'INNER',
															'conditions'	=>	array('Question.id = questions_subcategories.question_id')
														),
														array(
															'table'	=>	'subcategories',
															'type'	=>	'INNER',
															'conditions'	=>	array('subcategories.id = questions_subcategories.subcategory_id')
														),
														array(
															'table'	=>	'categories',
															'type'	=>	'INNER',
															'conditions'	=>	array('categories.id = subcategories.category_id')
														),
														array(
															'table'	=>	'subjects',
															'type'	=>	'INNER',
															'conditions'	=>	array('categories.subject_id = subjects.id')
														)
													),
										'group'	=>	array('subjects.name', 'subjects.id')
									)
							);
		$this->loadModel('ImportQuestion');
		$unclassify = $this->ImportQuestion->find('all', array(
			'escape'=>false,
			'fields'	=>	array('subject_id', 'COUNT(ImportQuestion.id) AS uc'),
			'conditions'	=>	array('subcategory_id IS NULL'),
			'group'	=>	array('subject_id')
		));
		
		$this->loadModel('TestsSubject');
		$testStat = $this->TestsSubject->find('all', array(
			'escape'=>false,
			'fields'	=>	array('subject_id', 'COUNT(TestsSubject.id) AS numtest'),
			'group'	=>	array('subject_id')
		));
		
		$questionStatisticData = array();
		
		foreach ($unclassify AS $subj) {
		
			$questionStatisticData[$subj['ImportQuestion']['subject_id']]['unclassify'] = $subj[0]['uc'];
		
		}
		
		foreach ($countQuestion AS $subj) {
			$questionStatisticData[$subj['subjects']['id']]['classified'] = $subj[0]['total'];
			$questionStatisticData[$subj['subjects']['id']]['subject'] = $subj['subjects']['name'];
		}
		
		foreach ($testStat AS $subj) {
		
			$questionStatisticData[$subj['TestsSubject']['subject_id']]['numtest'] = $subj[0]['numtest'];
		
		}
		
		return $questionStatisticData;
		
	}
	
	
}