<?php
echo view::show('/users/manage', array('title'=>'Edit User',
	'action'=>'/PhpDesignPattern/Demo/users/processedit', 'user'=>$view['user']));
?>