<?php
App::uses('Controller', 'Controller');
/**
 * People Controller
 * @property Person $Person
 * @property PaginatorComponent $Paginator
 */
class LoginController extends Controller {
	
/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator','Session','Cookie');

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
        /*if (isset($user['role']) && $user['role'] === 'user' ){
            if( in_array( $this->request->action, array('view', 'update','progress', 'login', 'logout', 'history', 'dashboard','suggest', 'completeProfile', 'invite','rechargecard', 'resetNotifyCounter', 'emailCheck', 'changePassword'))){
                return true;
            }
        } elseif (isset($user['role']) && $user['role'] === 'editor') {
            if( in_array( $this->request->action, array('view','progress', 'login', 'logout', 'history', 'dashboard','suggest','rechargecard'))){
                return true;
            }
        }
        return parent::isAuthorized($user);*/
		return true;
    }
/*
* beforeFilter
*/
   /*public function beforeFilter(){
        parent::beforeFilter();
        // Allow users to
        $this->Auth->allow('register', 'login', 'index');

        Security::setHash('md5');
    }*/

/**
 * index method
 *
 * @return void
 */
    public function index(){
		$user = array();
        $this->set('user', $user);
		$this->layout ='excel';
		$this->loadModel('Person');
		if($this->request->is('post')){			
			if($this->request->data('login')){
				$this->Session->destroy();
				$user=$this->request->data('user');
				$pass=$this->request->data('pass');
				$user=$this->Person->find('all',array(
											'recursive' => -1,
											'conditions' => array('username'=>$user),
									)
				);
				if($user!=null){
					if($user[0]['Person']['password']==md5($pass)){
						$this->Session->write('user',$user[0]['Person']);
						//$this->Auth->login($user[0]['Person']);
						$this->Cookie->delete('remember');
						//$this->Cookie->write('reaccess', $encrypted_access_string, true, 31536000);						
						if($user[0]['Person']['role']=='tester'){
							$this->redirect(array('controller' =>'partner', 'action' => 'check_question'));
						}else{
							$this->redirect(array('controller' =>'partner', 'action' => 'import_excel'));
						}
					}else{
						$this->Session->setFlash(__('Mật khẩu không đúng.'));
					}
				}else{
					
				}
			}
		}
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
    
    public function logout() {
		$this->Session->destroy();
        //$this->Auth->logout();
		//$this->Cookie->delete('reaccess');
        return $this->redirect(array('controller' =>'login', 'action' => 'index'));
    }

	
	
	
	
}
