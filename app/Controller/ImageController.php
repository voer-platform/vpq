<?php
	class ImageController extends AppController {
		
		function index()
		{
			$this->autoRender = false;
			$this->loadModel('Person');
			$this->Person->recursive = -1;
			$users = $this->Person->find('all');
			foreach ($users AS $user) {
			
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);
				
				@$image = file_get_contents('https://graph.facebook.com/'.$user['Person']['facebook'].'/picture?width=200&height=200', false, stream_context_create($arrContextOptions));
			
				if ($image) {
					$imageUrl = $user['Person']['facebook'].'.jpg';
					file_put_contents(WWW_ROOT."img/avatars/".$imageUrl, $image);
					$this->Person->save(array('id'=>$user['Person']['id'], 'image'=>$imageUrl));
				} else {
					$this->Person->save(array('id'=>$user['Person']['id'], 'image'=>'no_avatar.jpg'));
				}
			
			}

		}
		
	}