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
			$contacts->getwithdata();
			//print_r($contacts);
			echo view::show('contacts/browse', array('contacts'=>$contacts));
		}
	}
}
?>