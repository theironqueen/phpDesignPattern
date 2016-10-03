<?php
/**
 * 用于获取信息，更改对象，或者用于多次执行的某个动作
 */
class lib
{
	const SETTING_AN_ARRAY = true;
	const NO_PERSISTENT_STORAGE = false;

	public static function getItem($name, $persist = true)
	{
		$return = null;
		//echo isset($_SESSION[$name]);
		if (isset($_SESSION[$name])) {
			$return = $_SESSION[$name];
			//print_r($return);
			if (!$persist) unset($_SESSION[$name]);
		}

		return $return;
	}

	public static function setItem($name, $value, $array = false)
	{
		if ($array) {
			if (!isset($_SESSION[$name])) {
				$_SESSION[$name] = array();
				$_SESSION[$name][] = value; 
			}
		}
		else {
			$_SESSION[$name] = $value;
		}
	}

	public static function sendto($url = '')
	{
		if (empty($url)) {
			$url = '/PhpDesignPattern/Demo/';
		}

		die(header('Location: ' . '/PhpDesignPattern/Demo' . $url));
	}

	public static function seterror($error)
	{
		self::setItem('error', $error, self::SETTING_AN_ARRAY);
	}
}
?>