<?php
class PlsComponent extends Object{

    //called before Controller::beforeFilter()
    function initialize(&$controller, $settings = array()) {
        // saving the controller reference for later use
        $this->controller =& $controller;
    }

    //called after Controller::beforeFilter()
    function startup(&$controller) {
    }

    //called after Controller::beforeRender()
    function beforeRender(&$controller) {
    }

    //called after Controller::render()
    function shutdown(&$controller) {
    }

    //called before Controller::redirect()
    function beforeRedirect(&$controller, $url, $status=null, $exit=true) {
    }

    function redirectSomewhere($value) {
        // utilizing a controller method
    }
	
	function vnTimeToStandardTime($vnTime)
	{	
		$standardTime = null;
		if($vnTime)
		{
			$time_arrays = explode('/', $vnTime);
			$standardTime = $time_arrays[0].'-'.$time_arrays[1].'-'.$time_arrays[2];
		}	
		return $standardTime;
	}
	
	public function relativeTime($ts) {
		if(!ctype_digit($ts)) {
			$ts = strtotime($ts);
		}
		$diff = time() - $ts;
		if($diff == 0) {
			return 'now';
		} elseif($diff > 0) {
			$day_diff = floor($diff / 86400);
			if($day_diff == 0) {
				if($diff < 60) return 'just now';
				if($diff < 120) return '1 minute ago';
				if($diff < 3600) return floor($diff / 60) . ' minutes ago';
				if($diff < 7200) return '1 hour ago';
				if($diff < 86400) return floor($diff / 3600) . ' hours ago';
			}
			if($day_diff == 1) { return 'Yesterday'; }
			if($day_diff < 7) { return $day_diff . ' days ago'; }
			if($day_diff < 31) { return ceil($day_diff / 7) . ' weeks ago'; }
			if($day_diff < 60) { return 'last month'; }
			return date('F Y', $ts);
		} else {
			$diff = abs($diff);
			$day_diff = floor($diff / 86400);
			if($day_diff == 0) {
				if($diff < 120) { return 'in a minute'; }
				if($diff < 3600) { return 'in ' . floor($diff / 60) . ' minutes'; }
				if($diff < 7200) { return 'in an hour'; }
				if($diff < 86400) { return 'in ' . floor($diff / 3600) . ' hours'; }
			}
			if($day_diff == 1) { return 'Tomorrow'; }
			if($day_diff < 4) { return date('l', $ts); }
			if($day_diff < 7 + (7 - date('w'))) { return 'next week'; }
			if(ceil($day_diff / 7) < 4) { return 'in ' . ceil($day_diff / 7) . ' weeks'; }
			if(date('n', $ts) == date('n') + 1) { return 'next month'; }
			return date('F Y', $ts);
		}
	}
	
	public function timeFromSeconds($seconds)
	{
		$hours = str_pad(floor($seconds / 3600), 2, 0, STR_PAD_LEFT);
		$mins = str_pad(floor(($seconds - ($hours*3600)) / 60), 2, 0, STR_PAD_LEFT);
		$secs = str_pad(floor($seconds % 60), 2, 0, STR_PAD_LEFT);
		return $hours.':'.$mins.':'.$secs;
	}
	
}
?>