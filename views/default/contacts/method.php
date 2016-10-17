<?php
	
	echo '<div class="row"><label>Info:</label><select name="type['.$view['counter']. '][methodtype][]" >';
	$options = array(
			''=>'_Choose one_',
			'organization'=>'Organization',
			'title' => 'Title',
			'email' => 'Email',
			'website' => 'Website',
			'address' => 'Complete Address',
			'phone' => 'Telephone',
			'mobilephone' => 'Mobile Phone',
			'socialnetwork' => 'Social Network URL',
			'im' => 'IM Name'
		);
	$methodType = isset($view['method'])?$view['method']->type:'';

	foreach ($options as $value => $description) {
		echo '<option value="' . $value . '" ';
		if ($methodType == $value) echo 'selected="selected"';
		echo '>' . $description . ' </option>';
	}
	echo '</select>';
	echo ' <span class="methodboxvaluebox ';
	$methodValue = isset($view['method'])?$view['method']->value:' ';

	if (isset($view['method'])) {
		echo 'hasvalue';
	}
	echo '"> <input name="type[' . $view['counter'] . '][methodvalue][]" value="' . $methodValue . '" />'; 

	if (isset($view['method'])) {
		echo ' <a href="#" class="deletecontactmethod"> Delete this Info </a>';
	}
	else {
		echo ' <a href="#" class="addcontactmethod" > Add More Info </a>';
	}
	echo '</span></div>';
?>