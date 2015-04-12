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
            if( in_array( $this->request->action, array('view', 'update','progress', 'login', 'logout', 'history', 'dashboard','suggest', 'completeProfile'))){
                return true;
            }
        } elseif (isset($user['role']) && $user['role'] === 'editor') {
            if( in_array( $this->request->action, array('view','progress', 'login', 'logout', 'history', 'dashboard','suggest'))){
                return true;
            }
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
		$this->loadModel('Grade');
		$grades = $this->Grade->find('list');
		$this->set('grades', $grades);
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
/**
 * update method
 *
 * @throws NotFoundException
 * @return void
 */
    public function update() {
        $user = $this->Auth->user();
        if (!$user['id']) {
            throw new NotFoundException(__('Invalid person'));
        }
        $this->request->onlyAllow('post');
        if($this->request->data('update_profile'))
		{
			$this->Person->updateAll(
				array(
					'fullname'	=>	"'".$this->request->data('fullname')."'", 
					'birthday'	=>	"'".$this->request->data('birthday')."'", 
					'address'	=>	"'".$this->request->data('address')."'", 
					'grade'		=>	"'".$this->request->data('grade')."'", 
					'school'	=>	"'".$this->request->data('school')."'",
					'gender'	=>	"'".$this->request->data('gender')."'"
				),
				array('id' => $user['id'])
			);
			$this->Auth->login($user);
			$this->Session->setFlash(__('Đã cập nhật thông tin cá nhân'));
		}
        return $this->redirect(array('action' => 'view', $user['id']));
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
                $this->Session->setFlash(__('Invalid login. Please try again.'));
            }
        }

        // When facebook login is used, facebook always returns $_GET['code'].
        elseif($this->request->query('code')){

            // User login successful
            $fb_user = $this->Facebook->getUser();          # Returns facebook user_id
            if ($fb_user){
                $fb_user = $this->Facebook->api('/me');     # Returns user information
                $picture = $this->Facebook->api('/me/picture?height=200&width=200&redirect=false');        # FB picture
                if(isset($fb_user['birthday'])){
                    $birthday = date('Y-m-d', strtotime($fb_user['birthday']));
                }
                else {
                    $birthday = '2000-01-01';
                }

                // We will varify if a local user exists first
                $local_user = $this->Person->find('first', array(
                    'conditions' => array('facebook' => $fb_user['id'])
                ));

                // If exists, we will log them in
                if ($local_user){
                    // update data after login.
                    /*$this->Person->updateAll(
                        array(
							'fullname'	=>	'\''.$fb_user['first_name'].' '.$fb_user['first_name'].'\'',
                            'first_name'=> '\''.$fb_user['first_name'].'\'',
                            'last_name'=> '\''.$fb_user['last_name'].'\'',
                            'image'=> '\''.$picture['data']['url'].'\'',
                            'birthday' => $birthday,
                            'date_modified' => '\''.date("Y-m-d H:i:s").'\'',
                        ),
                        array( 'facebook' => $fb_user['id'])
                    );*/

                    // $log = $this->Person->getDataSource()->getLog(false, false);
                    // debug($log);

                    $this->Auth->login($local_user['Person']);            # Manual Login
					//Save user data to cookie
					$this->Cookie->write('remember', $local_user['Person'], false, 31536000);
					$firstTimeLogin = $this->request->query('code');
					if($firstTimeLogin=='true')
					{
						$this->redirect(array('controller' => 'people', 'action' => 'completeProfile'));
					}
					else
					{
						$this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
					}	
                }

                // Otherwise we ll add a new user (Registration)
                else {
                    $data['Person'] = array(
                        'facebook'          => $fb_user['id'],
                        'password'          => AuthComponent::password(uniqid(md5(mt_rand()))), # Set random password
                        'fullname'			=> $fb_user['first_name'].' '.$fb_user['last_name'],
						'first_name'        => $fb_user['first_name'],
                        'birthday'          => $birthday,
                        'last_name'         => $fb_user['last_name'],
                        'role'              => 'user',
                        'date_created'      => date("Y-m-d H:i:s"),
                        'date_modified'     => date("Y-m-d H:i:s"),
                        'image'             => $picture['data']['url'],
						'gender'			=>	($fb_user['gender']=='male')?1:0
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
                $this->redirect(Router::url('/'));
            }
        }
        else {
        	$this->Session->setFlash(__('Something wrong, cannot log in. Please try again!'));
        	$this->redirect(Router::url('/'));
        }
    }
/*
 * log out
 */
    public function logout() {
        $this->Auth->logout();
		$this->Cookie->delete('remember');
        return $this->redirect($this->Auth->loginAction);
    }

 /*
  * dashboard.ctp
  */
    public function dashboard(){
        $this->set('title_for_layout',__("Dashboard"));
        $user_id = $this->Session->read('Auth.User')['id'];

        // get scores for 2 progress bars
        /*$this->loadModel('Score');
        $scores = array();
        $scores = $this->Score->getOverAll($user_id);*/

        // get all subject cover
        $this->loadModel('Question');
        $cover = array();
        $cover = $this->Question->getCover($user_id);

        // get subject for dashboard
        $this->loadModel('Progress');
        $progresses = $this->Progress->progressOnSubject($user_id);
        $this->set('progresses', $progresses);

		$this->loadModel('Grade');
		
		$gradeContents = $this->Grade->find('all', 
										array(
											//'recursive' => 2,
											'contain'	=>	array(
												'Category'	=>	array(
													'conditions'=> array('Category.subject_id = 2'),
													'Subcategory'
												)
											)	
										)
									);
		$progressDetail = $this->Progress->progressOnGrade($user_id);
		//pr($progressDetail);
		
		$this->set('progressDetail', $progressDetail);
		$this->set('gradeContents', $gradeContents);
		
		$this->loadModel('Score');
		$subject_id = 2;
		$chart = json_encode($this->Score->getChartData($user_id, $subject_id, array('type'=>'tentimes')));
		
		
        $this->set('progresses', $progresses);
        //$this->set('scores', $scores);
        $this->set('cover', $cover);
		$this->set('chart', $chart);
    }

/**
 * history
 */
    public function history(){
        $this->set('title_for_layout',__("History"));

        $this->loadModel('Score');
        $history = $this->Score->getAllScores($this->Session->read('Auth.User')['id'], 10);
        $this->set('scores', $history);
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
 *    coverage details
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
/**
 *	data filters
 */
	public function completeProfile()
	{
		$user = $this->Auth->user();
		if($user['school'])
		{
			$this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
		}
		
		if($this->request->is('post'))
		{
			
			$this->Person->updateAll(
							array(
								'fullname'	=>	"'".$this->request->data('fullname')."'", 
								'birthday'	=>	"'".$this->request->data('birthday')."'", 
								'address'	=>	"'".$this->request->data('address')."'", 
								'grade'		=>	"'".$this->request->data('grade')."'", 
								'school'	=>	"'".$this->request->data('school')."'",
								'gender'	=>	"'".$this->request->data('gender')."'"
							),
							array('id' => $user['id'])
						);
			$this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
		}
		
		$this->loadModel('Grade');
		$grades = $this->Grade->find('list');
		$this->set('grades', $grades);
	}
}
