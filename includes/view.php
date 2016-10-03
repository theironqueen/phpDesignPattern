<?php
class view
{
	const MY_FILE_PATH = '/PhpDesignPattern/Demo';
	protected static $viewtype;
	public function __construct()
	{
		//打开输出缓冲
		ob_start();
	}

	public function finish()
	{
		//先获取缓冲中的内容，然后再清除缓冲内容
		$content = ob_get_clean();
		return $content;
	}

	//用于显示访问所使用的设备
	protected static function setviewtype()
	{
		switch (true) {
			//确认使用的浏览器代理
			case stripos($_SERVER['HTTP_USER_AGENT'], 'Windows CE')
				!== false:
				self::$viewtype = 'mobile';
				break;
			
			default:
				self::$viewtype = 'default';
				break;
		}
	}

	//选择所使用的视图
	public static function show($location, $params = array())
	{
		if (empty(self::$viewtype)) {
			self::setviewtype();
		}

		$views = array();

		//加载视图
		if (self::$viewtype != 'default') {
			$views[] = $_SERVER['DOCUMENT_ROOT'] . view::MY_FILE_PATH . '/views/' . self::$viewtype .
				'/' . $location . '.php';
		}
		$views[] = $_SERVER['DOCUMENT_ROOT'] . view::MY_FILE_PATH . '/views/default/' .
				 $location . '.php';

		$content = '';
		//print_r($views);
		foreach ($views as $viewlocation) {
			if (is_readable($viewlocation)) {
				$view = $params;

				ob_start();
				include $viewlocation;
				$content = ob_get_clean();
				break;
			}
		}

		return $content;
	}
}
?>