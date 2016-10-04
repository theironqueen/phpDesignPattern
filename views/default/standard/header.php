<?php
$pathHelper = '/PhpDesignPattern/Demo';
if (auth::isloggedin()) {
	$links = array('/'=>'Home',
				   '/contacts/add'=>'Add contact',
				   '/contacts/import'=>'Import Contacts');
	if (auth::isadmin()) {
		$links['/users'] = 'User Admin';
	}

	$links['/logout'] = 'Log Out';
	echo '<ul>';
	foreach ($links as $link => $title) {
		echo '<li><a href=" '. $pathHelper . $link . '">' . $title . '</a></li>';
	}
	echo '</ul>';
}
?>