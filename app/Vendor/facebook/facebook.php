<?php
	session_start();
	//include autoload.php from SDK folder, just point to the file like this:
	require_once "autoload.php";

	//import required class to the current scope
	use Facebook\FacebookSession;
	use Facebook\FacebookRequest;
	use Facebook\GraphUser;
	use Facebook\FacebookRedirectLoginHelper;

	class Facebook {

		private $helper, $session, $scope, $appId, $appSecret;
	
		public function __construct($configs)
		{
			FacebookSession::setDefaultApplication($configs['appId'] , $configs['secret']);
			$this->helper = new FacebookRedirectLoginHelper($configs['redirect_uri']);
			$this->scope = $configs['scope'];
			$this->appId = $configs['appId'];
			$this->appSecret = $configs['secret'];
		}
		
		public function getLoginUrl()
		{
			
			$login_url = $this->helper->getLoginUrl( array( 'scope' => $this->scope ) );
			return $login_url;
		}
		
		public function getUser()
		{
			try
			{
				$this->session = $this->helper->getSessionFromRedirect();
				return $this->session;
			}
			catch(\Exception $ex)	
			{
				return false;
			}
		}
		
		public function getUserInfo()
		{
			$user_profile = (new FacebookRequest($this->session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
			$user_profile = $user_profile->asArray();
			//Get user avatar
			$user_picture = (new FacebookRequest($this->session, 'GET', '/me/picture?height=200&width=200&redirect=false'))->execute()->getGraphObject(GraphUser::className());
			$user_profile['picture'] = $user_picture->asArray();
			//Get user's friends whole using app
			$user_friend = (new FacebookRequest($this->session, 'GET', '/me/friends?limit=5000'))->execute()->getGraphObject(GraphUser::className());
			$user_profile['friends'] = $user_friend->asArray();
			
			return $user_profile;
		}
		
		public function sendNotify($fb_id, $mess)
		{
			$session = FacebookSession::newAppSession();
			$notify = (new FacebookRequest($session, 'POST', "/$fb_id/notifications/",
				array(
					'access_token' => $this->appId.'|'.$this->appSecret,
					'href' => '/',  //this does link to the app's root, don't think this actually works, seems to link to the app's canvas page
					'template' => $mess,
					'ref' => 'pls_noti' //this is for Facebook's insight
				)
			))->execute();
		}
		
		/*
		//try to get current user session
		try {
		  $session = $helper->getSessionFromRedirect();
		} catch(FacebookRequestException $ex) {
			die(" Error : " . $ex->getMessage());
		} catch(\Exception $ex) {
			die(" Error : " . $ex->getMessage());
		}

		if ($session){ //if we have the FB session
			$user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
			//do stuff below, save user info to database etc.
			$user_friend = (new FacebookRequest($session, 'GET', '/me/friends?fields=installed'))->execute()->getGraphObject(GraphUser::className());
			echo '<pre>';
			print_r($user_profile); //Or just print all user details
			echo '</pre>';
			echo '<pre>';
			print_r($user_friend->asArray()); //Or just print all user details
			echo '</pre>';
			/* PHP SDK v4.0.0 */
			/* make the API call */
			/*$request = new FacebookRequest(
			  $session,
			  'POST',
			  '/me/feed',
			  array (
				'message' => "Tét cái, @[AaJcJN764ggDCJU6whluT5N1NdLzjv9jgMhgMocJSeshiR1GnjXl9FpBVJ6CeJaQqNK4vtHvfGFOIVubjZpcuQvyPq5dw1e5vpd6c_HId6_4-g:Viet vu] !",
				'link'	=>	array(
								'name'	=>	'Học trực tuyến'
							)			
			  )
			);
			$response = $request->execute();
			$graphObject = $response->getGraphObject();
		}*/
	}