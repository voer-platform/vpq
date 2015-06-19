<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */

class AppController extends Controller {
    public $components = array(
        'Auth' => array(
            // declare that we are using model Person, fields are 'username' and 'password'
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'Person',
                    'fields' => array(
                        'username' => 'username',
                        'password' => 'password'
                    )
                 )
            ),
            //action login
        	'loginAction' => array(
        		'controller' => 'Portal',
                'action' => 'index'
        	),
            //redirect after logged in
        	'loginRedirect' => array(
                'controller' => 'people', 'action'=>'login'
            ),
            //redirect after logged out
            'logoutRedirect' => array(
                'controller' => 'people', 'action'=>'login'
            ),
            'authError' => 'You are not authorized for this page',
            'authorize' => array('Controller')
	    ),
        'Session',
		'Cookie'
    );

    /**
     * beforeFilter
     */
    public function beforeFilter() {
        // load sdk
        Configure::load('facebook');
        // this is not recommended by CakePHP, just for backward compatiblity
        // App::import('Vendor', 'facebook-php-sdk-master/src/facebook');
        require_once(APP. 'Vendor'. DS . 'facebook'. DS. 'facebook.php');
		require_once(APP. 'Vendor'. DS .'PHPExcel.php');
		require_once(APP. 'Vendor'. DS . 'PHPExcel'. DS. 'IOFactory.php');
        $this->Facebook = new Facebook(array(
            'appId'     =>  Configure::read('Facebook.AppID'),
            'secret'    =>  Configure::read('Facebook.AppSecret'),
			'redirect_uri' => Router::url(
                array(
                    'controller' => 'people', 
                    'action' => 'login'
                ), 
                true),
            'scope' => 'user_birthday, user_friends, public_profile, publish_actions, email, user_games_activity'
            ));

        // set default language is Vietnamese
        Configure::write('Config.language', 'vie');
    }

    /**
     * beforeRender
     */
    public function beforeRender() {
        // set variables before render to user
        $this->set('fb_login_url', $this->Facebook->getLoginUrl());
		
		if(!$this->Auth->loggedIn()){
			//if user not logged in, check cookie then auto login
			$remember = $this->Cookie->read('reaccess');
            if($remember)
			{
				$access_string = base64_decode($remember);
				$decryped_access_string = Security::cipher($access_string, Configure::read('Security.key'));
				$access_info = explode('|', $decryped_access_string);
				$this->loadModel('Person');
				$user_exists = $this->Person->find('first', array('conditions'=>array('Person.id'=>$access_info[0])));
				if(!empty($user_exists) && 
					$access_info[1]==Security::hash($user_exists['Person']['password'], 'md5', $user_exists['Person']['salt']))
				{
					$this->Auth->login($user_exists['Person']);
					$this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
				}
			}
		}
		
		$user = $this->Auth->user();
        $this->set('user', $user);
		$this->loadModel('Notification');
		$this->set('notifications', $this->Notification->getNotification($user['id']));
		$this->set('unread', $this->Notification->getUnreadNotification($user['id']));
    }

    /*
     * controll access
     */
    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        $this->Session->setFlash(__("You are not authorized for that pages"));
        $this->redirect('/');

        // Default deny
        return false;
    }
}
