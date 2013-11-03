$(function() {

	$('.projectUser img').tooltip();

	var projectId = null;
	$('#manageUsers, #addUser').click(function() {

		$('#usersModal').modal('show');
		projectId = $(this).attr('data-id');
		$('#addEmail').focus();
	});

	$('#assignUser').click(function() {

		var email = $('#addEmail').val();

		if(email) {

			$.post(BASE_URL + 'project/doAssignUser/' + projectId, "email=" + email, function(data) {

				if(data.success) {
					$('#userSuccess').fadeIn(function() {
						setTimeout(function() {
							$('#userSuccess').fadeOut();
						}, 3000);
					})
					$('#addEmail').val('').focus();

				} else {
					alert(data.err);
				}
			});
		}

	});

	$('.projectUserRemove').live('click', function() {

		var projectId = $(this).attr('data-project');
		var userId = $(this).attr('data-user');

		var tr = $(this).parent().parent();

		$.post(BASE_URL + 'project/doRemoveUser/' + projectId, "user=" + userId, function(data) {

			if(data.success) {
				tr.remove();
			} else {
				alert(data.err);
			}
		});
	});
	
});
