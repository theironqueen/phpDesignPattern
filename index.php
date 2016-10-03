<?php
	require 'includes/autoloader.php';
	require 'includes/exceptions.php';
	session_start();

	//在$_get['u']中存储的是项目根目录Demo之后的所有输入路径
	//例如/Demo/index/defaultAction/  就会变为 index/defaultAction/
	lib::setItem('controller', new controller($_GET['u']));
	$view = new View();
	lib::getItem('controller')->render();
	// lib::getItem('controller')->render();
	$content = $view->finish();

	echo view::show('shell', array('body'=>$content));
	ob_end_flush();
?>