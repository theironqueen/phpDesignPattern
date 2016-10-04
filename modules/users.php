<?php
class users
{
	public function defaultaction()
	{
		$users = new userscollection(lib::getItem('user'));
		$users->getwithdata();
		echo view::show('users/show', array('users'=>$users));
	}

	public function add()
	{
		echo view::show('users/add');
	}

	public function edit()
	{
		$controller = lib::getItem('controller');

		if (empty($controller->params[0])) {
			lib::sendto();
		}
		else {
			$user = new user((int) $controller->params[0]);
			echo view::show('users/edit', array('user'=>$user));
		}
	}
}
?>