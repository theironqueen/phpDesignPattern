<?php
/**
 * 用于各种包含文件的载入 类名应当与文件名保持一致
 */
class autoloader
{

	const MY_FILE_PATH = '/PhpDesignPattern/Demo';
	// const MY_FILE_PATH = 'D:/tools/wamp/www/PhpDesignPattern/Demo';
	public static function moduleautoloader($class)
	{
		$path = $_SERVER['DOCUMENT_ROOT'] . autoloader::MY_FILE_PATH . "/modules/{$class}.php";
		//echo $path."\r\n";
		if (is_readable($path)) require $path;
	}

	public static function daoautoloader($class)
	{
		$path = $_SERVER['DOCUMENT_ROOT'] . autoloader::MY_FILE_PATH . "/dataobjects/{$class}.php";
		//echo $path."\r\n";
		if (is_readable($path)) require $path;
	}

	public static function includesautoloader($class)
	{
		$path = $_SERVER['DOCUMENT_ROOT'] . autoloader::MY_FILE_PATH . "/includes/{$class}.php";
		//echo $path."\r\n";
		if (is_readable($path)) require $path;
	}
}

//注册一些找不到类试的时候，php执行的方法
spl_autoload_register('autoloader::includesautoloader');
spl_autoload_register('autoloader::daoautoloader');
spl_autoload_register('autoloader::moduleautoloader');
?>