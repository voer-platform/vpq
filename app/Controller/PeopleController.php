<?php
App::uses('AppController', 'Controller');
/**
 * People Controller
 * @property Person $Person
 * @property PaginatorComponent $Paginator
 */
class PeopleController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * Helpers
 * 
 * @var array
 */
	public $helpers = array('Name');
/*
 * authorization
 * 
 */
	public function isAuthorized($user) {
	    // user can logout, dashboard, progress, history, suggest
	    if (isset($user['role']) && $user['role'] === 'user' ){
	    	if( in_array( $this->request->action, array('view','progress', 'login', 'logout', 'history', 'dashboard','suggest', 'coverDetails', 'performanceDetails'))){
	    		return true;
	    	}
	    } elseif (isset($user['role']) && $user['role'] === 'editor') {
            return true;
        }


	    return parent::isAuthorized($user);
	}
/*
* beforeFilter
*/
    public function beforeFilter(){
        parent::beforeFilter();
        // Allow users to
        $this->Auth->allow('register', 'login');

        Security::setHash('md5');
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Person->recursive = 0;
		$this->set('people', $this->Paginator->paginate());
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Person->exists($id)) {
			throw new NotFoundException(__('Invalid person'));
		}
		$options = array('conditions' => array('Person.' . $this->Person->primaryKey => $id));
		$this->set('person', $this->Person->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Person->create();
			if ($this->Person->save($this->request->data)) {
				$this->Session->setFlash(__('The person has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The person could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Person->exists($id)) {
			throw new NotFoundException(__('Invalid person'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Person->save($this->request->data)) {
				$this->Session->setFlash(__('The person has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The person could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Person.' . $this->Person->primaryKey => $id));
			$this->request->data = $this->Person->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Person->id = $id;
		if (!$this->Person->exists()) {
			throw new NotFoundException(__('Invalid person'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Person->delete()) {
			$this->Session->setFlash(__('The person has been deleted.'));
		} else {
			$this->Session->setFlash(__('The person could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/*
 * login page
 */
    public function login() {
        $this->autoRender = false;

        // If it is a post request we can assume this is a local login request
	    if ($this->request->isPost()){
	        if ($this->Auth->login()){
	            $this->redirect($this->Auth->redirectUrl());
	        } else {
	            $this->Session->setFlash(__('Invalid Username or password. Try again.'));
	        }
	    } 

	    // When facebook login is used, facebook always returns $_GET['code'].
	    elseif($this->request->query('code')){

	        // User login successful
	        $fb_user = $this->Facebook->getUser();          # Returns facebook user_id
	        if ($fb_user){
	            $fb_user = $this->Facebook->api('/me');     # Returns user information
	            $picture = $this->Facebook->api('/me/picture?height=200&width=200&redirect=false');		# FB picture
	
	            // We will varify if a local user exists first
	            $local_user = $this->Person->find('first', array(
	                'conditions' => array('facebook' => $fb_user['id'])
	            ));

	            // If exists, we will log them in
	            if ($local_user){
					// update data after login.
	                $this->Person->updateAll(
	                	array(
			                'first_name'=> '\''.$fb_user['first_name'].'\'',
			                'last_name'=> '\''.$fb_user['last_name'].'\'',
			                'image'=> '\''.$picture['data']['url'].'\'',
			                'date_modified' => '\''.date("Y-m-d H:i:s").'\'',
						),
	                	array( 'facebook' => $fb_user['id'])
	                );

	                $this->Auth->login($local_user['Person']);            # Manual Login

	                $this->redirect($this->Auth->redirect());
	            }

	            // Otherwise we ll add a new user (Registration)
	            else {
	                $data['Person'] = array(
	                    'username'      => $fb_user['id'],                               	# Normally Unique
	                    'facebook'		=> $fb_user['id'],
	                    'password'      => AuthComponent::password(uniqid(md5(mt_rand()))), # Set random password
	                    'first_name'	=> $fb_user['first_name'],
	                    'last_name'		=> $fb_user['last_name'],
	                    'role'          => 'user',
	                    'date_created'	=> '\''.date("Y-m-d H:i:s").'\'',
	                    'date_modified' => '\''.date("Y-m-d H:i:s").'\'',
	                    'image'			=> $picture['data']['url']
	                );

	                // You should change this part to include data validation
	                $this->Person->save($data, array('validate' => false));

	                // After registration we will redirect them back here so they will be logged in
	                $this->redirect(Router::url('/people/login?code=true', true));
	            }
	        }

	        else{
	            // User login failed..
	            $this->Session->setFlash(__('Something wrong, cannot log in. Please try again!'));
	        }
	    }
    }
/*
 * log out
 */
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

 /*
  * dashboard.ctp
  */
    public function dashboard(){

        $this->loadModel('Score');
        $performance = array();
        $performance['physics'] = $this->Score->overall($this->Session->read('Auth.User')['id'], 2);

        $this->loadModel('Subcategory');
        $coverage = array();
        $coverage['physics'] = $this->Subcategory->coverage($this->Session->read('Auth.User')['id'], 2);

        $this->set('performance', $performance);
        $this->set('coverage', $coverage);
    }

/**
 * history
 */
	public function history(){
		$this->set('title_for_layout',__("History"));

		$this->loadModel('Score');
		$result = $this->Score->getAllScores($this->Session->read('Auth.User')['id']);
		$this->set('scores', $result);
	}

/**
 * suggestion
 */
	public function suggestion(){
		$this->set('title_for_layout',__("Suggestion"));
	}

/**
 * progress
 */	
	public function progress(){
		$this->set('title_for_layout',__("Progress"));

		$this->loadModel('Progress');
		$progresses = $this->Progress->getProgresses($this->Session->read('Auth.User')['id']);
		$this->set('progresses', $progresses);
	}

/**
 * performance details
 */
	public function performanceDetails($subject){
		
		$ajax = false;
		if( $this->request->is('POST')){
        
            $this->layout = null;
            $this->loadModel('Score');
			$user = $this->Session->read('Auth.User');
			$result = $this->Score->getScoresForChart($user['id'], $subject);
            $this->set('result',$result);
        
            $ajax = true;
        }
        else if( $this->request->is('GET')){

			// set to view
			$this->set('subject', $subject);
        }
        $this->set('ajax',$ajax);
	}
/**
 *	coverage details
 */	
	public function coverDetails($subject){
		$this->set('title_for_layout',__("Cover details"));

		$this->loadModel('Category');
		$categories = $this->Category->find('all');
		$this->loadModel('Grade');
		$grades = $this->Grade->find('all', array('recursive' => -1));

		// set to view
		$this->set('subject', $subject);
		$this->set('grades', $grades);
		$this->set('categories', $categories);
	}
}