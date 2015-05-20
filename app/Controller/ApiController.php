<?php
	App::uses('AppController', 'Controller');
	App::uses('Security', 'Utility');
	/**
	 * Api Controller
	 * @property Person $Person
	 * @property PaginatorComponent $Paginator
	 */
	class ApiController extends Controller {
	
		public function beforeFilter()
		{
			
		}
	
		public function loginUrl()
		{
			$this->autoRender = false;
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
	
		public function forgotPassword()
		{
			
			App::uses('CakeEmail', 'Network/Email');
			$this->loadModel('Person');
			if($this->request->is('post'))
			{
				$this->autoRender = false;
				$email = $this->request->data['email'];
				$emailExists = $this->Person->find('count', array('conditions'=>array('Person.email'=>$email)));
				$code = 0;
				$mess = __('Has an unexpected error has occurred, please try again');
				if($emailExists)
				{
					App::uses('String', 'Utility');
					$forgotCode = String::uuid();
					
					$updateResult=$this->Person->updateAll(array('forgot'=>"'".$forgotCode."'"), array('Person.email'=>$email));
					if($updateResult)
					{
						$messCode= Router::url(array(
										'controller'=>'api', 
										'action'=>'forgotPassword', 
										'?'=>array(
											'email'=>$email, 
											'key'=>base64_encode(Security::cipher($forgotCode, Configure::read('Security.key')))
										)), true);	
						$mess = 'Chào restart1993@gmail.com<br/>
								Đã có một yêu cầu khôi phục mật khẩu của bạn trên PLS<br/>
								Bạn vui lòng bấm vào link dưới đây để xác nhận đổi mật khẩu:<br/><a href="'.$messCode.'">'.$messCode.'</a>';
						
										
						$Email = new CakeEmail('gmail');
						$Email->to($email);
						$Email->subject('Xác nhận thay đổi mật khẩu');
						$Email->send($mess);
						$code = 1;
						$mess = __('A change password request sent to your email');
					}	
				}
				else
				{
					$mess = __('Your email does not exist');
				}
				echo json_encode(array('code'=>$code, 'mess'=>$mess));
			}
			else if($this->request->is('get'))
			{
				$email = $this->request->query['email'];
				$key = $this->request->query['key'];
				if($email && $key)
				{
					$rawKey = Security::cipher(base64_decode($key), Configure::read('Security.key'));
					$this->Person->recursive = -1;
					$user = $this->Person->find('first', array('conditions'=>array('Person.email'=>$email, 'Person.forgot'=>$rawKey)));
					if($user)
					{
						$password = md5(mt_rand());
						$mess = 'Chào '.$email.'<br/>
								Chúng tôi gửi bạn mật khẩu mới của tài khoản '.$email.' trên http://pls.edu.vn: <b>'.$password.'</b><br/>
								Bạn vui lòng đăng nhập theo mật khẩu mới để tiếp tục học trên PLS.<br/>
								Mong sớm gặp lại bạn trên hệ thống!';
								
						$Email = new CakeEmail('gmail');
						$Email->to($email);
						$Email->subject('Mật khẩu mới của bạn');
						if($Email->send($mess))
						{
							$md5Pass = md5($password.Configure::read('Security.key'));
							$updateResult=$this->Person->updateAll(array('forgot'=>"''",'password'=>"'".$md5Pass."'"), array('Person.email'=>$email));
							if($updateResult) $this->redirect(array('controller' => 'pages', 'action' => 'forgotpasswordsuccess'));
						}
					}
				}
				$this->redirect(array('controller' => 'pages', 'action' => 'forgotpassworderror'));
			}	
		}
	
	}