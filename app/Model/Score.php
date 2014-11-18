<?php
App::uses('AppModel', 'Model');
App::import('Model', 'Answer');
App::import('Model', 'ScoresQuestion');

/**
 * Score Model
 *
 * @property Test $Test
 * @property Person $Person
 * @property Question $Question
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
/*
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

/*
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
            // store correctness to scoreData for calculate progress
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
        // specific subject
        if($subject_id != 0 ){
             $results = $this->query(
                'select * from scores Score
                 join tests Test
                   on Test.id = Score.test_id
                 join tests_subjects TestsSubject
                   on TestsSubject.test_id = Score.test_id
                 where Score.person_id = '.$person_id.' '.
                 'and TestsSubject.subject_id = '.$subject_id.' '.
                 'order by Score.time_taken desc
                  limit 10;');
        }
        // all subject
        else{
            $results = $this->query(
                'select * from scores Score
                 join tests Test
                   on Test.id = Score.test_id
                 join tests_subjects TestsSubject
                   on TestsSubject.test_id = Score.test_id
                 where Score.person_id = '.$person_id.' '.
                 'order by Score.time_taken desc
                  limit 10;');
        }
        $results = array_reverse($results);
        
        $json = array();
        $json[] = array(__('Date'), __('Score'));
        if($results){
            foreach ($results as $result) {
                $json[] = array(date('d/m/y h:i', strtotime($result['Score']['time_taken'])), round($result['Score']['score']/$result['Test']['number_questions'], 2));
            }
        }

        return json_encode($json);
    }

/**
 * get average performance latest 10 tests
 * @param:  id of user
 *            grade
 *            subject
 *            number of tests
 * @return: array of [correct, total]
 */
    public function overall($person_id, $grade_id=0, $subject_id=0, $tests=10){
        
        // no option declared
        // return all subjects and grades
        if($grade_id == 0 && $subject_id == 0){
            $results = $this->query(
                'select Score.id, Score.score, Test.number_questions from scores Score
                join tests Test
                    on Test.id = Score.test_id
                where Score.person_id = '.$person_id.' '.
                'order by Score.time_taken desc
                limit '.$tests.';');
        }
        // if subject is given, not grade
         // return all grades, specific subject
        else if($grade_id == 0 && $subject_id != 0){
            $results = $this->query(
                'select Score.id, Score.score, Test.number_questions from scores Score
                join tests Test
                    on Test.id = Score.test_id
                join tests_subjects TestsSubject
                    on TestsSubject.test_id = Score.test_id
                where Score.person_id = '.$person_id.' '.
                    'and TestsSubject.subject_id = '.$subject_id.' '.
                'order by Score.time_taken desc
                limit '.$tests.';');
        }
        // if grade is given, not subject
        // return all grades, specific subject
        else if($grade_id != 0 && $subject_id == 0){
            $results = $this->query(
                'select Score.id, Score.score, Test.number_questions from scores Score
                join tests Test
                    on Test.id = Score.test_id
                join scores_questions ScoresQuestion
                    on Score.id = ScoresQuestion.score_id
                join questions_subcategories QuestionsSubcategory
                    on ScoresQuestion.question_id = QuestionsSubcategory.question_id
                join subcategories Subcategory
                    on Subcategory.id = QuestionsSubcategory.subcategory_id
                join categories Category
                    on Category.id = Subcategory.category_id
                where Score.person_id = '.$person_id.' '.
                    'and Category.grade_id = '.$grade_id.' '.
                'group by Score.id
                order by Score.time_taken desc
                limit '.$tests.';');
        }
        // both declared
        // given both grade and subject
        else {
            $results = $this->query(
                'select Score.id, Score.score, Test.number_questions from scores Score
                join tests Test
                    on Test.id = Score.test_id
                join scores_questions ScoresQuestion
                    on Score.id = ScoresQuestion.score_id
                join questions_subcategories QuestionsSubcategory
                    on ScoresQuestion.question_id = QuestionsSubcategory.question_id
                join subcategories Subcategory
                    on Subcategory.id = QuestionsSubcategory.subcategory_id
                join categories Category
                    on Category.id = Subcategory.category_id
                where Score.person_id = '.$person_id.' '.
                    'and Category.grade_id = '.$grade_id.' '.
                    'and Test.subject_id = '.$subject_id.' '.
                'group by Score.id
                order by Score.time_taken desc
                limit '.$tests.';');
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
            return 0;
        }
    }    
}
