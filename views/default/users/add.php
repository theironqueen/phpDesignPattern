<?php
	echo view::show('users/manage', array('title'=>'Add User',
		'action'=>'/PhpDesignPattern/Demo/users/processadd','user'=>null));
?>