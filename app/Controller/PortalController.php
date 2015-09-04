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

	
	public function beforeFilter(){
        parent::beforeFilter();
        // Allow users to
        $this->Auth->allow('index', 'viewPost');
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
															'conditions'=>array('newsletter_category_id'=>$category['NewsletterCategory']['id']),
															'limit'	=>	5
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
		// pr($this->getRankings(date('Y-m')));
		$this->set('rankings', $this->getRankings(date('Y-m')));
	}
	
	public function viewPost($slug)
	{
		$this->loadModel('Newsletter');
		$newsletter = $this->Newsletter->find('first', array('conditions'=>array('Newsletter.slug'=>$slug)));
		
		if(empty($newsletter)){
			$this->redirect('/');
		}	
		
		$this->set('title_for_layout', $newsletter['Newsletter']['title']);
		
		$breadcrumbs[] = array('url'=>Router::url(array('controller'=>'portal', 'action'=>'viewCategory', $newsletter['NewsletterCategory']['id'])), 'text'=>$newsletter['NewsletterCategory']['name']);
		
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
		return $activities;
	}
	
	private function getRankings($month)
	{
		// $this->loadModel('Exp');
		// $options = array(
						// 'conditions'	=>	array("Exp.date LIKE '$month%'"),
						// 'limit'	=>	10,
						// 'order'	=>	'Exp.exp DESC'
					// );
		// $rankings = $this->Exp->find('all', $options);
		// return $rankings;
		$this->loadModel('Person');
		$options = array(
						'fields'	=>	array('Person.id, Person.fullname', 'Person.image', 'Province.name', 'Person.exp'),
						
						'recursive'	=>	0,
						'limit'	=>	10,
						'order'	=>	'Person.exp DESC'
					);
		$rankings = $this->Person->find('all', $options);
		return $rankings;
	}
	
	
}