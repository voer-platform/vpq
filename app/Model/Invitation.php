<?php
App::uses('AppModel', 'Model');
/**
 * Tracking Model
 *
 * @property Person $Person
 */
class Invitation extends AppModel {
	public $primaryKey = 'id';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	 public $belongsTo = array(
	 	'Person' => array(
	 		'className' => 'Person',
	 		'foreignKey' => 'person_id',
	 		'conditions' => '',
	 		'fields' => '',
			'order' => ''
		)
	);

	public function invitationGift($inviter_id, $invited_id){
		$inviter = $this->find('first', array('conditions'=>array('person_fb_id'=>$inviter_id, 'friend_fb_id'=>$invited_id, 'status' => 0)));
		if(!empty($inviter)){
			$this->updateAll(
					array(
						'update_time'	=>	"'".date('Y-m-d H:i:s')."'",
						'status'	=>	"1"
					),
					array('person_fb_id'=>$inviter_id, 'friend_fb_id'=>$invited_id)
				);
			$this->Person->updateAll(
				array('coin'=>"coin+50"),
				array('Person.id'=>$inviter['Person']['id'])
			);
			return $inviter['Person']['id'];
		}	
	}
	
	public function invite($person_id, $inviter_id, $invited_id)
	{
		$invation = $this->find('count', array('conditions'=>array('person_fb_id'=>$inviter_id, 'friend_fb_id'=>$invited_id)));
		if($invation==0)
		{
			$data = array(
						'person_id'	=>	$person_id,
						'person_fb_id'	=>	$inviter_id,
						'friend_fb_id'	=>	$invited_id,
						'time'	=>	date('Y-m-d H:i:s')
					);
			$this->save($data);
		}
	}
	
}