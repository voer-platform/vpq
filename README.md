# PLS

PLS, Personal Learning System

## Requirements

1. [CakePHP](http://cakephp.org/)
2. [TinyMCE uploader](https://github.com/hashmode/Tinymce-Image-Upload-Cakephp)
3. php5-curl (for Facebook SDK)

## Installation

1. clone project
2. put project folder to webserver
3. copy folder CakePHP/lib to /
4. Copy folder TinymceElfinder/ to /app/Plugin
5. create MySQL db follows:

		DB name: 'plseduvn' 
		username: 'vpq'
		password: 'vpq'

## Server configuration
CakePHP will not work without these configuration on the web server

1. Enable mod rewrite
	
		a2enmod rewrite

2. Allow Override. Make sure Apache configuration looks like this:

		Options Indexes FollowSymLinks MultiViews
		AllowOverride All
		Order allow,deny
		allow from all		

## About