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
        		'controller' => 'Pages',
                'action' => 'display'
        	),
            //redirect after logged in
        	'loginRedirect' => array(
                'controller' => 'People',
                'action' => 'dashboard',
            ),
            //redirect after logged out
            'logoutRedirect' => array(
                'controller' => 'Pages',
                'action' => 'display',
            ),
            'authError' => 'You are not authorized for this page',
            'authorize' => array('Controller')
	    ),
        'Session'
    );

    /**
     * beforeFilter
     */
    public function beforeFilter() {
        // load sdk
        Configure::load('facebook');
        // this is not recommended by CakePHP, just for backward compatiblity
        // App::import('Vendor', 'facebook-php-sdk-master/src/facebook'); 
        require(APP. 'Vendor'. DS . 'facebook-php-sdk-master'. DS. 'src'. DS. 'facebook.php');

        $this->Facebook = new Facebook(array(
            'appId'     =>  Configure::read('Facebook.AppID'),
            'secret'    =>  Configure::read('Facebook.AppSecret')
        ));

        // set default language is Vietnamese
        Configure::write('Config.language', 'vie');
    }

    /**
     * beforeRender
     */
    public function beforeRender() {
        // set variables before render to user
        $this->set('fb_login_url', $this->Facebook->getLoginUrl(array('redirect_uri' => Router::url(array('controller' => 'people', 'action' => 'login'), true))));
        $this->set('user', $this->Auth->user());
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
        $this->redirect(array('controller' =>'pages', 'action' => 'display', 'home'));

        // Default deny
        return false;
    }
}
