<?php
session_start();
$sessionid = session_id();

/*
 * Loading the configuration
 */
require_once 'config/general.php';

/*
 * Loading the libraries
 */
require_once __DIR__.'/vendor/autoload.php';


// LESS Compiler
try{
	$less_files 	= array( dirname(__FILE__).'/public/style/less/style.less' => '/style/less/' );
	$options 		= array( 'cache_dir' => dirname(__FILE__).'/public/style/cache' );
	$variables 		= array( 'width' => '100px' );
	$css_file_name 	= 'style/cache/'. Less_Cache::Get( $less_files, $options, $variables );
}catch(Exception $e){
	$error_message 	= $e->getMessage();
}


// Twig Compiler
try{
	Twig_Autoloader::register();
	
	$loader = new Twig_Loader_Filesystem('../pages');
	$loader->addPath('../templates', 'templates');
	$loader->addPath('../partials', 'partials');
	
	if($TWIG_CACHE){
		$twig = new Twig_Environment($loader, array('cache' => '../cache',));
	}else{
		$twig = new Twig_Environment($loader);
	}
}catch(Exception $e){
	$error_message 	= $e->getMessage();
}


$url = $_SERVER["REQUEST_URI"];
$url = explode("/", $url);
$page = end($url);

if($page == ''){
	echo $twig->render('index.html', array('cssfile' => $css_file_name, 'sessionid' => $sessionid ));
}else{
	$html = dirname(__FILE__).'/../pages/'.$page.'.html';
	if(file_exists($html)){
		echo $twig->render($spage.'.html', array('cssfile' => $css_file_name, 'sessionid' => $sessionid ));
	}else{
		echo $twig->render('404.html', array('cssfile' => $css_file_name, 'sessionid' => $sessionid ));
	}
}