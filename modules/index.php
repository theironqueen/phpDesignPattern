<?php
/**
 * index模块
 */
class index{
	public function defaultaction()
	{
		if (!auth::isloggedin()) {
			lib::sendto('/login');
		}
		else {
			$contacts = new contactscollection(lib::getItem('user'));
			$contacts->getwidthdata();

			echo view::show('contacts/browse', array('contacts'=>$contacts));
		}
	}
}
?>