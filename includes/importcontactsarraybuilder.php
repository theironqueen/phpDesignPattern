<?php
require_once 'VCard/VCardCollection.php';
class importcontactsarraybuilder
{
	protected $importedstring;

	public function __construct($importedstring)
	{	
		$this->importedstring = $importedstring;
	}

	public function buildarray()
	{
		$collection = new VCardCollection($this->importedstring);
		return $collection;
	}
}
?>