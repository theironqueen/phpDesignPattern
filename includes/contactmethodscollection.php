<?php
class contactmethodscollection extends daocollection implements daocollectioninterface
{
	protected $group;

	public function __construct(dao $group)
	{
		$this->group = $group;
	}

	public function getwithdata()
	{
		$connection = db::factory('mysql');

		$sql = "select * from contactmethod where contactgroupid="
				. $this->group->id . ' order by type';
		$results = $connection->getArray($sql);
		$this->populate($results, 'contactmethod');
	}

	public function generateimportmethods($import)
	{
		$results = array();
		$fields = $import->getField();

		if (in_array('TEL',$fields)) {
			$tels = $import->getMessage('TEL');
			$tel = $tels[0];
			$telline = $tel['value'][0];
			$results[] = array('type'=>'phone', 'value'=>$telline,
				'contactgroupid'=>$this->group->id);
		}

		if (in_array('ADR', $fields)) {
			$adrs = $import->getMessage('ADR');
			$adr = $adrs[0];
			$adrvalues = $adr['value'];
			if ($adr['encoding'] == 'QUOTED-PRINTABLE') {
				foreach ($adrvalues as $key => $value) {
					$adrvalues[$key] = $import->QPDecode($value);
				}
			}
			$adrline = implode(' ', $adrvalues);
			$results[] = array('type'=>'address', 'value'=>$adrline,
				'contactgroupid'=>$this->group->id);
		}

		if (in_array('EMAIL', $fields)) {
			$emails = $import->getMessage('EMAIL');
			$email = $emails[0];
			$emailline = $email['value'][0];
			if ($email['encoding'] == 'QUOTED-PRINTABLE') {
				$emailline = $import->QPDecode($emailline);
			}
			$results[] = array('type'=>'email', 'value'=>$emailline,
				'contactgroupid'=>$this->group->id);
		}
		$this->populate($results, 'contactmethod');
	}
}
?>