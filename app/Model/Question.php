<?php
App::uses('AppModel', 'Model');
/**
 * Question Model
 *
 * @property Answer $Answer
 * @property Subcategory $Subcategory
 * @property Score $Score
 * @property Test $Test
 */
class Question extends AppModel {
	public $primaryKey = 'id';

    //The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array(
        'Answer' => array(
            'className' => 'Answer',
            'foreignKey' => 'question_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'question_id',
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
        'Subcategory' => array(
            'className' => 'Subcategory',
            'joinTable' => 'questions_subcategories',
            'foreignKey' => 'question_id',
            'associationForeignKey' => 'subcategory_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
         'Subcategory2' => array(
            'className' => 'Subcategory',
            'joinTable' => 'questions_subcategories',
            'foreignKey' => 'question_id',
            'associationForeignKey' => 'subcategory2_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'Score' => array(
            'className' => 'Score',
            'joinTable' => 'scores_questions',
            'foreignKey' => 'question_id',
            'associationForeignKey' => 'score_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
        'Test' => array(
            'className' => 'Test',
            'joinTable' => 'tests_questions',
            'foreignKey' => 'question_id',
            'associationForeignKey' => 'test_id',
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
     * get questions from ids
     * @param: id list
     * @return: questions list
     */
    public function getQuestionsFromIds($ids){
        $this->unBindModel( array('hasAndBelongsToMany' => array('Test', 'Score', 'Subcategory')) );
        return $this->find('all', array(
            'recursive' => 1,
            'contain' => true,
            'conditions' => array(
                'id' => $ids
                )
            ));
    }

    /**
 * process mass import data
 * @param:     request data
 *             path to folder contain files [data.txt, [attachments]]
 *
 * @return: true if success
 *            false if fail
 */    
    public function processMassImport($data, $path){
        
        // patterns for split
        $patternQuestionID          = '[{q]';
        $patternQuestionContent     = '[{c]'; 
        $patternAttachment          = '<{t}';
        $patternAnswers             = '([a])';
        $patternAnswer              = '([a)';
        $patternAnswerCorrect       = '([c)';

        // each is one question block
        $questions = explode($patternQuestionID, $data);
        unset($questions[0]);        // first element is empty

        $saveData = array();        // data to be saved

        // iterrate through all questions
        foreach($questions as $question){
            $_saveData = array();
            //get id
            $_id = explode($patternQuestionContent, $question);
            $q_id = $_id[0];    // relative id in current file

            //get content
            $_content = explode($patternAttachment, $_id[1]);
            $_saveData['Question']['content'] = $_content[0];

            $_saveData['QuestionsSubcategory']['subcategory_id'] = '';

            // get attachments
            $_attachments = explode($patternAnswers, $_content[1]);
            // continue if there is attachments
            if(trim($_attachments[0]) !== '' ){ 
                $q_attachments = explode(',', $_attachments[0]);
                $_saveData['Attachment'] = array();
                $storePath = WWW_ROOT. 'files';                    // path to files folder
                foreach($q_attachments as $key => $q_attachment){
                    $filename = date('YmdHis').'-'.rand(1000, 100000).'.jpg';
                    $re = rename($path.DS.trim($q_attachment).'.jpg', $storePath.DS.$filename);
                    $_saveData['Attachment'][] = array(
                        'path' => Router::url('/', true).'files'.'/'.$filename
                    );
                }
            }

            // get answers
            $_answers = explode($patternAnswerCorrect, $_attachments[1]);
            $q_answers = explode($patternAnswer,$_answers[0]);            // list of answer
            unset($q_answers[0]);        // first element is empty
            $_saveData['Answer'] = array();
            foreach($q_answers as $key => $q_answer){
                $_saveData['Answer'][] = array(
                    'order' => $key - 1,       // id in [0-n], key will start at 1 
                    'content' => $q_answer,
                    'correctness' => 0
                    );
            }
            
            // correct answer remains
            $q_correct = (int)$_answers[1];
            $_saveData['Answer'][$q_correct - 1]['correctness'] = 1;

            $saveData[] = $_saveData;

        } // end foreach

        $check = true;
        foreach ($saveData as $key => $question) {
            $this->create();
            if($this->saveAll($question)){
                $check = true;
            }
            else
                $check = false;
            $this->clear();
        }

        if($check){
            return true;
        }
        else
            return false;
    }

    /**
     * get cover(answered & total questions) for a person on a subject/grade
     * @param:  id of user
     *          grade
     *          subject
     * @return: array of [done, total]
     */
    public function getCover($person_id, $filterOptions = null){

        // no option declared
        // return all subjects and grades
        //if($grade_id == 0 && $subject_id == 0){
		    $countSql = 'select count(*) as count, t.subj AS id from 
                    (select count(*), subjects.id AS subj from questions Question
                        join scores_questions ScoresQuestion
                            on Question.id = ScoresQuestion.question_id
                        join scores Score
                            on Score.id = ScoresQuestion.score_id
						join tests
                            on Score.test_id = tests.id
						join tests_subjects
                            on tests_subjects.test_id = tests.id	
						join subjects
                            on subjects.id = tests_subjects.subject_id		
                        where Score.person_id = '.$person_id.' ';
						
			if(isset($filterOptions['time'])){
				$fromTime = $toTime = null;

				switch($filterOptions['time']['type']){
					case 'week': $fromTime = date('Y-m-d h:i:s', strtotime('-1 Week')); break;
					case 'month': $fromTime = date('Y-m-d h:i:s', strtotime('-1 Month')); break;
					case 'custom': 
						if(array_key_exists('start', $filterOptions['time']) && $filterOptions['time']['start']!='')
							$fromTime = date('Y-m-d h:i:s', strtotime($filterOptions['time']['start'])); 
						if(array_key_exists('end', $filterOptions['time']) && $filterOptions['time']['end']!='')
							$toTime = date('Y-m-d h:i:s', strtotime($filterOptions['time']['end'])); 
						break;
				}
				
				if($fromTime)
				{
					$countSql.=" AND DATE(Score.time_taken) >= DATE('$fromTime')";
				}
				if($toTime)
				{
					$countSql.= " AND DATE(Score.time_taken) <= DATE('$toTime')";
				}
			}
			
			$countSql.= ' group by Question.id) as t group by t.subj';
			
			$count = $this->query($countSql);
			
			
			$total = $this->query(
                'select count(*) AS count, t.subj AS id from (select q.id, subjects.id AS subj from questions q
						inner join questions_subcategories AS qs
							on q.id = qs.question_id
						inner join subcategories AS s
							on s.id = qs.subcategory_id	
						inner join categories AS c
							on c.id = s.category_id		
						inner join subjects
                            on subjects.id = c.subject_id		
                        group by q.id) AS t group by t.subj');	
			
       // }
		
        // if subject is given, not grade
         // return all grades, specific subject
        /*else if($grade_id == 0 && $subject_id != 0){
            $count = $this->query(
                'select count(*) as count from 
                    (select count(*) from questions Question
                        join scores_questions ScoresQuestion
                            on Question.id = ScoresQuestion.question_id
                        join scores Score
                            on Score.id = ScoresQuestion.score_id
                        join tests_subjects TestsSubject
                            on TestsSubject.test_id = Score.test_id
                        where Score.person_id = '.$person_id.' '.
                            'and TestsSubject.subject_id = '.$subject_id.' '.
                        'group by Question.id) as t');
        }
        // if grade is given, not subject
        // return all grades, specific subject
        else if($grade_id != 0 && $subject_id == 0){
            $count = $this->query(
                'select count(*) as count from 
                    (select count(*) from questions Question
                        join scores_questions ScoresQuestion
                            on Question.id = ScoresQuestion.question_id
                        join scores Score
                            on Score.id = ScoresQuestion.score_id
                        join questions_subcategories QuestionsSubcategory
                            on ScoresQuestion.question_id = QuestionsSubcategory.question_id
                        join subcategories Subcategory
                            on Subcategory.id = QuestionsSubcategory.subcategory_id
                        join categories Category
                            on Category.id = Subcategory.category_id
                        where Score.person_id = '.$person_id.' '.
                            'and Category.grade_id = '.$grade_id.' '.
                        'group by Question.id) as t');
        }
        // both declared
        // given both grade and subject
        else {
            $count = $this->query(
                'select count(*) as count from 
                    (select count(*) from questions Question
                        join scores_questions ScoresQuestion
                            on Question.id = ScoresQuestion.question_id
                        join scores Score
                            on Score.id = ScoresQuestion.score_id
                        join questions_subcategories QuestionsSubcategory
                            on ScoresQuestion.question_id = QuestionsSubcategory.question_id
                        join subcategories Subcategory
                            on Subcategory.id = QuestionsSubcategory.subcategory_id
                        join categories Category
                            on Category.id = Subcategory.category_id
                        where Score.person_id = '.$person_id.' '.
                            'and Category.grade_id = '.$grade_id.' '.
                            'and Category.subject_id = '.$subject_id.' '.
                        'group by Question.id) as t');
        }
        */
		$result = array();
		
        foreach($count AS $item)
		{
			$result[$item['t']['id']]['pass'] = $item[0]['count'];
		}
		foreach($total AS $item)
		{
			$result[$item['t']['id']]['total'] = $item[0]['count'];
		}
		
        return $result;
    }
	
	/**
     * get subcategory cover for a person on a subject
     * @param:  id of user
     *          grade
     *          subject
     * @return: array of [done, total]
     */
    public function getSubcategoryCover($person_id, $filterOptions = null){
		    $countSql = 'select count(distinct QS.subcategory_id) as count, subjects.id AS id from questions Question
						join questions_subcategories QS
                            on Question.id = QS.question_id
                        join scores_questions ScoresQuestion
                            on Question.id = ScoresQuestion.question_id
                        join scores Score
                            on Score.id = ScoresQuestion.score_id
						join tests
                            on Score.test_id = tests.id
						join tests_subjects
                            on tests_subjects.test_id = tests.id	
						join subjects
                            on subjects.id = tests_subjects.subject_id		
                        where Score.person_id = '.$person_id.' ';
						
			if(isset($filterOptions['time'])){
				$fromTime = $toTime = null;

				switch($filterOptions['time']['type']){
					case 'week': $fromTime = date('Y-m-d h:i:s', strtotime('-1 Week')); break;
					case 'month': $fromTime = date('Y-m-d h:i:s', strtotime('-1 Month')); break;
					case 'custom': 
						if(array_key_exists('start', $filterOptions['time']) && $filterOptions['time']['start']!='')
							$fromTime = date('Y-m-d h:i:s', strtotime($filterOptions['time']['start'])); 
						if(array_key_exists('end', $filterOptions['time']) && $filterOptions['time']['end']!='')
							$toTime = date('Y-m-d h:i:s', strtotime($filterOptions['time']['end'])); 
						break;
				}
				
				if($fromTime)
				{
					$countSql.=" AND DATE(Score.time_taken) >= DATE('$fromTime')";
				}
				if($toTime)
				{
					$countSql.= " AND DATE(Score.time_taken) <= DATE('$toTime')";
				}
			}
			
			$countSql.= ' group by subjects.id';
			
			$count = $this->query($countSql);

			$total = $this->query(
                'select count(distinct subc) AS count, t.subj AS id from (
							select s.id AS subc, subjects.id AS subj from subcategories AS s
							inner join categories AS c
								on c.id = s.category_id		
							inner join subjects
								on subjects.id = c.subject_id) AS t 
						group by t.subj');	
		$result = array();
		
        foreach($count AS $item)
		{
			$result[$item['subjects']['id']]['pass'] = $item[0]['count'];
		}
		foreach($total AS $item)
		{
			$result[$item['t']['id']]['total'] = $item[0]['count'];
		}
		
        return $result;
    }
	
}