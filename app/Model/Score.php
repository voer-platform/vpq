<?php
App::uses('AppModel', 'Model');
App::import('Model', 'Answer');
App::import('Model', 'ScoresQuestion');

/**
 * Score Model
 *
 */
class Score extends AppModel {

    //The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
    public $belongsTo = array(
        'Test' => array(
            'className' => 'Test',
            'foreignKey' => 'test_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Person' => array(
            'className' => 'Person',
            'foreignKey' => 'person_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
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
            'joinTable' => 'scores_questions',
            'foreignKey' => 'score_id',
            'associationForeignKey' => 'question_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

/**
 * save a score
 * @param     id of score
 *            id of the test that score based on
 *            id of user
 *            score, on scale
 *            duration taken
 *            time taken
 * @return     void
 */
    public function saveScore($scoreId, $testId, $user, $score, $duration, $timeTaken){
        $this->set(array(
                'id' => $scoreId,
                'test_id' => $testId,
                'person_id' => $user,
                'score' => $score,
                'duration' => $duration,
                'time_taken' => $timeTaken
                ));
        $this->save();
    }
/**
 * get all user
 * @param id of user
 * @return list of score
 */
    public function getAllScores($personId, $limit = 0){
        $this->unBindModel(array ('hasAndBelongsToMany' => 'Question', 'belongsTo' => 'Person'));

        return $this->find('all', array(
                'conditions' => array(
                    'Score.person_id' => $personId,    
                ),
                'order' => array('time_taken' => 'desc'),
                'limit' => $limit == 0? 10 : $limit
            ));
    }

/**
 * get score for one subcategory
 * @param     id of user
 *            id of subcategory
 */
    public function getScoresForSubcategory($personId, $subcategory_id){
        $this->unBindModel(array ('hasAndBelongsToMany' => 'Question', 'belongsTo' => 'Person'));

        $_scoreIDs = $this->query("select ScoresQuestion.score_id
            from scores_questions as ScoresQuestion
            join questions_subcategories as QuestionsSubcategory
                on ScoresQuestion.question_id = QuestionsSubcategory.question_id
            where QuestionsSubcategory.subcategory_id = ".$subcategory_id.
            " "
            );    

        $scoreIDs = array();
        foreach ($_scoreIDs as $score) {
            $scoreIDs[] = $score['ScoresQuestion']['score_id'];
        };

        return $this->find('all', array(
                'conditions' => array(
                    'Score.person_id' => $personId,
                    'Score.id' => $scoreIDs    
                ),
                'order' => array('time_taken' => 'desc')
            ));
    }

/**
 * get next ScoreID
 * @return: next will be stored scoreID
 */
    public function getNextScoreId(){
        $score = $this->find('first', array(
                'recursive' => -1,
                'limit' => 1,
                'fields' => array('id'),
                'order' => 'id DESC'
                ));
        $score = array_filter($score);
        if( !empty($score) ){
            $scoreID = $score['Score']['id'] + 1;
        }
        else {
            $scoreID = 1;
        }
        return $scoreID;
    }
/**
 * evaluate score for one user
 * @param:
 *      in: testId - id of the test
 *    in: answers: array() - array of answer from user
 *    in: user - user
 *    out: scoreData
 *    in: numboerOfQuestions - number of questions
 * @return id of stored score 
 *        
 */
    public function calculateScore($testId, $answers, $user, &$scoreData, $numberOfQuestions){
        //check if answer is right or not
        $correctCounter = 0;

        // filter empty-answered questions
        // user did not tick in the answer
        function emptyAnswerFilter($var){
             // remove with int(0)
             return ($var !== '') || ($var == '0');
        }
        
        $duration = $answers['duration'];

        // array after filter empty
        $filteredArray = array_filter($answers,'emptyAnswerFilter');

        // get row in array, key=question_id, value=>answer_id
        foreach ( $filteredArray as $question => $answerId) {
            
            // there are some hidden fields, need to confirm that field is test's id or not
            if(!is_numeric($question))
                continue;

            $Answer = new Answer();
            $result = $Answer->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'question_id' => $question,
                    'Answer.order' => $answerId         // the answer has order(0 to 3) corresspond to question
                    )
                ));
            // count correct questions
            $scoreData[$question] = array();
            $scoreData[$question]['answer'] = $answerId;

            if( $result['Answer']['correctness'] == 1){
                $correctCounter++;
                $scoreData[$question]['correct'] = 1;
            }
            else{
                $scoreData[$question]['correct'] = 0;
            }
            
        }

        if(!empty($user)){
            // save score to db
            $scoreId = $this->getNextScoreId();
            $this->saveScore($scoreId, $testId, $user['id'], $correctCounter, $duration, date("Y-m-d H:i:s"));
        }

        // save score_question
          $scoreQuestionData = array();

        // sort the question on id filed so that data is consistent
        ksort($answers);
        // we use filteredArray to remove hidden/non-question elements
        foreach($answers as $question => $answer){
            // there are some hidden fields, need to confirm that field is test's id or not
            if(!is_numeric($question))
                continue;
            $scoreQuestionData[] = array('score_id' => $scoreId, 'question_id' => $question, 'answer' => $answer );
        }

        $ScoresQuestion = new ScoresQuestion();
        $ScoresQuestion->saveAll($scoreQuestionData);

        return $scoreId;
    }

/**
 * get score for draw chart using Google Chart API
 *    @param user id
 *    @return json_encode string
 */
    public function getScoresForChart($person_id, $subject_id){
        $this->unBindModel(array ('hasAndBelongsToMany' => 'Question'));
        $this->virtualFields['score'] = 'SUM(Score.score)';    
        $this->virtualFields['number_questions'] = 'SUM(Test.number_questions)';
        $this->virtualFields['date'] = 'DATE(Score.time_taken)';

        // specific subject
        if($subject_id != 0 ){
            $results = $this->find('all', array(
                'joins' => array(
                    array(
                        'type' => 'LEFT',
                        'table' => 'tests_subjects',
                        'alias' => 'TestSubject',
                        'conditions' => array(
                            'TestSubject.test_id = Score.test_id'
                        )
                    ),
                ),
                'fields' => array(
                        'Score.score',
                        'Test.number_questions',
                        'Score.date'
                ),
                'conditions' => array(
                    'TestSubject.subject_id = '.$subject_id,
                    'Score.person_id = '.$person_id),
                'order' => array(
                    'Score.date desc'
                ),
                'group' => array(
                    'Score.date'
                ),
                'limit' => 10
            ));
        }
        // all subject
        else{
            $results = $this->find('all', array(
                'fields' => array(
                        'Score.score',
                        'Test.number_questions',
                        'Score.date'
                ),
                'conditions' => array(
                    'Score.person_id = '.$person_id),
                'order' => array(
                    'Score.date desc'
                ),
                'group' => array(
                    'Score.date'
                ),
                'limit' => 10
            ));
        }
        $results = array_reverse($results);
        
        $json = array();
        $json[] = array(__('Date'), __('Physics'));
        if($results){
            foreach ($results as $result) {
                $date = $this->translateDate(date('D', strtotime($result['Score']['date'])));
                $json[] = array($date, round($result['Score']['score']/$result['Score']['number_questions'], 2)*10);
            }
        }

        return json_encode($json);
    }
/**
 * translate day of week short into full and translated string
 *    @param    dow(Sun, Mon, etc.)
 *    @return   dow(__('Sunday'), __('Monday'))
 */
    public function translateDate($date){
        switch ($date) {
            case 'Sun':
                return __('Sunday');
                break;
            case 'Mon':
                return __('Monday');
                break;
            case 'Tue':
                return __('Tuesday');
                break;
            case 'Wed':
                return __('Wednesday');
                break;
            case 'Thu':
                return __('Thursday');
                break;
            case 'Fri':
                return __('Friday');
                break;
            case 'Sat':
                return __('Saturday');
                break;
            
            default:
                return __('None');
                break;
        }
    }

/**
 * get average performance for a person on latest 10 tests
 * @param:  id of user
 *          grade
 *          subject
 *          number of tests
 * @return: array of [correct, total]
 */
    public function getOverAll($person_id, $grade_id=0, $subject_id=0, $tests=10){
        
        // no option declared
        // return all subjects and grades
        if($grade_id == 0 && $subject_id == 0){
            $results = $this->find('all', array(
                'fields' => array(
                    'Score.score',
                    'Test.number_questions'
                    ),
                'conditions' => array(
                    'Score.person_id = '.$person_id),
                'order' => array(
                    'Score.time_taken desc'),
                'limit' => $tests
                ));
        }
        // if subject is given, not grade
         // return all grades, specific subject
        else if($grade_id == 0 && $subject_id != 0){
            $results = $this->find('all', array(
                'fields' => array(
                    'Score.score',
                    'Test.number_questions'
                    ),
                'joins' => array(
                    array(
                        'type' => 'LEFT',
                        'table' => 'tests_subjects',
                        'alias' => 'TestSubject',
                        'conditions' => array(
                            'TestSubject.id = Score.test_id' 
                            )
                        ),
                    ),
                'conditions' => array(
                    'Score.person_id = '.$person_id,
                    'TestSubject.subject_id = '.$subject_id),
                'order' => array(
                    'Score.time_taken desc'),
                'limit' => $tests
                ));
        }
        // if grade is given, not subject
        // return all grades, specific subject
        else if($grade_id != 0 && $subject_id == 0){
            $results = $this->find('all', array(
                'fields' => array(
                    'Score.score',
                    'Test.number_questions'
                    ),
                'joins' => array(
                    array(
                        'type' => 'LEFT',
                        'table' => 'tests_subjects',
                        'alias' => 'TestSubject',
                        'conditions' => array(
                            'TestSubject.id = Score.test_id' 
                            )
                        ),
                    array(
                        'type' => 'LEFT',
                        'table' => 'scores_questions',
                        'alias' => 'ScoresQuestion',
                        'conditions' => array(
                            'Score.id = ScoresQuestion.score_id' 
                            )
                        ),
                    array(
                        'type' => 'LEFT',
                        'table' => 'questions_subcategories',
                        'alias' => 'QuestionsSubcategory',
                        'conditions' => array(
                            'ScoresQuestion.question_id = QuestionsSubcategory.question_id'
                            )
                        ),
                    array(
                        'type' => 'LEFT',
                        'table' => 'subcategories',
                        'alias' => 'QuestionsSubcategory',
                        'conditions' => array(
                            'Subcategory.id = QuestionsSubcategory.subcategory_id'
                            )
                        ),
                    array(
                        'type' => 'LEFT',
                        'table' => 'categories',
                        'alias' => 'Category',
                        'conditions' => array(
                            'Category.id = Subcategory.category_id'
                            )
                        ),
                    ),
                'conditions' => array(
                    'Score.person_id = '.$person_id,
                    'Category.grade_id = '.$grade_id),
                'order' => array(
                    'Score.time_taken desc'),
                'limit' => $tests
                ));
        }
        // both declared
        // given both grade and subject
        else {
            $results = $this->find('all', array(
                'fields' => array(
                    'Score.score',
                    'Test.number_questions'
                    ),
                'joins' => array(
                    array(
                        'type' => 'LEFT',
                        'table' => 'tests_subjects',
                        'alias' => 'TestSubject',
                        'conditions' => array(
                            'TestSubject.id = Score.test_id' 
                            )
                        ),
                    array(
                        'type' => 'LEFT',
                        'table' => 'tests_subjects',
                        'alias' => 'TestSubject',
                        'conditions' => array(
                            'TestSubject.id = Score.test_id' 
                            )
                        ),
                    array(
                        'type' => 'LEFT',
                        'table' => 'scores_questions',
                        'alias' => 'ScoresQuestion',
                        'conditions' => array(
                            'Score.id = ScoresQuestion.score_id' 
                            )
                        ),
                    array(
                        'type' => 'LEFT',
                        'table' => 'questions_subcategories',
                        'alias' => 'QuestionsSubcategory',
                        'conditions' => array(
                            'ScoresQuestion.question_id = QuestionsSubcategory.question_id'
                            )
                        ),
                    array(
                        'type' => 'LEFT',
                        'table' => 'subcategories',
                        'alias' => 'QuestionsSubcategory',
                        'conditions' => array(
                            'Subcategory.id = QuestionsSubcategory.subcategory_id'
                            )
                        ),
                    array(
                        'type' => 'LEFT',
                        'table' => 'categories',
                        'alias' => 'Category',
                        'conditions' => array(
                            'Category.id = Subcategory.category_id'
                            )
                        ),
                    ),
                'conditions' => array(
                    'Score.person_id = '.$person_id,
                    'Category.grade_id = '.$grade_id,
                    'TestSubject.subject_id = '.$subject_id),
                'order' => array(
                    'Score.time_taken desc'),
                'limit' => $tests
                ));
        }
        
        $score = 0;
        $total = 0;
        if($results){
            foreach ($results as $result) {
                $score += $result['Score']['score'];
                $total += $result['Test']['number_questions'];
            }
            return array($score, $total);
        }
        else{
            return array(0,0);
        }
    }
/**
 * return ajax call for user
 * @param:  id of user
 *          grade
 *          subject
 *          category
 * @return: array of score[correct, total]
 *          array of chart[score, date]
 */
    public function ajaxCall($person_id, $subject_id = null, $grade_id = null, $category_id = null){
        $this->virtualFields['sum_score'] = 'SUM(Score.score)';    
        $this->virtualFields['sum_number_questions'] = 'SUM(Test.number_questions)';
        $this->virtualFields['date'] = 'DATE(Score.time_taken)';

        $options = array(
            'joins' => array(
                array(
                    'type' => 'LEFT',
                    'table' => 'scores_questions',
                    'alias' => 'ScoresQuestion',
                    'conditions' => array(
                        'ScoresQuestion.score_id = Score.id' 
                        )
                    )
            ),
            'fields' => array(
                'Score.sum_score',
                'Score.sum_number_questions',
                'Score.date'
                ),
            'conditions' => array(
                'Score.person_id = '.$person_id),
            'order' => array(
                'Score.date desc'
                ),
            'group' => array(
                'Score.date'
                ),
            'limit' => 10
            );

        if(!is_null($subject_id)){
            $options['joins'][] = array(
                'type' => 'LEFT',
                'table' => 'tests_subjects',
                'alias' => 'TestSubject',
                'conditions' => array(
                    'TestSubject.id = Score.test_id' 
                    )
                );
            $options['conditions']['TestSubject.subject_id'] = $subject_id;  
        }

        if(!is_null($grade_id) || !is_null($category_id)){
            $options['joins'][] = array(
                'type' => 'LEFT',
                'table' => 'questions_subcategories',
                'alias' => 'QuestionsSubcategory',
                'conditions' => array(
                    'ScoresQuestion.question_id = QuestionsSubcategory.question_id' 
                    )
                );
            $options['joins'][] = array(
                'type' => 'LEFT',
                'table' => 'subcategories',
                'alias' => 'Subcategory',
                'conditions' => array(
                    'QuestionsSubcategory.subcategory_id = Subcategory.id' 
                    )
                );
            $options['joins'][] = array(
                'type' => 'LEFT',
                'table' => 'categories',
                'alias' => 'Category',
                'conditions' => array(
                    'Category.id = Subcategory.category_id' 
                    )
                );
            if(!is_null($grade_id)){
                if(is_array($grade_id)){
                    $options['conditions']['Category.grade_id in'] = explode(',', $grade_id);
                }
                else{
                    $options['conditions']['Category.grade_id'] = explode(',', $grade_id);
                }
            } 
            if(!is_null($category_id)){
                $options['conditions']['Category.id '] = $category_id;
            }
        }

        // scores for chart
        $charts = $this->find('all', $options);

        $results['chart'] = array();
        $score = 0;
        $total = 0;

        // iterate, get chart lines
        $results['chart'][] = array(__('Date'), __('Score'));
        if($charts){
            foreach ($charts as $chart) {
                $score  += (int)$chart['Score']['sum_score'];
                $total  += (int)$chart['Score']['sum_number_questions'];
                $date    = $this->translateDate(date('D', strtotime($chart['Score']['date'])));
                $results['chart'][] = array($date, round($chart['Score']['sum_score']/$chart['Score']['sum_number_questions'], 3)*10);
            }
        }
        else{
            $results['chart'][] = array('0', 0);
        }

        // calculate score
        if($total != 0)
            $results['score'] = round($score/$total, 3)*10;
        else
            $results['score'] = 0.0;

        $dbo = $this->getDatasource();
        $logs = $dbo->getLog();
        $lastLog = end($logs['log']);
        $results['query'] = $lastLog['query'];

        return ($results);        
    }

}
