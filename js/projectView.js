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
		var role = $('#role').find(":selected").attr('name');

		if(!email) {

			bootbox.alert("Please enter a email to assign a user");
			$('#addEmail').focus();
		} else if(!role) {

			bootbox.alert("Please select a role!");
			$('#role').select();

		} else {

			var data = "email=" + email + "&role=" + role;
			$.post(BASE_URL + 'project/doAssignUser/' + projectId, data, function(data) {

				if(data.success) {
					$('#userSuccess').fadeIn(function() {
						setTimeout(function() {
							$('#userSuccess').fadeOut();
						}, 3000);
					})
					$('#addEmail').val('').focus();

				} else {
					bootbox.alert(data.err || data.message);
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
				bootbox.alert(data.err);
			}
		});
	});
	
});
