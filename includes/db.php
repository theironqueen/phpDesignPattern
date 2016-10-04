<?php
abstract class db
{
	public static function factory($type)
	{
		//动态执行 $type类中的getInstance方法。
		return call_user_func(array($type, 'getInstance'));
	}

	abstract public function execute($query);
	abstract public function getArray($query);
	abstract public function insertGetID($query);
	abstract public function clean($string);//处理输入，消除注入
}
?>