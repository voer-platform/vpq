<?php
App::uses('AppController', 'Controller');
/**
 * Scores Controller
 *
 * @property Score $Score
 * @property PaginatorComponent $Paginator
 */
class ScoresController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
/**
 * authorization
 * 
 */
	public function isAuthorized($user) {
	    // user can logout, dashboard, progress, history, suggest
	    if (isset($user['role']) && $user['role'] === 'user' ){
	    	if( in_array( $this->request->action, array('viewDetails', 'ajaxOverall'))){
	    		return true;
	    	}
	    }
	    else if (isset($user['role']) && $user['role'] === 'editor' ){
	    	return true;
	    }

	    return parent::isAuthorized($user);
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Score->recursive = 0;
		$this->set('scores', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Score->exists($id)) {
			throw new NotFoundException(__('Invalid score'));
		}
		$options = array('conditions' => array('Score.' . $this->Score->primaryKey => $id));
		$this->set('score', $this->Score->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Score->create();
			if ($this->Score->save($this->request->data)) {
				$this->Session->setFlash(__('The score has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The score could not be saved. Please, try again.'));
			}
		}
		$tests = $this->Score->Test->find('list');
		$people = $this->Score->Person->find('list');
		$this->set(compact('tests', 'people'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Score->exists($id)) {
			throw new NotFoundException(__('Invalid score'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Score->save($this->request->data)) {
				$this->Session->setFlash(__('The score has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The score could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Score.' . $this->Score->primaryKey => $id));
			$this->request->data = $this->Score->find('first', $options);
		}
		$tests = $this->Score->Test->find('list');
		$people = $this->Score->Person->find('list');
		$this->set(compact('tests', 'people'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Score->id = $id;
		if (!$this->Score->exists()) {
			throw new NotFoundException(__('Invalid score'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Score->delete()) {
			$this->Session->setFlash(__('The score has been deleted.'));
		} else {
			$this->Session->setFlash(__('The score could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * view score details
 *	
 *	@param int $id
 *	@return void
 */
	public function viewDetails($id){
        $this->layout = 'test';
        $this->set('title_for_layout', __('Testing'));

		$this->loadModel('ScoresQuestion');

		$this->Score->unbindModel(array('belongsTo' => array('Person')));
		$score = $this->Score->find('first', array('conditions' => array('Score.id' => $id), 'recursive' => 0) );
		$scoreData = $this->ScoresQuestion->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'score_id' => $id
			)
		));
        pr($scoreData);

		$questionsIds = array();
		foreach($scoreData as $data){$questionIds[] = $data['ScoresQuestion']['question_id'];}

		$this->loadModel('Question');
		$questions = $this->Question->getQuestionsFromIds($questionIds);
	
		ksort($scoreData); // sort the data to match result from $questions
		$this->set('questionsData', $questions);
		$this->set('scoreData', $scoreData);
		$this->set('correct', $score['Score']['score']);
		$this->set('numberOfQuestions', $score['Test']['number_questions']);
	}

/**
 * performance details
 * ajax call
 */
    public function performanceDetails(){
        $this->layout = 'ajax';
        $this->autoLayout = false;
        $this->autoRender = false;
        
        if( $this->request->is('POST')){
            if(isset($_POST['subject'])){
                $user = $this->Session->read('Auth.User');
                $result = $this->Score->getScoresForChart($user['id'], $this->request->data('subject'));
                echo $result;
            }
        }
        else {
            $this->redirect('/');
        }
    }

/**
 * ajax call for overall
 * ajax call
 */
	public function ajaxOverall(){
		$this->layout = 'ajax';
        $this->autoLayout = false;
        $this->autoRender = false;
        
        if( $this->request->is('POST')){
            if(isset($_POST['subject']) && isset($_POST['grade'])){
                $grade_id = $this->request->data['grade'];
                $subject_id = $this->request->data['subject'];
                $user = $this->Session->read('Auth.User');
                $result = $this->Score->overall($user['id'], $grade_id, $subject_id);
                echo json_encode($result);
            }
        }
        else {
            $this->redirect('/');
        }
	}

}
