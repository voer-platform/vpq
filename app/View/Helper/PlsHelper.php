<?php 

App::uses('AppHelper', 'View/Helper');
App::import('Model', 'Category');

class PlsHelper extends AppHelper {
    public function getImageFromContent($text)
	{
		preg_match('/<img.+src=[\'"](?P<src>.+)[\'"].*>/i', $text, $image);
		if(isset($image['src']))
		{
			return $image['src'];
		}
		else
			return 'img/noimage.png';
	}
	
	public function getCategory($subject, $grade) {
	
		$category = new Category();
		$categories = $category->find('list', array('conditions' => array('grade_id' => $grade, 'subject_id' => $subject)));
		return $categories;
	
	}
	
}	