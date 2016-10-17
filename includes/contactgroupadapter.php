<?php
class contactgroupadapter
{
	public function __construct($import)
	{
		$groups = array();
		/*$groupValue = $import->getMessage('CATEGORIES');
		if ($groupValue != null) {
			$groupStr = $groupValue[0]['value'][0];
			if ($groupValue[0]['encoding'] == 'QUOTED-PRINTABLE') {
				$groupStr = $import->QPDecode($groupStr);
			}
			$groups = explode(';',$groupStr);
		} else {
			$groups[] = 'default';
		}*/
		$groups[] = 'default';
		$this->groups = $groups;
	}
}
?>