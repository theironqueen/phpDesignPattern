<?php
class outlookcontactimportadapter
{
	public function __construct($import)
	{
		$names = $import->getMessage('N');
		$name = $names[0];
		$encoding = $name['encoding'];
		$value = $name['value'];
		$firstname = $value[0];
		$middlename = $value[2];
		$lastname = $value[1];
		if ($encoding == 'QUOTED-PRINTABLE') {
			$firstname = $import->QPDecode($firstname);
			$middlename = $import->QPDecode($middlename);
			$lastname = $import->QPDecode($lastname);
		}
		$this->firstname = $firstname;
		$this->middlename = $middlename;
		$this->lastname = $lastname;
	}
}
?>