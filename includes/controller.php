<?php
/**
 * 根据接收的url参数进行判定以/分隔输入，其中前两个分别为模块和方法
 * 参数处理完毕后可以使用render加载具体的方法
 */
class controller
{
	protected $parts;
	public $params;

	public function __construct($urlString)
	{
		$urlString = strtolower($urlString);

		if (substr($urlString, -1, 1) == '/') {
			$urlString = 
				substr($urlString, 0, strlen($urlString) - 1);

		}

		$parts = explode('/', $urlString);
		if (empty($parts[0])) {
			$parts[0] = 'index';
		}

		if (empty($parts[1])) {
			$parts[1] = 'defaultaction';
		}

		$this->parts = $parts;
		//意义不明
		$this->sectionaction = $parts[0] . '/' . $parts[1];
		//将前两个表示模块的去掉，剩下的都是输入的参数
		array_shift($parts);
		array_shift($parts);
		$this->params = $parts;
	}

	public function render()
	{
		// var_dump($this->parts);
		if (!class_exists($this->parts[0])) {
			throw new SectionDoesntExistException("{$this->parts[0]} is".
				" not a valid module.");
		}

		if (!method_exists($this->parts[0], $this->parts[1])) {
			throw new ActionDoesntExistException("{$this->parts[1]} of".
				" module {$this->parts[0]} is not a valid action.");
		}
		//使用call_user_func_array 时如果调用类中的方法，不能将类名作为数组中的参数
		//必须要使用类的实例作为第一个参数，方法名作为第二个参数
		$called = call_user_func_array(array( new $this->parts[0],
			$this->parts[1]), array($this->params));

		if ($called === false) {
			throw new ActionFailedException("{$this->parts[1]} of section".
				"{$this->parts[0]} failed to execute properly.");
		}
	}
}
?>