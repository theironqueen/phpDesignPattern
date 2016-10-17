<?php
	echo '<h1>' . $view['title'] . '</h1>';
	echo view::show('standard/errors');
	echo '<form method="post" action="' . $view['action'] . '">';
	$username = '';
	$admin = 0;
	if (!is_null($view['user'])) {
		echo '<input type="hidden" name="id" value="' . $view['user']->id . '" />';
		$username = $view['user']->username;
		$admin = (int) $view['user']->admin;
	}
	echo '<div class="row"><label for="username">Username:</label>';
	// $value = $view['user']->username;
	echo '<input type="text" name="username" id="username" value="' . $username . '" /></div>';
	echo '<div class="row"><label for="password">PassWord:</label>';
	echo '<input type="password" name="password" id="password"/></div>';
	echo '<div class="row"><label> Is Admin</label>';
	$options = array('No', 'Yes');
	// $value = (int) $view['user']->admin;

	foreach ($options as $key => $option) {
		echo ' <input class="radio" type="radio" name="admin" value="' . $key .'" ';
		if ($admin == $key) echo 'checked="checked"';
		echo ' /><span class="radiooption">' . $option . '</span>';
	}

	echo '</div>';
	echo '<div class="row"><label for="submit"></label> <input id="submit" type="submit" class="submitbutton" value="' . $view['title'] . '" /></div>';
	echo '</form>';
?>