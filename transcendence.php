<?php
session_start();

/*
 * Loading the libraries
 */
require_once __DIR__.'/vendor/autoload.php';



function start( $less_files = array(), $less_vars = array(), $twig_vars = array(), $twig_cache = false ) {
	
	$error_message 	= "";
	$sessionid 		= session_id();

	// LESS Compiler
	try{
		$options 		= array( 'cache_dir' => dirname(__FILE__).'/public/style/cache' );
		$css_file_name 	= '/style/cache/'. Less_Cache::Get( $less_files, $options, $less_vars );
	}catch(Exception $e){
		$error_message 	= $e->getMessage();
	}
	
	
	// Twig Compiler
	try{
		Twig_Autoloader::register();
		
		$loader = new Twig_Loader_Filesystem('../pages');
		$loader->addPath('../templates', 'templates');
		$loader->addPath('../partials', 'partials');
		
		if($twig_cache){
			$twig = new Twig_Environment($loader, array('cache' => '../cache',));
		}else{
			$twig = new Twig_Environment($loader);
		}
	}catch(Exception $e){
		$error_message 	= $e->getMessage();
	}
	
	
	//$twig_vars 	= array('cssfile' => $css_file_name, 'sessionid' => $sessionid );
	
	$twig_vars['cssfile'] 		= $css_file_name;
	$twig_vars['sessionid'] 	= $sessionid;
	
	
	$url 		= $_SERVER["REQUEST_URI"];
	$url		= substr($url, 1);
	
	$page_url	= explode("/",$url);
	$page_end 	= end($page_url);
	
	if($page_end == ''){
		$url = $url."index";
	}
	
	$html = dirname(__FILE__).'/pages/'.$url.'.html';
	
	try{
		if(file_exists($html)){
			echo $twig->render($url.'.html', $twig_vars );
		}else{
			echo $twig->render('404.html', $twig_vars );
		}
	}catch(Exception $e){
		$error_message 	= $e->getMessage();
	}

	return $error_message;
}
