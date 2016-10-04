<?php
class mysql extends db implements singletoninterface
{
	protected static $instance = null;
	protected $link;

	//单元素模式 使instance只有一个
	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	protected function __construct()
	{
		$user = 'phpDesignPattern';
		$pass = '123456';
		$host = 'localhost';
		$db = 'contacts';

		$this->link = mysqli_connect($host, $user, $pass, $db);
	}

	public function clean($string)
	{
		return mysqli_real_escape_string($this->link, $string);
	}

	public function getArray($query)
	{
		//print_r($query);
		$result = mysqli_query($this->link,$query);
		//print_r($result);
		$return = array();
		if ($result) {
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				$return[] = $row;
			}
		}
		//print_r($return);
		return $return;
	}

	public function execute($query)
	{
		mysqli_query($this->link, $query);
	}

	public function insertGetId($query)
	{
		$this->execute($query);
		return mysqli_insert_id($this->link);
	}
}
?>