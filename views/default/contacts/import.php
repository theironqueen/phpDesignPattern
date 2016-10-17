<h1> Import </h1>
<p>upload a .vcf file</p>
<?php
	echo view::show('standard/errors');
?>
<form action="/PhpDesignPattern/Demo/contacts/processimport" method="post" enctype="multipart/form-data">
	<div class="row">
		<label for="VCF">VCF file:</label> <input type="file" id="VCF" name="VCF">
	</div>
	<div class="row">
		<label for="submit"></label>
		<input type="submit" id="submit" class="submitbutton" value="Upload">
	</div>
</form>