$(function() {

	$('#assignUser').click(function() {

		var email = prompt("Enter email of the user");
		if(email) {

			var projectId = $(this).attr('data-id');
			$.post(BASE_URL + 'project/doAssignUser/' + projectId, "email=" + email, function(data) {

				if(data.success) {
					location.href = BASE_URL + 'project/view/' + projectId;
				} else {
					alert("Project already exists!");
				}
			});
		}
	});
	
});
