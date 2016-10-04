<?php
class authstandard implements authenticatorinterface
{
	public function authenticate(user $user, $password)
	{
		if ($user->password == $password) {
			return true;
		}
		else {
			return false;
		}
	}
}
?>