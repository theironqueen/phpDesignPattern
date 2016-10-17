<?php
class decoratoraddress implements decoratorinterface
{
	public function decorate($item)
	{
		$return = ' <a href="#">' . $item . '</a>';
		return $return;
	}
}
?>