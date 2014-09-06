<?php
$config = array (
	'Elfinder' => array (
		'title' => __('Elfinder File Manager'),
		'width' => 960,
		'height' => 480,
		'resizable' => 'yes',
			
/**
 * 
 * for urls
 * before cake 2.4 use FULL_BASE_URL
 * starting cake 2.4 Router::fullbaseUrl()
 * 
 * window_url - the url by which the elfinder window is called
 * if we set 'window_url' => Router::fullbaseUrl().'/posts/elfinderWindow',
 *  		 'connector_url' => Router::fullbaseUrl().'/posts/elfinderConnector',
 * than we should create actions elfinderWindow and elfinderConnector in posts controller like this
 * public function elfinderWindow() {
 * 		$this->TinymceElfinder->elfinder();
 * }
 * public function elfinderConnector() {
 * 		$this->TinymceElfinder->connector();
 * }
 *  			
 */			
		// 'window_url' => Router::fullbaseUrl().'/Admin/elfinder',		// call elfinder window
		// 'connector_url' => Router::fullbaseUrl().'/Admin/connector',	// connect to retrive files
		'window_url' => Router::url('/', true).'/Admin/elfinder',		// call elfinder window
		'connector_url' => Router::url('/', true).'/Admin/connector',	// connect to retrive files
		'locale' => 'en', 
			
/**
 * for full list of options as well as documentation 
 * visit https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
 *  		
 */		
		'options' => array(
			//'debug' => true,
			'roots' => array(
				array(
					'driver'        => 'LocalFileSystem',   					// driver for accessing file system (REQUIRED)
					'URL'   		=> Router::url('/', true).'/img/Uploads',	// upload main folder
					'path'          => IMAGES.'Uploads',        				// path to files (REQUIRED)
					'accessControl' => 'access',            					// disable and hide dot starting files (OPTIONAL)
					'attributes' => array(
						array(
							'pattern' => '!\.html$!',
							'hidden' => true
						)
					),
					'tmbPath' => 'tumbnails',
					'uploadOverwrite' => false,
				)
			)
				
		)
	) 
);
