<?php
	App::uses('AppController', 'Controller');
	App::uses('Security', 'Utility');
	/**
	 * Api Controller
	 * @property Person $Person
	 * @property PaginatorComponent $Paginator
	 */
	class AjaxController extends Controller {
	
		public function beforeFilter()
		{
			//$this->autoRender = false;
			$this->layout = 'ajax';
		}
	
		public function portalRankings()
		{
			
			$month = date('Y-m');
			
			$limit = 10;
			if(isset($this->request->query['limit']))
			{
				$limit = $this->request->query['limit'];
			}
			$this->set('limit', $limit);
			
			if(isset($this->request->query['subject']) && $this->request->query['subject']!='')
			{
				$subject = $this->request->query['subject'];
				
				$this->loadModel('ExpSubject');
				$this->ExpSubject->alias = 'Exp';
				$options = array(
								'conditions'	=>	array("Exp.date LIKE '$month%'", "Exp.subject_id = $subject", "Exp.exp > 0"),
								'limit'	=>	$limit,
								'order'	=>	'Exp.exp DESC'
							);
				$rankings = $this->ExpSubject->find('all', $options);			
			}
			else
			{
				$this->loadModel('Exp');
				$options = array(
								'conditions'	=>	array("Exp.date LIKE '$month%'", "Exp.exp > 0"),
								'limit'	=>	$limit,
								'order'	=>	'Exp.exp DESC'
							);
				$rankings = $this->Exp->find('all', $options);
				
			}
			
			$this->set('rankings', $rankings);
		}
	
		public function scoreRankings()
		{
			$subject = $this->request->query['subject'];
			$limit = 10;
			if(isset($this->request->query['limit']))
			{
				$limit = $this->request->query['limit'];
			}
			$this->loadModel('Ranking');
			$options = array(
							//'conditions'	=>	array("Exp.date LIKE '$month%'"),
							'fields'	=>	array('Person.id, Person.fullname', 'Person.image', 'Province.name', 'Ranking.score'),
							'joins'	=>	array(
											array(
												'table'	=>	'provinces',
												'alias'	=>	'Province',
												'conditions'	=>	'Province.id = Person.address'
											)
										),
							'recursive'	=>	0,
							'limit'	=>	$limit,
							'order'	=>	'Ranking.score DESC',
							'conditions'	=>	array('Ranking.subject_id' => $subject)
						);
			$scoreRankings = $this->Ranking->find('all', $options);
			 // pr($scoreRankings);
			$this->set('scoreRankings', $scoreRankings);
		}
	
		public function phoneCheck()
		{
			$user = $this->Auth->user();
			$phone = $this->request->data['phone'];
			$phoneUsed = $this->Person->find('first', array(
							'conditions' => array('phone' => $phone, 'Person.id !=' => $user['id'])
						));
			if($phoneUsed)			
			{
				echo json_encode(array('code'=>0));
			}
			else
			{
				echo json_encode(array('code'=>1));
			}
		}
	
	}