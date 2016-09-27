<?php
/*
 * 
 */

require_once '../transcendence.php';


$lessfiles = array( 
		dirname(__FILE__).'/style/less/style.less' => '/style/less/' 
	);

$scriptfiles = array(
		dirname(__FILE__).'/style/js/script.js'
);

$less_vars = array();

$twig_vars = array( 'scripts' => $scriptfiles );

$twig_cache = false;

echo start($lessfiles, $less_vars, $twig_vars, $twig_cache);