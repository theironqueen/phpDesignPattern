if (typeof jQuery != 'undefined') {
	$(function(){
		$(".removal").click(function(){
			if (!confirm('Uou really want to delete this?')) {
				return false;
			}
		});
	});
}