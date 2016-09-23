<?php
/*
 * 
 */

require_once '../transcendence.php';


$lessfiles = array( 
		dirname(__FILE__).'/style/less/style.less' => '/style/less/' 
	);

$less_vars = array();



echo start($lessfiles, $less_vars);