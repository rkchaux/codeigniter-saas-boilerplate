$(function() {

	$('.planSelect').click(function() {

		var planId = $(this).attr('data-plan');

		$.post(BASE_URL + 'plan/doSelect', "planId=" + planId, function(data) {

			if(data.success) {

				location.reload();
			} else {
				alert(data.error);
			}
		});
	});
});