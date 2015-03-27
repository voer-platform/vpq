<?php
App::uses('AppController', 'Controller');
/**
 * Tests Controller
 *
 * @property Test $Test
 * @property PaginatorComponent $Paginator
 */
class TestsController extends AppController {

    public $uses = array('Test', 'Grade', 'Category', 'Subcategory', 'Tracking');
    /*
     * authorization
     *
     */
    public function isAuthorized($user) {
        // user can logout, dashboard, progress, history, suggest
        if (isset($user['role']) && $user['role'] === 'user' ){
            if( in_array( $this->request->action, array('chooseTest', 'doTest', 'score', 'byQuestion'))){
                return true;
            }
        } elseif (isset($user['role']) && $user['role'] === 'editor' ){
            return true;
        }

        return parent::isAuthorized($user);
    }
    /**
     * beforeFilter
     *
     */
    public function beforeFilter(){
        parent::beforeFilter();

        $this->Auth->allow('sampleTest', 'score');
    }
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->set('title_for_layout', __('List testes'));

        $this->Test->recursive = 0;
        $this->set('tests', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->set('title_for_layout', __('Test number').' '.$id);

        if (!$this->Test->exists($id)) {
            throw new NotFoundException(__('Invalid test'));
        }
        $options = array('conditions' => array('Test.' . $this->Test->primaryKey => $id));
        $this->set('test', $this->Test->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->set('title_for_layout', __('Add test'));
        if ($this->request->is('post')) {
            $this->Test->create();
            if ($this->Test->save($this->request->data)) {
                $this->Session->setFlash(__('The test has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The test could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Test->Category->find('list');
        $questions = $this->Test->Question->find('list');
        $this->set(compact('categories', 'questions'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->set('title_for_layout', __('Edit test number').' '.$id);
        if (!$this->Test->exists($id)) {
            throw new NotFoundException(__('Invalid test'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Test->save($this->request->data)) {
                $this->Session->setFlash(__('The test has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The test could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Test.' . $this->Test->primaryKey => $id));
            $this->request->data = $this->Test->find('first', $options);
        }
        $categories = $this->Test->Category->find('list');
        $questions = $this->Test->Question->find('list');
        $this->set(compact('categories', 'questions'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Test->id = $id;
        if (!$this->Test->exists()) {
            throw new NotFoundException(__('Invalid test'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Test->delete()) {
            $this->Session->setFlash(__('The test has been deleted.'));
        } else {
            $this->Session->setFlash(__('The test could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * chooseTest
     *
     * @throws NotFoundException
     * @return void
     */
    public function chooseTest($subject = null) {
		if($subject!=null)
		{
			$this->layout = 'test';
			$this->set('title_for_layout', __('Choose test'));

			$allGrades = $this->Grade->find('all');
			$this->set('grades', $allGrades);
			$this->set('subject', $subject);
			
			// Du tinh trinh do hoc van
			$user = $this->Session->read('Auth.User');
			$gradeUser = $user['grade'];
			
			if(!isset($this->request->query['subcategory']) && !isset($this->request->query['category'])){		
				if ($gradeUser == 0){
					$birthday = $user['birthday'];
					$time = strtotime($birthday);
					$date = getdate($time);
					$year = $date['year'];

					$now = getdate();
					$current_year = $now['year'];

					$gradeUser = $current_year - $year - 5; //Du doan lop hoc theo tuoi 

				}
				$options = array(
					'recursive' => 0,
					'conditions' => array('person_id' => $user['id'],'subject_id'=>$subject)
					);				
				$tracking = $this->Tracking->find('all', $options);
			}else{
				if(isset($this->request->query['subcategory'])){
					$id=$this->request->query['subcategory'];
					
					$tracking =$this->Subcategory->query("
									SELECT Subcategory.id, Subcategory.name, Tracking.name as grade FROM subcategories as Subcategory
									INNER JOIN categories ON Subcategory.category_id=categories.id
									INNER JOIN grades as Tracking ON categories.grade_id=Tracking.id
									WHERE Subcategory.id='$id'
									");
				}else{
					$id=$this->request->query['category'];
					
					$tracking =$this->Subcategory->query("
									SELECT Subcategory.id, Subcategory.name, Tracking.name as grade FROM subcategories as Subcategory
									INNER JOIN categories ON Subcategory.category_id=categories.id
									INNER JOIN grades as Tracking ON categories.grade_id=Tracking.id
									WHERE categories.id='$id'
									");
					}
			}
			$preSubCategories='';
			$this->set('tracking',$tracking);
			foreach($tracking as $tracking)
			{
				if (isset($tracking['Tracking']) && !empty($tracking['Tracking'])){			
					//if ($tracking['Tracking']['grade'] >= 10 && $tracking['Tracking']['grade'] <= 12){
					//	$gradeUser[]= $tracking['Tracking']['grade'];
					//}
					$preSubCategories =$preSubCategories.",".$tracking['Subcategory']['id'];
							 
				}
			}
			
			$this->set('preSubs', $preSubCategories); 			      
			
			$this->set('gradeUser', $gradeUser);
		}else{
			$this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
		}
    }

    public function getCategories($grade = null){
        print_r($this->Category);
    }

    /**
     * doTest
     *
     * @return void
     */
    public function doTest($time, $subject) {
        $this->layout = 'test';
        $this->set('title_for_layout', __('Testing'));
		
        // process if request is post
        if( isset($time) && isset($subject) ){
<<<<<<< HEAD
=======
			
>>>>>>> cc78af22ec04f50832f35b505f0aaa3df8424dbe
            // retrieve request data
            $numberOfQuestions = $time;
            $timeLimit = $time;
            $strCategories = $this->request->data['categories'];
            //$categories = split(",", $strCategories);
			$data = explode(",",$this->request->data['categories']);
			$data_tracking=array();
			$categories=array();
			foreach($data as $dt)
			{
				$t=explode('-',$dt);
				$data_tracking[]=array('grade'=>$t[0],'subcategory'=>$t[1]);
				$categories[]=$t[1];
			}
            $questions = $this->Test->generateTest($numberOfQuestions, $categories);			
            if (count($questions) > 0){
                // create tests in database
                $testID = $this->Test->nextTestId();

                // save test: id, timeLimit, allow attemps, subject(currently df is 2)
                $this->Test->saveTest($testID, $timeLimit, $numberOfQuestions,-1, $subject);

                $dataTest = array();
                foreach($questions as $question){
                    $dataTest[] = array('test_id' => $testID, 'question_id' => $question['Question']['id']);
                }
                $this->loadModel('TestsQuestion');
                $this->TestsQuestion->saveAll($dataTest);

                // set to view
                $this->set('questions', $questions);
                $this->set('subject', $subject);
                $this->set('testID', $testID);
                $this->set('duration', $timeLimit);
                $this->set('numberOfQuestions', $numberOfQuestions);
                // Save data user
                $user = $this->Session->read('Auth.User');
				
				foreach($data_tracking as $dt)
				{
					$this->Tracking->deleteAll(array('Tracking.person_id'=>$user['id']));
				}
				foreach($data_tracking as $dt)
				{
					$this->Tracking->create();
					$this->Tracking->save(
											array(
												'person_id' => $user['id'],
												'grade' => $dt['grade'],
												'subject_id' => $subject,
												'subcategory' => $dt['subcategory']
											)
										);
				}
            }else{
                // warn that no data found
                $this->Session->setFlash(__('No data found'));
                $this->redirect(array('controller' => 'tests', 'action' => 'chooseTest', $subject));
            }
        }
        else{
            $this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
        }

    }

    /**
     * score
     *
     * @return void
     */
    public function score() {
		
        // process if request is post
        if( $this->request->is('post')){
            //layout						
            $this->render = false;

            // data
            $user = $this->Session->read('Auth.User');
            $testId = $this->request->data('testID');
            $numberOfQuestions = $this->request->data['numberOfQuestions'];

            //counter to determine score
            $correctCounter = 0;

            // array for progress calulate
            $scoreData = array();

            // calculate score
            $this->loadModel('Score');
            // save to db if user has logged in
            // else just calculate.
            $scoreId = $this->Score->calculateScore($testId, $this->request->data, $user, $scoreData, $numberOfQuestions);
            // calculate progress
            $this->loadModel('Progress');
            $this->Progress->calculateProgress($user['id'], $scoreData);

            $this->redirect(array('controller' => 'Scores', 'action' => 'viewDetails', $scoreId));
        }
        else {
            $this->redirect('chooseTest');
        }
    }
	
	public function byQuestion($numberOfQuestions = null, $categories = null){			
        $this->layout = "ajax";
        $this->autoLayout = false;
        $this->autoRender = false;
		$data = explode(",",$categories);
		$data_tracking=array();
		$categories=array();
		foreach($data as $dt)
		{	
			$t=explode('-',$dt);
			$categories[]=$t[1];
		}		
		$questions = $this->Test->generateTest($numberOfQuestions, $categories);		
        $this->header('Content-Type: application/json');
        echo json_encode(count($questions));
		return;
    }
}
