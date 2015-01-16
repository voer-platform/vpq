<?php
App::uses('AppModel', 'Model');
App::import('Model', 'QuestionsSubcategory');
/**
 * Progress Model
 *
 * @property Person $Person
 * @property Subcategory $Subcategory
 */
class Progress extends AppModel {


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
		),
		'Subcategory' => array(
			'className' => 'Subcategory',
			'foreignKey' => 'sub_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
/*
 * store a progress row in db
 * @param: info of a progress
 */
	public function saveProgress($personId, $sub_category_id, $progress, $total, $date){
		$this->set(array(
			'person_id' => $personId,
			'sub_category_id' => $sub_category_id,
			'progress' => $progress,
			'total' => $total,
			'date' => $date));
		$this->save();
	}
/*
 * get progress for a user
 * @param: personId
 */
	public function getProgresses($personId){
		$this->unBindModel(array('belongsTo' => array('Person')));

		return $this->find('all', array(
			'recursive' => 0,
			'fields' => array(
				'Subcategory.id',
				'Subcategory.name',
				"SUM(Progress.total) as 'total'",
				"SUM(Progress.progress) as 'progress'",
				'Progress.date'),
			'conditions' => array(
				'person_id' => $personId),
			'group' => array('Progress.sub_category_id')
			));
	}
/*
 * calculate/update progress for a person, on a test
 * @param: personId, array of answers on questions
 *		array: questionId => correctNess of user answer
 * Flow:
 * - query to check if it is exist 
 * 		- update if it is in current day
 * 		- insert if it is 
 *			- not exists
 *			- is another day
 */		
	public function calculateProgress($personId, $questions){
		// iterate given questions array
		// each element is a questionId and correctness of the question
		// data include of answer and correctness
		foreach($questions as $questionId => $data){
			// get subCategories for question
			// equal array(array([QuestionsSubcategory][subcategory_id]))
			$QuestionsSubcategory = new QuestionsSubcategory();
            
			$subCategories = $QuestionsSubcategory->find('first', array(
	    		'recursive' => -1,
	    		'conditions' => array(
	    			'question_id' => $questionId
	    			)
	    		)
	    	);
			// Iterate each subcategories
			foreach($subCategories as $subCategory){
                $progressRow = $this->find('first', array(
                    'recursive' => -1,
                    'conditions' => array(
                        'person_id' => $personId,
                        'sub_category_id' => $subCategory['subcategory_id'],
                        'date <= ' => date('Y-m-d').' 23:59:59',
                        'date >= ' => date('Y-m-d').' 00:00:00',
                    ),
                ));
                
				// if exits
				if(!empty($progressRow)){
                    // $progressRow = $progressRow[0];
					$currentDate = date('Ymd');
					$dbDate = date('Ymd', strtotime($progressRow['Progress']['date']));

					// equal to current date, update new data
					if(strtotime($currentDate) == strtotime($dbDate)){
						$this->query(
							'update progresses Progress'.
                            ' set Progress.progress = '.($progressRow['Progress']['progress'] + $data['correct']).
								', Progress.total = '.($progressRow['Progress']['total'] + 1).
								', date = now()'.
							' where person_id = '.$personId.
				            ' and sub_category_id = '.$subCategory['subcategory_id'].
                            ' and date(date) = date(now())'
							);
					}
					// if it is a new day, insert to database
					else{
						$this->set(array(
							'person_id' => $personId,
							'sub_category_id' => $subCategory['subcategory_id'],
							'progress' => $data['correct'],
							'total' => 1,
							'date' => date('Y-m-d H:i:s')
						));
						$this->save();
                        $this->clear();
					}
				}
				// else it is not exist, insert
				else{
					$this->set(array(
						'person_id' => $personId,
						'sub_category_id' => $subCategory['subcategory_id'],
						'progress' => $data['correct'],
						'total' => 1,
						'date' => date('Y-m-d H:i:s')));
					$this->save();
                    $this->clear();
				}
			}
		}
	}
/*
 * get progress data from db, convert to json for ajax called for d3.js
 * @param: personId
 * @return: json after encode
 */	
	public function ajaxD3($personId){
		// query
		$results =  $this->query(
			'select Category.name, Subcategory.name as name, sum(Progress.progress) as progress, sum(Progress.total) as total
			from progresses Progress
			join subcategories Subcategory
				on Progress.sub_category_id = Subcategory.id
			join categories Category
				on Subcategory.category_id = Category.id
			where Progress.person_id = '.$personId. 
			' group by sub_category_id '
			
		);

		// convert CakePHP's array to json
		$json = array();
        $json[] = array('name' => 'Overall', 'parent' => 'null', 'value' => 0);
        $json[] = array('name' => 'Maths', 'parent' => 'Overall', 'value' => 0);
		$json[] = array('name' => 'Physics', 'parent' => 'Overall', 'value' => 0);
        if(!empty($results)){
            foreach($results as $result){
                $row = array();
                $row['name'] = $result['Subcategory']['name'];
                $row['parent'] = $result['Category']['name'];
                $row['value'] = round($result[0]['progress']/$result[0]['total']*100,2);
                $json[] = $row;
            }
        }
		return json_encode($json);
	}

/*
 * get ALL data from db, convert to json for ajax called for d3.js
 * @param: personId
 * @return: json after encode
 * SUSPEND
 */
    
/**
 * get data for chart google
 * @param personId
 * @return json after encoded
 */
    public function chartGoogle($personId){
        //query
        $results = $this->query(
            'select SUM(Progress.progress) as progress, SUM(Progress.total) as total, Category.name, Progress.date
            from progresses Progress
            join subcategories Subcategory
                on Progress.sub_category_id = Subcategory.id
            join categories Category
                on Category.id = Subcategory.category_id
                where Progress.person_id = '.$personId.
                ' group by date(Progress.date)
                order by Progress.date asc'
                
		);
        
        // json string to return
        $json = array();
        
        // counters
        $progress = 0;
        $total = 0;
        $json[] = array('YEAR', 'Physics');
        if($results){
            foreach($results as $result){
                $row = array();
                $row[] = $result['Progress']['date'];
                $progress += $result[0]['progress'];
                $total += $result[0]['total'];
                $row[] = $progress/$total;
                $json[] = $row;
            }
        }
        if(sizeof($json) == 1){
            $json[] = array(0,0);
        }
        
        return json_encode($json);        
    }

/**
 * get progress on subjects for a person
 * @param   person_id
 * @return  progresses of subjects
 */
    public function progressOnSubject($person_id){

        // virtual fields sum of progress and total
        $this->virtualFields['sum_progress'] = 'SUM(Progress.progress)';
        $this->virtualFields['sum_total'] = 'SUM(Progress.total)';

        $results = $this->find('all',array(
            'joins' => array(
                array(
                    'type' => 'inner',
                    'table' => 'categories',
                    'alias' => 'Category',
                    'conditions' => array(
                        'Subcategory.category_id = Category.id' 
                        )
                    ),
                array(
                    'type' => 'inner',
                    'table' => 'subjects',
                    'alias' => 'Subject',
                    'conditions' => array(
                        'Subject.id = Category.subject_id' 
                    )
                )
            ),
            'group' => array(
                'Subject.id'
            ),
            'fields' => array(
                'Progress.sum_progress',
                'Progress.sum_total',
                'Progress.date',
                'Subject.name',
                'Subject.id'
            ),
            'conditions' => array(
                'Progress.person_id = '.$person_id
            ),
        ));

        return $results;
    }
/**
 * get progress on categories of a subject for a person
 * @param   person_id
 *          subject_id
 * @return  progresses of categories
 */
    public function progressOnCategory($person_id, $subject_id){

        // virtual fields sum of progress and total
        $this->virtualFields['sum_progress'] = 'SUM(Progress.progress)';
        $this->virtualFields['sum_total'] = 'SUM(Progress.total)';

        $results = $this->find('all',array(
            'joins' => array(
                array(
                    'type' => 'inner',
                    'table' => 'categories',
                    'alias' => 'Category',
                    'conditions' => array(
                        'Subcategory.category_id = Category.id' 
                    )
                ),
                array(
                    'type' => 'inner',
                    'table' => 'subjects',
                    'alias' => 'Subject',
                    'conditions' => array(
                        'Category.subject_id = Subject.id' 
                    )
                ),
            ),
            'group' => array(
                'Category.id'
            ),
            'fields' => array(
                'Progress.sum_progress',
                'Progress.sum_total',
                'Progress.date',
                'Category.name',
                'Category.id',
                'Subject.id'
            ),
            'conditions' => array(
                'Progress.person_id = '.$person_id,
                'Category.subject_id = '.$subject_id
            ),
        ));

        return $results;
    }
/**
 * get progress on subcategories of a category for a person
 * @param   person_id
 *          category_id
 * @return  progresses of Subcategories
 */
    public function progressOnSubcategory($person_id, $category_id){

        // virtual fields sum of progress and total
        $this->virtualFields['sum_progress'] = 'SUM(Progress.progress)';
        $this->virtualFields['sum_total'] = 'SUM(Progress.total)';

        $results = $this->find('all',array(
            'joins' => array(
                array(
                    'type' => 'inner',
                    'table' => 'categories',
                    'alias' => 'Category',
                    'conditions' => array(
                        'Subcategory.category_id = Category.id' 
                    )
                ),
                array(
                    'type' => 'inner',
                    'table' => 'subjects',
                    'alias' => 'Subject',
                    'conditions' => array(
                        'Category.subject_id = Subject.id' 
                    )
                ),
            ),
            'fields' => array(
                'Progress.sum_progress',
                'Progress.sum_total',
                'Progress.date',
                'Subcategory.name',
                'Subcategory.id',
                'Subject.id'
            ),
            'group' => array(
                'Subcategory.id'
            ),
            'conditions' => array(
                'Progress.person_id = '.$person_id,
                'Subcategory.category_id = '.$category_id
            ),
        ));

        return $results;
    }
}
