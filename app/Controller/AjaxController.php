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
												'type'	=>	'left',
												'conditions'	=>	'Province.id = Person.address'
											)
										),
							'recursive'	=>	0,
							'limit'	=>	$limit,
							'order'	=>	'Ranking.score DESC',
							'conditions'	=>	array('Ranking.subject_id' => $subject, 'Ranking.score > 5', "Person.role = 'user'")
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
	
		public function sortingOption(){
			$this->autoRender = false;
			$this->loadModel('Subcategory');
			
			$grade = $this->request->query['grade'];
			$subject = $this->request->query['subject'];
			$category = $this->request->query['category'];
			
			$options = array();
			
			if ($category) {
			
				$subcategories = $this->Subcategory->find('list', array(
					'recursive'	=> -1,
					'fields'	=>	array('Subcategory.id', 'Subcategory.name'),
					'joins'	=>	array(
						array(
							'table'	=>	'Categories',
							'alias'	=>	'Category',
							'type'	=>	'INNER',
							'conditions'	=>	'Subcategory.category_id = Category.id'
						)
					),
					'conditions'	=>	array("Category.grade_id = $grade", "Category.subject_id = $subject", "Category.id = $category")
				));
				$options['subcategories'] = $subcategories;
				
			} else if ($grade && $subject) {
			
				$this->loadModel('Category');
				$categories = $this->Category->find('list', array(
					'recursive'	=>	-1,
					'fields'	=>	array('Category.id', 'Category.name'),
					'conditions'	=>	array("Category.grade_id = $grade", "Category.subject_id = $subject")
				));
				$options['categories'] = $categories;
			}
			
			echo json_encode($options);
			
		}
	
	}