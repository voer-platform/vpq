<?php
App::uses('AppModel', 'Model');
/**
 * Test Model
 *
 * @property Score $Score
 * @property Question $Question
 * @property Subject $Subject
 */
class Test extends AppModel {


    //The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array(
        'Score' => array(
            'className' => 'Score',
            'foreignKey' => 'test_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
    public $hasAndBelongsToMany = array(
        'Question' => array(
            'className' => 'Question',
            'joinTable' => 'tests_questions',
            'foreignKey' => 'test_id',
            'associationForeignKey' => 'question_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'Subject' => array(
            'className' => 'Subject',
            'joinTable' => 'tests_subjects',
            'foreignKey' => 'test_id',
            'associationForeignKey' => 'subject_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

    /*
     * generate test
     * @params: number of question, time limit, category
     * @return: a test correspond to input parameters
     */
    public function genTest($numberOfQuestions, $timeLimit, $subjectId){
        $this->Question->unBindModel( array('hasMany' => array('Score')) );
        $_results = $this->Question->find('all', array(
                    'limit' => $numberOfQuestions,
                    'order' => 'rand()'
                ));
        $results = Set::sort($_results, '{n}.Question.id', 'asc');
        return $results;
    }

    /**
     * Generate test with number of questions and category id
     *
     * @param  [type] $numberOfQuestions [description]
     * @param  [type] $categoryId        [description]
     * @return [type]                    [description]
     */
    /*public function generateTest($numberOfQuestions, $categories){
        $this->Question->unBindModel( array('hasAndBelongsToMany' => array('Score', 'Test')) );

        $_results = $this->Question->find('all', array(
                    'limit' => $numberOfQuestions,
                    'order' => 'rand()',
                    'conditions' => array('Subcategory.subcategory_id' => $categories),
                    'joins'=>array(
                        array(
                            'type'=>'LEFT',
                            'table'=>'questions_subcategories',
                            'alias'=>'Subcategory',
                            'conditions'=>array(
                                'Question.id = Subcategory.question_id'
                            )
                        )
                    )
                ));
		
        $results = Set::sort($_results, '{n}.Question.id', 'asc');
		$id_question2=array();
		foreach($_results as $rs2){
			$id_question2[]=$rs2['Question']['id'];
		}
		pr($id_question2);
		exit();
        return $results;
    }*/
	
	//lấy câu hỏi với tỉ lệ 40% tổng số câu là câu ít được lựa chọn nhất
	/*public function generateTest($numberOfQuestions, $categories, $score){ 
		$numberOfQuestions1=$numberOfQuestions*0.4;
		$numberOfQuestions2=$numberOfQuestions-$numberOfQuestions1;
        $this->Question->unBindModel( array('hasAndBelongsToMany' => array('Score', 'Test')) );
		$_results1=$this->Question->find('all', array(
					'fields'=>array('DISTINCT `Question`.`id`','`Question`.`count`','`Question`.`content`'),
                    'limit' => $numberOfQuestions1,
                    'order' => array('Question.count'=>'asc'),
                    'conditions' => array('Subcategory.subcategory_id' => $categories, 'Question.status' => 1),
                    'joins'=>array(
                        array(
                            'type'=>'LEFT',
                            'table'=>'questions_subcategories',
                            'alias'=>'Subcategory',
                            'conditions'=>array(
                                'Question.id = Subcategory.question_id'
                            )
                        )
                    )
                ));
		$id_question=array();
		foreach($_results1 as $rs){
			$id_question[]=$rs['Question']['id'];
		};

        $_results = $this->Question->find('all', array(
					'fields'=>array('DISTINCT `Question`.`id`','`Question`.`count`','`Question`.`content`'),
                    'limit' => $numberOfQuestions2,
                    'order' => 'rand()',
                    'conditions' => array(
											array('Subcategory.subcategory_id' => $categories, 'Question.status' => 1),
											'NOT'=>array(														
														'Question.id'=> $id_question,
											),											
										),
                    'joins'=>array(
                        array(
                            'type'=>'LEFT',
                            'table'=>'questions_subcategories',
                            'alias'=>'Subcategory',
                            'conditions'=>array(
                                'Question.id = Subcategory.question_id'
                            )
                        )
                    )
                ));

		foreach($_results1 as $rs1){
			$_results[]=$rs1;
		}

        $results = Set::sort($_results, '{n}.Question.id', 'asc');
        return $results;
    }*/
	
	//lấy câu hỏi dựa vào điểu của người sử dụng
	public function generateTest($numberOfQuestions, $categories, $score){
		$denta1=$score-2;
		$denta2=$score+2;
		$numberOfQuestions1=$numberOfQuestions*0.4;
		$numberOfQuestions2=$numberOfQuestions-$numberOfQuestions1;
        $this->Question->unBindModel( array('hasAndBelongsToMany' => array('Score', 'Test')) );
		$_results1=$this->Question->find('all', array(
					'fields'=>array('DISTINCT `Question`.`id`','`Question`.`count`','`Question`.`content`'),
                    'limit' => $numberOfQuestions1,
					'order' => 'rand()',
                    'conditions' => array('Subcategory.subcategory_id' => $categories, 'Question.status' => 1, "Question.difficulty<='$score'", "Question.difficulty>='$denta1'"),
                    'joins'=>array(
                        array(
                            'type'=>'LEFT',
                            'table'=>'questions_subcategories',
                            'alias'=>'Subcategory',
                            'conditions'=>array(
                                'Question.id = Subcategory.question_id'
                            )
                        )
                    )
                ));
		$id_question=array();
		foreach($_results1 as $rs){
			$id_question[]=$rs['Question']['id'];
		};
		
		$_results2=$this->Question->find('all', array(
					'fields'=>array('DISTINCT `Question`.`id`','`Question`.`count`','`Question`.`content`'),
                    'limit' => $numberOfQuestions2,
					'order' => 'rand()',
                    'conditions' => array('Subcategory.subcategory_id' => $categories, 'Question.status' => 1, "Question.difficulty<='$denta2'", "Question.difficulty>'$score'"),
                    'joins'=>array(
                        array(
                            'type'=>'LEFT',
                            'table'=>'questions_subcategories',
                            'alias'=>'Subcategory',
                            'conditions'=>array(
                                'Question.id = Subcategory.question_id'
                            )
                        )
                    )
                ));
				
		foreach($_results2 as $rs){
			$id_question[]=$rs['Question']['id'];
		};

		if(count($_results1)+count($_results2)<$numberOfQuestions)
		{
			$numberOfQuestions3 = $numberOfQuestions - count($_results1) - count($_results2);
			$_results = $this->Question->find('all', array(
					'fields'=>array('DISTINCT `Question`.`id`','`Question`.`count`','`Question`.`content`'),
                    'limit' => $numberOfQuestions3,
                    'order' => array('Question.count'=>'asc'),
                    'conditions' => array(
											array('Subcategory.subcategory_id' => $categories, 'Question.status' => 1),
											'NOT'=>array(														
														'Question.id'=> $id_question,
											),											
										),
                    'joins'=>array(
                        array(
                            'type'=>'LEFT',
                            'table'=>'questions_subcategories',
                            'alias'=>'Subcategory',
                            'conditions'=>array(
                                'Question.id = Subcategory.question_id'
                            )
                        )
                    )
                ));

			foreach($_results1 as $rs1){
				$_results[]=$rs1;
			}
			
			foreach($_results2 as $rs2){
				$_results[]=$rs2;
			}
		}else{
			$_results = array();
			
			foreach($_results1 as $rs1){
				$_results[]=$rs1;
			}
			
			foreach($_results2 as $rs2){
				$_results[]=$rs2;
			}
		}

        $results = Set::sort($_results, '{n}.Question.id', 'asc');
        return $results;
    }

    /**
     * Generate test with test_id
     * 
     * @param: [int] $test_id [test id of the test]
     * @return: [array] list of questions
     */
    public function generateTestId($test_id){
        $tqs = $this->TestsQuestion->find('all', array(
            'conditions' => array('TestsQuestion.test_id' => $test_id),
            'recursive' => -1
            ));

        $q = [];
        foreach ($tqs as $tq) {
            $q[] = $tq['TestsQuestion']['question_id'];
        }

        $this->Question->unBindModel( array('hasAndBelongsToMany' => array('Score', 'Test')) );
        $_results = $this->Question->find('all', array(
                    'conditions' => array('Question.id' => $q),
                ));
        $results = Set::sort($_results, '{n}.Question.id', 'asc');
        return $results;
    }

    /*
     * nextTestID
     * @return: next Test ID
     *
     */
    public function nextTestId(){
        $test = $this->find('first', array(
                'recursive' => -1,
                'limit' => 1,
                'fields' => array('id'),
                'order' => 'id DESC'
                ));
        $test = array_filter($test);
        if( !empty($test) ){
            $testID = $test['Test']['id'] + 1;
        }
        else {
            $testID = 1;
        }
        return $testID;
    }

    /*
     * saveTest
     * @param: test parameters
     *
     */
    public function saveTest($id, $timeLimit, $numberOfQuestions, $allowAttemps, $subjectId){
        $this->set(array(
                'id' => $id,
                'time_limit' => $timeLimit,
                'allow_attempts' => -1,
                'number_questions' => $numberOfQuestions,
            ));
        $this->save();

        $this->save(array(
            'Test' => array('id' => $id),
            'Subject' => array('id' => $subjectId)
            ));
    }
}
