<?php 
App::uses('AppController', 'Controller');
/**
 * Admin Controller
 *
 * @property Admin $Admin
 * @property PaginatorComponent $Paginator
 */
class AdminController extends AppController {

	// do not use model
	var $uses = false;

	// public $helpers = array('TinymceElfinder.TinymceElfinder');
	// public $components = array('Paginator','TinymceElfinder.TinymceElfinder');
	public $helpers = array();
	public $components = array('Paginator');

/**
 * paginate
 *
 */
 	public $paginate = array(
		'Question' => array(
	        'limit' => 10, 
	        'recursive' => 2, 
	        'model' => 'Question', 
	        // 'joins' => aray(),n
	        'order' => array('Question.id' => 'ASC')
    		),
	);	

/*
 * authorization
 * 
 */
	public function isAuthorized($user) {
	    // only admin can do 
	    if (isset($user['role']) && $user['role'] === 'editor' ){
	    	return true;
	    }

	    return parent::isAuthorized($user);
	}
/*
* beforeFilter
*/
    public function beforeFilter(){
        parent::beforeFilter();
    }


/**
 * index
 *
 * @return void
 */
	public function index(){
		$this->set('title_for_layout',__("Admin"));
	}

/**
 * insert questions
 *
 * @return void
 */
	public function insertQuestions(){
		$this->set('title_for_layout',__("Add questions"));

		$this->loadModel('Question');

		if($this->request->is('post')){
			$path = WWW_ROOT. DS . 'files';
			if(isset($this->request->data['Attachment'])){
				foreach($this->request->data['Attachment'] as $key => $value){
					$newName = date('YmdHisu').'-'.$key.'.jpg';
					move_uploaded_file($value['tmp_name'], $path.DS.$newName);
					$this->request->data['Attachment'][$key] = array(
						'path' => Router::url('/', true).'files'.'/'.$newName
						);
				}
			}
			foreach ($this->request->data['Answer'] as $key => $answer) {
				$this->request->data['Answer'][$key]['order'] = $key;
			}
			$this->Question->create();
			if ($this->Question->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The question has been saved.'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		}
		
		$subcategories = $this->Question->Subcategory->find('list', array('order' => array('Subcategory.id ASC')));
		$tests = $this->Question->Test->find('list');
		$this->set(compact('subcategories', 'tests'));
	}

/**
 * elfinder
 *
 * @return void
 */
	public function elfinder() {
        $this->TinymceElfinder->elfinder();
    }

/**
 * connector for elfindier
 *
 * @return void
 */ 
    public function connector() {
        $this->TinymceElfinder->connector();
    }

/**
 * insert multiple questions
 *
 * @return void
 */
	public function insertMultipleQuestions(){
		$this->set('title_for_layout',__("Add multiple questions"));

		if($this->request->is('post')){
			// unzip file
			$file = $this->request->data['Import']['file']['tmp_name'];
			$filename = $this->request->data['Import']['file']['name'];
			$filename = substr($filename, 0, strrpos($filename, '.'));

			$path = pathinfo(realpath($file), PATHINFO_DIRNAME).DS.microtime(true);

			$zip = new ZipArchive;
			$res = $zip->open($file);

			// open OK
			if ($res === TRUE) {
				// extract it to the path we determined above
				$zip->extractTo($path);
				$zip->close();

				// read data file extract at path/filename
				if( file_exists($path.DS.$filename.DS.'data.txt'))
					$data_path = $path.DS.$filename;
				else
					$data_path = $path.DS;

				$data = file_get_contents($data_path.DS.'data.txt');
				// process data
				$this->loadModel('Question');
				$result = $this->Question->processMassImport($data, $data_path);

				if($result){
					$this->Session->setFlash(__('Import success. Please verify in manage question list.'));
				}
				else{
					$this->Session->setFlash(__('Import Fail. Please verify in manage question list.'));
				}

			} else {
				$this->Session->setFlash(__('The imported data could not be process, please try again later.'));
			}

			
		}
	}

/**
 * manual categorized question
 * 
 *
 */
	public function manualCategorized(){
		$this->set('title_for_layout', 'Categorize');

		$this->loadModel('Question');
		$this->Question->unBindModel(array(
			'hasMany' => array('Answer', 'Attachment'),
			'hasAndBelongsToMany' => array('Score', 'Test')
			));

		$this->Paginator->settings = $this->paginate;
		$this->set('questions', $this->Paginator->paginate('Question'));
	}

/**
 * questions number analystic
 *
 */
	public function analystics(){
		$this->set('title_for_layout', __('Analystic'));

		$this->loadModel('Subcategory');
		$data = $this->Subcategory->countQuestions();

		$this->set('data', $data);
	}
/**
 * display ranking table
 */
 
	public function ranking()
	{
		$this->loadModel('Ranking');
		$this->loadModel('Subject');
		$subjects = $this->Subject->find('list');
		$options = array();
		
		$this->Ranking->virtualFields['num_test'] = 'COUNT(Tests_subjects.test_id)';
		$this->Paginator->settings = array(
					'joins'	=> array(
									array(
										'table'	=>	'Scores',
										'type'	=>	'INNER',
										'conditions'	=>	'Scores.person_id = Ranking.person_id'
									),
									array(
										'table'	=>	'Tests_subjects',
										'type'	=>	'INNER',
										'conditions'	=>	'Tests_subjects.test_id = Scores.test_id'
									)
								),
					'group'	=>	array('Tests_subjects.subject_id, Ranking.person_id')			
				);
		if(isset($this->request->params['named']['subject']))
		{
			$subject = $this->request->params['named']['subject'];
			if($subject)
				$options['Subject.id'] = $subject;
				
			$this->set('current_subject', $subject);
		}
		$rankings = $this->Paginator->paginate('Ranking', $options);
		$this->set('rankings', $rankings);
		$this->set('subjects', $subjects);
	}
 
/**
 * rebuild ranking table
 */
	public function rebuildRanking()
	{
		$this->autoRender = false;
		$this->loadModel('Subject');
		$this->loadModel('Person');
		$this->loadModel('Ranking');
		$this->loadModel('Progress');
		$subjects = $this->Subject->find('list');
		$people = $this->Person->find('list');
		foreach($subjects AS $subject_id => $subject)
		{
			foreach($people AS $person_id=>$person)
			{
				$totalScore = $this->Progress->progressOnSubject($person_id, array('subject'=>$subject_id));
				if(!empty($totalScore))
				{
					$totalScore = round($totalScore[0]['Progress']['sum_progress']/$totalScore[0]['Progress']['sum_total'], 2)*10;
					
					$subject_ranking = $this->Ranking->find('first', array('conditions'=>array('subject_id'=>$subject_id, 'person_id'=>$person_id)));
					$ranking_data = array(
										'person_id'	=>	$person_id,
										'subject_id'	=>	$subject_id,
										'score'	=>	$totalScore,
										'time_update'	=>	date('Y-m-d H:i:s')
									);
					if(empty($subject_ranking))
					{
						$this->Ranking->create();
						$this->Ranking->save($ranking_data);
					}
					else
					{
						$ranking_data['time_update'] = "'".date('Y-m-d H:i:s')."'";
						$this->Ranking->updateAll($ranking_data, array('subject_id'=>$subject_id, 'person_id'=>$person_id));
					}
				}
			}
		}
		$this->Session->setFlash(__('Ranking data refreshed.'));
		$this->redirect(array('controller' =>'Admin', 'action' => 'ranking'));
	}
}