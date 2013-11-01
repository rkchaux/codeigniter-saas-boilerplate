$(function() {

	$('#addProject').click(function() {

		var project = prompt("Enter name for the new project");
		if(project) {

			$.post(BASE_URL + 'project/doCreate', "name=" + project, function(data) {

				if(data.success) {
					location.href = BASE_URL + 'user/dashboard';
				} else {
					alert("Project already exists!");
				}
			});
		}
	});

	$('.projectDelete').live('click', function() {

		var confirmed = confirm("Do you need to delete this project?");

		if(confirmed) {

			var id = $(this).attr('data-id');
			$.post(BASE_URL + 'project/doDelete', "id=" + id, function(data) {

				if(data.success) {
					location.href = BASE_URL + 'user/dashboard';
				} else {
					alert(data.error);
				}
			});
		}

	});

	$('.projectArchive').live('click', function() {

		var confirmed = confirm("Do you need to archive this project?");

		if(confirmed) {

			var id = $(this).attr('data-id');
			$.post(BASE_URL + 'project/doArchive', "id=" + id, function(data) {

				if(data.success) {
					location.href = BASE_URL + 'user/dashboard';
				} else {
					alert(data.error);
				}
			});
		}

	});

	$('.projectUnarchive').live('click', function() {

		var confirmed = confirm("Do you need to unarchive this project?");

		if(confirmed) {

			var id = $(this).attr('data-id');
			$.post(BASE_URL + 'project/doUnarchive', "id=" + id, function(data) {

				if(data.success) {
					location.href = BASE_URL + 'project/archive';
				} else {
					alert(data.error);
				}
			});
		}

	});
});
