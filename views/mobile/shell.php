<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html">
	<link rel="stylesheet" type="text/css" href="/PhpDesignPattern/Demo/assets/main.css" />
	<title>Mobile</title>
</head>
<body>
	<div id="header"><?php echo view::show('standard/header');?></div>

	<div id="body">
		<?php echo $view['body'];?>
	</div>

	<div id="footer"><?php echo view::show('standard/footer');?></div>
</body>
</html>