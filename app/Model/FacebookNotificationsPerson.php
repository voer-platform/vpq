<?php
App::uses('AppModel', 'Model');
/**
 * NotificationType Model
 */
class FacebookNotificationsPerson extends AppModel {
	public $primaryKey = 'id';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public function paginate($conditions, $fields, $order, $limit, $page = 1,
    $recursive = null, $extra = array())
	{    
		$recursive = -1;

		// Mandatory to have
		$this->useTable = false;
		$sql = '';

		$sql .= "SELECT people.id, people.facebook, people.fullname, fnp.ttfn, fnp.lastsend, DATEDIFF(NOW(), people.date_created) AS joindate, DATEDIFF(NOW(), MAX(time_taken)) AS lasttest from people
				LEFT JOIN scores ON scores.person_id = people.id
				LEFT JOIN (SELECT facebook_notifications_people.person_id, DATEDIFF(NOW(), MAX(facebook_notifications_people.time)) AS lastsend, COUNT(facebook_notifications_people.id) AS ttfn 
							FROM facebook_notifications_people 
							
							GROUP BY facebook_notifications_people.person_id) AS fnp ON fnp.person_id = people.id
				WHERE DATEDIFF(NOW(), people.date_created) > 7
				GROUP BY people.id, people.facebook 
				HAVING (lastsend IS NULL OR lastsend >= 7)
						AND ((lasttest IS NULL AND joindate < 30) OR (lasttest >= 7 AND lasttest < 30)) LIMIT ";

		// Adding LIMIT Clause
		$sql .= (($page - 1) * $limit) . ', ' . $limit;

		$results = $this->query($sql);

		return $results;
	}
	
	public function paginateCount($conditions = null, $recursive = 0, $extra = array())
	{
		$sql = '';

		$sql .= "SELECT people.id, people.facebook, people.fullname, fnp.ttfn, fnp.lastsend, DATEDIFF(NOW(), people.date_created) AS joindate, DATEDIFF(NOW(), MAX(time_taken)) AS lasttest from people
				LEFT JOIN scores ON scores.person_id = people.id
				LEFT JOIN (SELECT facebook_notifications_people.person_id, DATEDIFF(NOW(), MAX(facebook_notifications_people.time)) AS lastsend, COUNT(facebook_notifications_people.id) AS ttfn 
							FROM facebook_notifications_people 
							
							GROUP BY facebook_notifications_people.person_id) AS fnp ON fnp.person_id = people.id
				WHERE DATEDIFF(NOW(), people.date_created) > 7
				GROUP BY people.id, people.facebook 
				HAVING (lastsend IS NULL OR lastsend >= 7)
						AND ((lasttest IS NULL AND joindate < 30) OR (lasttest >= 7 AND lasttest < 30))";

		$this->recursive = $recursive;

		$results = $this->query($sql);

		return count($results);
	}
	
}