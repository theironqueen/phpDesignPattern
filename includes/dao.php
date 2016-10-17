<?php
/**
 * 任何引用该类的子对象都必须有 table属性
 */
class dao
{
	protected $values = array();


	public function __construct($qualifier = null)
	{
		//qualifier 限定符
		if (!is_null($qualifier)) {
			//conditional 条件
			$conditional = array();

			//is_numeric判定是否是数字或数字的字符串
			if (is_numeric($qualifier)) {
				$conditional = array('id'=>$qualifier);
			}
			else if (is_array($qualifier)) {
				$conditional = $qualifier;
			}
			else {
				throw new Exception('Invalid type of qualifier given');
			}
			//print_r($conditional);
			$this->populate($conditional);
		}
	}

	public function __set($name, $value)
	{
		$this->values[$name] = $value;
	}

	public function __get($name)
	{
		if (isset($this->values[$name])) {
			return $this->values[$name];
		}
		else {
			return null;
		}
	}

	protected function populate($conditional) 
	{
		$connection = db::factory('mysql');

		$sql = "select * from {$this->table} where ";
		$qualifier = '';

		foreach ($conditional as $column => $value) {
			if (!empty($qualifier)) {
				$qualifier .= ' and ';
			}
			//$connection->clean($value) 为防止输入注入而进行的处理
			$qualifier .= "{$column}='" . $connection->clean($value) . "' ";
		}
		$sql .= $qualifier;
		// print_r($sql);
		$valuearray = $connection->getArray($sql);
		// print_r($valuearray);
		if (!isset($valuearray[0])) {
			$valuearray[0] = array();
		}

		foreach ($valuearray[0] as $name => $value) {
			$this->$name = $value;
		}

	}
	public function save()
	{
		if (!$this->id) {
			$this->create();
		}
		else {
			$this->update();
		}
	}
	protected function create()
	{
		$connection = db::factory('mysql');
		$sql = "insert into {$this->table} ( ";

		//array_keys 将数组的key变为一个新的数组
		$sql .= implode(',', array_keys($this->values));
		$sql .= ") values ('";

		$clean = array();
		foreach ($this->values as $value) {
			$clean[] = $connection->clean($value);
		}

		$sql .= implode("', '", $clean);
		$sql .= "')";
		
		$this->id = $connection->insertGetID($sql);
	}
	protected function update()
	{
		$connection = db::factory('mysql');

		$sql = "update {$this->table} set ";
		$updates =array();
		foreach ($this->values as $key => $value) {
			$updates[] = "{$key} = '" . $connection->clean($value) . "'";
		}

		$sql .= implode(', ', $updates);
		$sql .= " where id = {$this->id}";

		$connection->execute($sql);
	}
}
?>