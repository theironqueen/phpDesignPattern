<?php
	echo '<tr>';
	echo "<td>{$view['user']->username}</td><td>";
	echo $view['user']->admin == 1? 'Yes' : 'No';
	echo "</td><td><a href='/PhpDesignPattern/Demo/users/edit/{$view['user']->id}'> Edit</a></td>";
	echo "<td><a class='removal' href='/users/processdelete/{$view['user']->id}'>";
	echo "Delete </a></td>";
	echo '</tr>';
?>