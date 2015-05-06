<?php
	App::uses('AppController', 'Controller');
	/**
	 * Api Controller
	 * @property Person $Person
	 * @property PaginatorComponent $Paginator
	 */
	class ApiController extends Controller {
	
		public function beforeFilter()
		{
			$this->autoRender = false;
		}
	
		public function loginUrl()
		{
			Configure::load('facebook');
			// this is not recommended by CakePHP, just for backward compatiblity
			// App::import('Vendor', 'facebook-php-sdk-master/src/facebook');
			require_once(APP. 'Vendor'. DS . 'facebook'. DS. 'facebook.php');

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

			echo $this->Facebook->getLoginUrl();
		}
	
	}