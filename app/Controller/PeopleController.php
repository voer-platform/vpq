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
            if( in_array( $this->request->action, array('view', 'update','progress', 'login', 'logout', 'history', 'dashboard','suggest', 'completeProfile', 'invite','rechargecard', 'resetNotifyCounter', 'emailCheck', 'changePassword'))){
                return true;
            }
        } elseif (isset($user['role']) && $user['role'] === 'editor') {
            if( in_array( $this->request->action, array('view','progress', 'login', 'logout', 'history', 'dashboard','suggest','rechargecard'))){
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
        if($this->request->is('post'))
		{
			$email = $this->request->data['email'];
			$emailUsed = $this->Person->find('first', array(
							'conditions' => array('email' => $email, 'Person.id !=' => $user['id'])
						));
			if($emailUsed)			
			{
				$this->Session->setFlash(__('Email này đã được sử dụng'));
			}
			else
			{
				$this->Person->updateAll(
					array(
						'fullname'	=>	"'".$this->request->data('fullname')."'", 
						'birthday'	=>	"'".$this->request->data('birthday')."'", 
						'email'		=>	"'".$this->request->data('email')."'",
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
		}
        return $this->redirect(array('action' => 'view', $user['id']));
    }
/*
 * login page
 */
    public function login() {
        $this->autoRender = false;

        // If it is a post request we can assume this is a local login request
        if ($this->request->is('ajax')){
			$email = $this->request->data['email'];
			$password = $this->request->data['password'];
			if($email && $password)
			{
				$local_user = $this->Person->find('first', array(
						'conditions' => array('email' => $email)
					));
				
				if($local_user){
					$hashed = md5($password.Configure::read('Security.key'));
					if($hashed==$local_user['Person']['password'])
					{
						$this->Auth->login($local_user['Person']); # Manual Login
						//Create access string for remember login
						$access_string = $local_user['Person']['id'].'|'.Security::hash($local_user['Person']['password'], 'md5', $local_user['Person']['salt']);
						$encrypted_access_string = base64_encode(Security::cipher($access_string, Configure::read('Security.key')));

						//Save user data to cookie
						$this->Cookie->delete('remember');
						$this->Cookie->write('reaccess', $encrypted_access_string, true, 31536000);
						echo json_encode(array('code'=> 1, 'mess'=>__('Login successful')));
					}
					else
					{
						echo json_encode(array('code'=> 2, 'mess'=>__('Your password does not match')));
					}
				}
				else
				{
					echo json_encode(array('code'=> 2, 'mess'=>__('Your email does not exist')));
				}
			}	
        }

        // When facebook login is used, facebook always returns $_GET['code'].
        elseif($this->request->query('code')){

            // User login successful
            $fb_user = $this->Facebook->getUser();          # Returns facebook user_id
            if ($fb_user){
				$fb_user = $this->Facebook->getUserInfo();
                // We will varify if a local user exists first
                $local_user = $this->Person->find('first', array(
                    'conditions' => array('facebook' => $fb_user['id'])
                ));

                // If exists, we will log them in
                if ($local_user){
                    $this->Auth->login($local_user['Person']);            # Manual Login
					//Create access string for remember login
					$access_string = $local_user['Person']['id'].'|'.Security::hash($local_user['Person']['password'], 'md5', $local_user['Person']['salt']);
					$encrypted_access_string = base64_encode(Security::cipher($access_string, Configure::read('Security.key')));

					//Save user data to cookie
					$this->Cookie->delete('remember');
					$this->Cookie->write('reaccess', $encrypted_access_string, true, 31536000);
					
					$completedProfile = $local_user['Person']['profile_completed'];

					if(!$completedProfile)
					{
						$this->redirect(array('controller' => 'people', 'action' => 'completeProfile'));
					}
					else
					{
                        // redirect to previous review page if from it
                        if($this->Cookie->read('fromViewDetails')){
                            $review_url = $this->Cookie->read('fromViewDetails');
                            $this->Cookie->delete('fromViewDetails');
                            $this->redirect($review_url);
                        }
                        else{
							$this->Session->write('over','2');
        					$this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
                        }
					}	
                }

                // Otherwise we'll add a new user (Registration)
                else {
					if(isset($fb_user['birthday'])){
						$birthday = date('d/m/Y', strtotime($fb_user['birthday']));
					}
					else {
						$birthday = '01/01/2000';
					}
				
					$password = AuthComponent::password(uniqid(md5(mt_rand()))); # Set random password
					$salt = rand(10000, 99999); #Make random salt number
				
					$emailUsed = $this->Person->find('first', array('conditions' => array('email' => $fb_user['email'])));
					$email = '';
					if(!$emailUsed)
					{
						$email = $fb_user['email'];
					}
				
                    $data['Person'] = array(
                        'facebook'          => $fb_user['id'],
						'email'          	=> $email,
                        'password'          => $password,
						'salt'				=> $salt,
                        'fullname'			=> $fb_user['last_name'].' '.$fb_user['first_name'],
						'first_name'        => $fb_user['first_name'],
                        'birthday'          => $birthday,
                        'last_name'         => $fb_user['last_name'],
                        'role'              => 'user',
                        'date_created'      => date("Y-m-d H:i:s"),
                        'date_modified'     => date("Y-m-d H:i:s"),
                        'image'             => $fb_user['picture']['url'],
						'gender'			=>	($fb_user['gender']=='male')?1:0,
						'coin'			    => 150,
						'last_login'		=> date('Y-m-d'),
                    );

                    // You should change this part to include data validation
                    $this->Person->save($data, array('validate' => false));
					$currentUser = $this->Person->getLastInsertId();
					
					//First notify
					$this->loadModel('Notification');
					$notifyData = array(
									'Notification'	=>	array(
										'person_id'	=>	$currentUser,
										'time'	=>	date("Y-m-d H:i:s"),
										'notification_type_id'	=>	1
									)	
								);
					$this->Notification->save($notifyData);

					//Gift coins for user whole invited this user
					$this->loadModel('Invitation');
					$inviter = $fb_user['friends']['data'];
					if(!empty($inviter)){
						foreach($inviter AS $person)
						{
							$inviter_id = $this->Invitation->invitationGift($person->id, $fb_user['id']);
							if($inviter_id)
							{
								$this->Notification->create();
								$this->Notification->save(
										array(
											'Notification'	=>	array(
												'person_id'	=>	$inviter_id,
												'object_id'	=>	$currentUser,
												'time'	=>	date("Y-m-d H:i:s"),
												'notification_type_id'	=>	2
											)	
										)
									);
							}		
						}
					}
                    // After registration we will redirect them back here so they will be logged in
                    $this->redirect($this->Facebook->getLoginUrl());
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
		$this->loadModel('Person');
		$options = array(
				'recursive' => -1,
				'conditions' => array('Person.id'=>$user_id)
				);			
		$data_user = $this->Person->find('all',$options);
		$date1 = strtotime($data_user[0]['Person']['last_login']);
		$date2 = strtotime(date('Y-m-d'));
		$diff = abs($date2-$date1);
		$ketqua=round($diff/(60*60*24));
		$coin=$data_user[0]['Person']['coin']-$ketqua*5;
		if($coin<=0){
			$coin='0';
			if($this->Session->read('over')==2)
			{
				$this->Session->write('over','0');
			}else{				
				$this->Session->write('over','1');
			}
		}else{
			$this->Session->write('over','2');
		}
		$this->Person->id=$user_id;
		$this->Person->save(
							array(
								'coin' => $coin,
								'last_login' => date('Y-m-d'),
							)
						);
		$this->set('coin',$coin);
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
														'conditions'=> array("Category.subject_id = $subject_id"),
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
			$viewSubjects = array(2,4,8);
			$overviews = $this->Subject->subjectOverview($user_id, array('subject'=>$viewSubjects));
			$this->set('overviews', $overviews);
			//pr($overviews);
			$this->loadModel('Progress');
			$progresses = $this->Progress->progressOnSubject($user_id);
			$this->set('progresses', $progresses);
			
			$this->loadModel('Question');
			$cover = $this->Question->getSubcategoryCover($user_id);
			$this->set('cover', $cover);
			
			$this->loadModel('Score');
			$chart = $this->Score->getChartData($user_id, null, array('type'=>'tentimes'));
			if(isset($chart['chart']['subject']))
			{
				foreach($chart['chart']['subject'] AS $subj_id => $subj)
				{
					$viewSubjects = array_diff($viewSubjects, [$subj_id]);
				}
			}
			
			foreach($viewSubjects AS $subj_id)
			{
				$chart['chart']['subject'][$subj_id] = array('date'=>array(), 'score'=>array());
			}
				
			//pr($chart);
			$this->set('chart', json_encode($chart));
		}
		
    }

/**
 * history
 */
    public function history(){
        $this->set('title_for_layout',__("History"));

        $this->loadModel('Score');
        //$history = $this->Score->getAllScores($this->Session->read('Auth.User')['id'], 10);
		$id=$this->Session->read('Auth.User')['id'];
		$history=$this->Score->query("
							SELECT * From scores as Score 
							INNER JOIN tests as Test ON Test.id=Score.test_id
							INNER JOIN tests_subjects as TestsSubject ON Test.id=TestsSubject.test_id
							INNER JOIN subjects as Subject ON Subject.id=TestsSubject.subject_id
							WHERE Score.person_id='$id' Group By Score.time_taken DESC Limit 10
							");
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
		if($user['profile_completed'])
		{
			$this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
		}
		
		if($this->request->is('post'))
		{
			$md5Password = md5($this->request->data('password').Configure::read('Security.key'));
			$this->Person->updateAll(
							array(
								'fullname'	=>	"'".$this->request->data('fullname')."'", 
								'birthday'	=>	"'".$this->request->data('birthday')."'",
								'email'	=>	"'".$this->request->data('email')."'", 
								'address'	=>	"'".$this->request->data('address')."'", 
								'grade'		=>	"'".$this->request->data('grade')."'", 
								'school'	=>	"'".$this->request->data('school')."'",
								'gender'	=>	"'".$this->request->data('gender')."'",
								'password'	=>	"'".$md5Password."'",
								'profile_completed'	=>	"1"
							),
							array('Person.id' => $user['id'])
						);
			$newInfo = $this->Person->find('first', array('conditions'=>array('Person.id' => $user['id'])));
			$this->Auth->login($newInfo['Person']);			
			
			$access_string = $user['id'].'|'.Security::hash($md5Password, 'md5', $user['salt']);
			$encrypted_access_string = base64_encode(Security::cipher($access_string, Configure::read('Security.key')));
			$this->Cookie->write('reaccess', $encrypted_access_string, true, 31536000);
			
			$this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
		}
		
		$this->loadModel('Grade');
		$this->loadModel('Province');
		$grades = $this->Grade->find('list');
		$provinces = $this->Province->find('list');
		$this->set('grades', $grades);
		$this->set('provinces', $provinces);
	}
	
	public function invite()
	{
		$this->autoRender = false;
		$data = $this->request->data;
		$invited_friends = $data['frs'];
		$this->loadModel('Invitation');
		$user = $this->Auth->user();
		foreach($invited_friends AS $friend_fb)
		{
			$this->Invitation->invite($user['id'], $user['facebook'], $friend_fb);
		}
	}
	
	public function resetNotifyCounter(){
		$this->autoRender = false;
		$user = $this->Auth->user();
		$this->loadModel('Notification');
		$this->Notification->resetCounter($user['id']);
	}
	
	public function emailCheck()
	{
		$this->autoRender = false;
		$user = $this->Auth->user();
		$email = $this->request->data['email'];
		$emailUsed = $this->Person->find('first', array(
						'conditions' => array('email' => $email, 'Person.id !=' => $user['id'])
					));
		if($emailUsed)			
		{
			echo json_encode(array('code'=>0));
		}
		else
		{
			echo json_encode(array('code'=>1));
		}
	}
	
	public function changePassword()
	{
		$this->layout = 'ajax';
		if($this->request->is('post'))
		{
			$this->autoRender = false;
			$user = $this->Auth->user();
			$currentPassword = $this->request->data('cpwd');
			$newPassword = $this->request->data('npwd');
			$renewPassword = $this->request->data('rnpwd');
			$code = 0; $mess = __('Has an unexpected error has occurred, please try again');
			if(md5($currentPassword.Configure::read('Security.key'))!=$user['password'])
			{
				$mess = __('Current password does not match');
			}
			else if($newPassword!=$renewPassword)
			{
				$mess = __('Two password does not match');
			}
			else
			{
				$md5Password = md5($newPassword.Configure::read('Security.key'));
				$updateSuccess = $this->Person->updateAll(
							array(
								'password'	=>	"'".$md5Password."'"
							),
							array('Person.id' => $user['id'])
						);
				if($updateSuccess)		
				{
					//Update session & cookie
					$user['password'] = $md5Password;
					$this->Auth->login($user);
					$access_string = $user['id'].'|'.Security::hash($md5Password, 'md5', $user['salt']);
					$encrypted_access_string = base64_encode(Security::cipher($access_string, Configure::read('Security.key')));
					$this->Cookie->write('reaccess', $encrypted_access_string, true, 31536000);
					
					$code = 1;
					$mess = __('Password successfully changed');
				}
			}
			echo json_encode(array('code'=>$code, 'mess'=>$mess));
		}
	}
	
	
	
}
