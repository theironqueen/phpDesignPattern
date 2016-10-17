<?php
require_once 'VCard2_1.php';

class VCardCollection implements Iterator
{
	protected $_position = 0;
	protected $_storage = array();
	private $__filePath = "";

	public function __construct($filePath)
	{
		if (!file_exists($filePath)) {
			echo $filePath . '所指文件不存在';
		}
		else {
			$this->__filePath = $filePath;
			try{
				$this->setContent();
			}
			catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

	private function setContent()
	{
		// $fileExtension = pathinfo($this->__filePath,PATHINFO_EXTENSION);
		// if ($fileExtension != "vcf") {
		// 	throw new Exception("文件扩展名不是vcf");
		// }
		//打开文件
		$file = fopen($this->__filePath, 'r');
		$line = "";
		$vcard = null;
		while (!feof($file)) {
			$line = fgets($file);
			$line = str_replace("\r\n", "", $line);
			if ($line == '') continue;

			if (preg_match("/^BEGIN:VCARD$/", $line)) {
				//echo "begin\r\n";
			}
			else if (preg_match("/^VERSION:(.*)$/", $line, $version)) {
				$version = str_replace('.','_',$version[1]);
				$class = "VCard".$version;
				$vcard = new $class;
			} 
			else if (preg_match("/^END:VCARD$/", $line)) {
				//echo "end\r\n";
				$this->_storage[] = $vcard;
			}
			else {
				$vcard->setMessage($line);
			}
		}
		fclose($file);
		//print_r($this->_storage);
	}

	public function current()
	{
		return $this->_storage[$this->_position];
	}

	public function key()
	{
		return $this->_position;
	}

	public function next()
	{
		$this->_position ++;
	}

	public function rewind()
	{
		$this->_position = 0;
	}

	public function valid()
	{
		return isset($this->_storage[$this->_position]);
	}

}
?>