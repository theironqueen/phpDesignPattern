<div id="loginbox">
	<h1>Login</h1>
	<?php
		echo view::show('standard/errors');
	?>
	<form action="/login/process" method="post">
		<div class="row">
			<label for="username">Username:</label>
			<input type="text" name="username" id="username" 
				value="<?php echo lib::getItem('username')?>"/>
		</div>
		<div class="row">
			<label for="password">Password</label>
			<input type="password" name="password" id="password"/>
		</div>
		<div class="row">
			<label for="submit"></label>
			<input type="submit" id="submit" value="login" class="submitbutton"/>
		</div>
	</form>
</div>