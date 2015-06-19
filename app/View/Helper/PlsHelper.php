<?php 

App::uses('AppHelper', 'View/Helper');

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
}	