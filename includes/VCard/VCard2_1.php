<?php
	require_once 'VCard.php';
class VCard2_1 extends VCard
{
	private $__param = array();
	private $__value = array();

	private $__isEnd = true;
	private $__code = null;
	private $__field = '';

	private $__defaultType = array();

	public function __construct()
	{
		$this->_version = 2.1;
		$__defaultType['ADR'] = array('INTL','POSTAL','PARCEL','WORK');
		$__defaultType['TEL'] = array('VOICE');
		$__defaultType['EMAIL'] = array('INTERNET');
	}

	protected function _execute($string)
	{
		if (!$this->__isEnd || substr($string, 0, 1) == ' ') {
			//当前内容为上一行的后续
			$this->__lastExecute($string);
		}
		else {
			//该行为新内容
			$this->__newExecute($string);
		}
	}

	private function __setParams($paramStr)
	{
		$return = array();
		// echo $paramStr . "\r\n";
		$params = explode(';', $paramStr);
		$encoding = '';
		$type = array();
		foreach ($params as $param) {
			$pos = 0;
			if (($pos = strpos($param, '=')) !== false) {
				//格式为key = value
				$left = substr($param, 0, $pos);
				$right = substr($param, $pos+1);
				$left = strtoupper($left);
				if ($left == 'ENCODING') {
					$encoding = strtoupper($right);
				}
				else if ($left == 'TYPE') {
					$right = strtoupper($right);
					$rights = explode(',', $right);
					$type = array_merge($type, $rights);
				} 
				else if ($left == 'X-SELF') {
					$rights = explode(',', $right);
					$type = array_merge($type, $rights);
				}
				else {
					$return[$left] = $right;
				}
			}
			else {
				//格式为单个
				$param = strtoupper($param);
				$type[] = $param;
			}
		}
		$return['ENCODING'] = $encoding;
		$return['TYPE'] = $type;

		$this->__code = $encoding;
		return $return;
	}

	private function __lastExecute($string)
	{
		if (substr($string, 0, 1) == ' ')
			$string = substr($string, 1);
		$values = $this->__valueSplit($string);
		$msg = $this->_message[$this->__field];
		$val = $msg[count($msg)-1]['value'];

		$first = array_shift($values);
		$val[count($val)-1] = $val[count($val)-1] . $first;
		$val = array_merge($val, $values);

		if ($this->__code == 'QUOTED-PRINTABLE') {

			if (substr($string, -1) == '='){
				//还有后续
				$this->__isEnd = false;
				$temp = $val[count($val)-1];
				$temp = substr($temp, 0, strlen($temp)-1);
				$val[count($val)-1] = $temp;
			} else {
				//echo $string . "\r\n";
				$this->__isEnd = true;
			}
		}
		$msg[count($msg)-1]['value'] = $val;
		$this->_message[$this->__field] = $msg;
	}

	private function __newExecute($string)
	{
		$pos = strpos($string, ':');
		$strleft = substr($string, 0, $pos);
		$strright = substr($string, $pos+1);
		//处理左边
		$pos = strpos($strleft, ';');
		$paramStr;
		if ($pos === false) {
			$paramStr = '';
			$this->__field = strtoupper($strleft);
		}
		else {
			$this->__field = strtoupper(substr($strleft, 0, $pos));
			$paramStr = substr($strleft, $pos+1);
		}
		//处理参数
		$params = $this->__setParams($paramStr);
		$values = $this->__valueSplit($strright);

		if ($params['ENCODING'] == 'QUOTED-PRINTABLE') {
			$temp = $values[count($values)-1];
			if (substr($temp, -1) == '=') {
				$this->__isEnd = false;
				$temp = substr($temp, 0, strlen($temp)-1);
				$values[count($values)-1] = $temp;
			}
		}
		//将获取的内容写入message中
		if (!isset($this->_message[$this->__field])) {
			$this->_message[$this->__field] = array();
		}

		$result = array();
		$result['encoding'] = $params['ENCODING'];
		$result['type'] = $params['TYPE'];
		$result['value'] = $values;
		$this->_message[$this->__field][] = $result;
	}

	private function __valueSplit($string)
	{
		$result = array();
		$pos = 0;
		while (($pos = strpos($string, ';', $pos)) !== false) {
			if ($pos == 0) {
				$result[] = "";
				$string = substr($string, 1);
			}
			else if (substr($string, $pos-1, 1) == '\\') {
				$pos ++;
				continue;
			}
			else {
				$result[] = substr($string, 0, $pos);
				$string = substr($string, $pos+1);
				$pos = 0;
			}
		}
		$result[] = $string;
		return $result;
	}
}
?>