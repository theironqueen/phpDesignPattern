<?php
	require_once 'VCardInterface.php';
abstract class VCard implements VCardInterface
{
	protected $_version = 0;
	protected $_message = array();

	abstract protected function _execute($string);


	public function QPDecode($msg)
	{
		return quoted_printable_decode($msg);
	}

	public function setMessage($string)
	{
		$this->_execute($string);
	}

	public function getMessage($field)
	{
		if ($this->isValid($field)) {
			return $this->_message[$field];
		} else {
			return null;
		}
	}
	
	public function isValid($field)
	{
		if (isset($this->_message[$field])) {
			return true;
		} else {
			return false;
		}
	}

	public function getVersion()
	{
		return 'Version:' . $this->_version;
	}

	public function getField()
	{
		$keys = array_keys($this->_message);
		return $keys;
	}
}
?>