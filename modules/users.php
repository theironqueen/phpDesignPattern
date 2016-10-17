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

	public function processadd()
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$admin = $_POST['admin'];

		$user = new user(array('username'=>$username));

		if (!is_null($user->id)) {
			lib::seterror($username . 'is already in user');
			lib::sendto('/users/add');
		}
		$user->username = $username;
		$user->password = $password;
		$user->admin = $admin;
		$user->save();

		lib::sendto('/users');
	}

	public function processedit()
	{
		$id = $_POST['id'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$admin = $_POST['admin'];

		$user = new user($id);
		$user->username = $username;
		if (!empty($password)) {
			$user->password = $password;
		}
		$user->admin = $admin;
		$user->save();
		lib::sendto('/users');
	}

	public function processdelete()
	{
		$controller = lib::getItem('controller');

		if (empty($controller->params[0])) {
			lib::sendto();
		}
		else {
			$userid = (int) $controller->params[0];
			$connection = db::factory('mysql');

			$sql = "delete u.* from user u where u.id = {$userid}";
			$connection->execute($sql);
			lib::sendto('/users');
		}
	}
}
?>