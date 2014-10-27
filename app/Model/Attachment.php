<?php
App::uses('AppModel', 'Model');
App::import('Model', 'Question');
/**
 * Attachment Model
 *
 * @property Question $Question
 */
class Attachment extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Question' => array(
			'className' => 'Question',
			'foreignKey' => 'question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * process mass import data
 * @param: 	request data
 * 			path to folder contain files [data.txt, [attachments]]
 *
 * @return: true if success
 *			false if fail
 */	
	public function processMassImport($data, $path){
		
		// patterns for split
		$patternQuestionID 		= '[{q]';
		$patternQuestionContent = '[{c]'; 
		$patternAttachment 		= '<{t}';
		$patternAnswers			= '([a])';
		$patternAnswer 			= '([a)';
		$patternAnswerCorrect 	= '([c)';

		// each is one question block
		$questions = explode($patternQuestionID, $data);
		unset($questions[0]);		// first element is empty

		$Question = new Question();
		$Question->create();
		$saveData = array();		// data to be saved

		// iterrate through all questions
		foreach($questions as $question){
			$_saveData = array();
			//get id
			$_id = explode($patternQuestionContent, $question);
			$q_id = $_id[0];	// relative id in current file

			//get content
			$_content = explode($patternAttachment, $_id[1]);
			$_saveData['Question']['content'] = $_content[0]; 

			// get attachments
			$_attachments = explode($patternAnswers, $_content[1]);
			// continue if there is attachments
			if(trim($_attachments[0]) !== '' ){ 
				$q_attachments = explode(',', $_attachments[0]);
				$_saveData['Attachment'] = array();
				$storePath = WWW_ROOT. DS . 'files';					// path to files folder
				foreach($q_attachments as $key => $q_attachment){
					$filename = date('YmdHisu').'-'.$key.'.jpg';
					$re = rename($path.DS.trim($q_attachment).'.jpg', $storePath.DS.$filename);
					$_saveData['Attachment'][] = array(
						'path' => Router::url('/', true).'files'.DS.$filename
					);
				}
			}

			// get answers
			$_answers = explode($patternAnswerCorrect, $_attachments[1]);
			$q_answers = explode($patternAnswer,$_answers[0]);			// list of answer
			unset($q_answers[0]);		// first element is empty
			$_saveData['Answer'] = array();
			foreach($q_answers as $q_answer){
				$_saveData['Answer'][] = array(
					'content' => $q_answer,
					'correctness' => 0
					);
			}

			// correct answer remains
			$q_correct = (int)$_answers[1];
			$_saveData['Answer'][$q_correct - 1]['correctness'] = 1;

			$saveData[] = $_saveData;

		} // end foreach
		
		// save data
		if($Question->saveAll($saveData)){
			return true;
		}
		else
			return false;

	}
}