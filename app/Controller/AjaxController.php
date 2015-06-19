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
		}
	
		public function portalRankings()
		{
			$this->layout = 'ajax';
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
	
	}