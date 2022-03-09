<?php

use \Hcode\Model\User;
use \Hcode\Page;

$app->get('/', function() {
   
	$page = new Page();

	$page->setTpl("index");
 
});

?>