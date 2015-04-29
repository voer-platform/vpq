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
		$this->Person->virtualFields['_gen'] = "IF(Person.gender=1, 'Nam', 'Nữ')";
		$this->paginate = array('escape'=>false,'fields'=>array('Person.*', 'Province.name', '_gen'));
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
		$this->loadModel('Province');
		$provinces = $this->Province->find('list');
		$this->set('provinces', $provinces);
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
				array('Person.id' => $user['id'])
			);
			$newInfo = $this->Person->find('first', array('conditions'=>array('Person.id' => $user['id'])));
			$this->Auth->login($newInfo['Person']);
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

                // We will varify if a local user exists first
                $local_user = $this->Person->find('first', array(
                    'conditions' => array('facebook' => $fb_user['id'])
                ));

                // If exists, we will log them in
                if ($local_user){
                    $this->Auth->login($local_user['Person']);            # Manual Login
					//Create access string for remember login
					$access_string = $local_user['Person']['facebook'].'|'.Security::hash($local_user['Person']['password'], 'md5', $local_user['Person']['salt']);
					$encrypted_access_string = Security::cipher($access_string, Configure::read('Security.key'));
					
					//Save user data to cookie
					$this->Cookie->delete('remember');
					$this->Cookie->write('reaccess', $encrypted_access_string, false, 31536000);
					
					$firstTimeLogin = $this->request->query('code');
					if($firstTimeLogin=='true')
					{
						$this->redirect(array('controller' => 'people', 'action' => 'completeProfile'));
					}
					else
					{
                        // redirect to previous review page if from it
                        if($this->Session->read('fromViewDetails')){
                            $review_url = $this->Session->read('fromViewDetails');
                            $this->Session->delete('fromViewDetails');
                            $this->redirect($review_url);
                        }
                        else{
        					$this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
                        }
					}	
                }

                // Otherwise we'll add a new user (Registration)
                else {
					$picture = $this->Facebook->api('/me/picture?height=200&width=200&redirect=false');        # FB picture
					if(isset($fb_user['birthday'])){
						$birthday = date('d/m/Y', strtotime($fb_user['birthday']));
					}
					else {
						$birthday = '01/01/2000';
					}
				
					$password = AuthComponent::password(uniqid(md5(mt_rand()))); # Set random password
					$salt = rand(10000, 99999); #Make random salt number
				
                    $data['Person'] = array(
                        'facebook'          => $fb_user['id'],
                        'password'          => $password,
						'salt'				=> $salt,
                        'fullname'			=> $fb_user['last_name'].' '.$fb_user['first_name'],
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
		$this->Cookie->delete('reaccess');
        return $this->redirect($this->Auth->loginAction);
    }

 /*
  * dashboard.ctp
  */
    public function dashboard($subject_id = null){
        $this->set('title_for_layout',__("Dashboard"));
        $user_id = $this->Session->read('Auth.User')['id'];

		if($subject_id){
			$this->loadModel('Progress');
			$progresses = $this->Progress->progressOnSubject($user_id, array('subject'=>$subject_id));
			$this->set('progresses', $progresses);

			// get scores for 2 progress bars
			/*$this->loadModel('Score');
			$scores = array();
			$scores = $this->Score->getOverAll($user_id);*/

			// get all subject cover
			$this->loadModel('Question');
			$cover = array();
			//$cover = $this->Question->getCover($user_id);
			$cover = $this->Question->getSubcategoryCover($user_id);

			//get all subject
			
			//pr($orverviews);
			// get subject for dashboard
			

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
			
			$chart = json_encode($this->Score->getChartData($user_id, $subject_id, array('type'=>'tentimes')));
			
			$this->loadModel('Ranking');
			$ranking_data = $this->Ranking->getSubjectRanking($user_id);
			
			$this->set('rankings', $ranking_data);
			$this->set('progresses', $progresses);
			//$this->set('scores', $scores);
			$this->set('cover', $cover);
			$this->set('chart', $chart);
			$this->set('subject_id', $subject_id);
		}
		else
		{
			$this->loadModel('Subject');
			$overviews = $this->Subject->subjectOverview($user_id);
			$this->set('overviews', $overviews);
		}
		
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
							array('Person.id' => $user['id'])
						);
			$newInfo = $this->Person->find('first', array('conditions'=>array('Person.id' => $user['id'])));
			$this->Auth->login($newInfo['Person']);			
			$this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
		}
		
		$this->loadModel('Grade');
		$this->loadModel('Province');
		$grades = $this->Grade->find('list');
		$provinces = $this->Province->find('list');
		$this->set('grades', $grades);
		$this->set('provinces', $provinces);
	}
}
