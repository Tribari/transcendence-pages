<?php
/*
 * 
 */

require_once '../transcendence.php';


$lessfiles = array( 
		dirname(__FILE__).'/style/less/style.less' => '/style/less/' 
	);

$less_vars = array();

$twig_vars = array();

$twig_cache = false;

echo start($lessfiles, $less_vars, $twig_vars, $twig_cache);