<?php
class logout
{
	public function defaultaction()
	{
		lib::setItem('user', null);
		lib::sendto();
	}
}
?>