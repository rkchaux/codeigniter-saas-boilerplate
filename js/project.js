$(function() {

	$('#addProject').click(function() {

		bootbox.prompt("Enter name for the new project", function(project) {

			if(project) {

				$.post(BASE_URL + 'project/doCreate', "name=" + project, function(data) {

					if(data.success) {
						location.href = BASE_URL + 'user/dashboard';
					} else {
						bootbox.alert("Project already exists!");
					}
				});
			}

		});

	});

	$('.projectDelete').live('click', function() {

		var projectDiv = $(this).parent();
		var id = $(this).attr('data-id');
		bootbox.confirm("Do you need to delete this project?", function(confirmed) {

			if(confirmed) {

				$.post(BASE_URL + 'project/doDelete', "id=" + id, function(data) {

					if(data.success) {
						projectDiv.remove();
					} else {
						bootbox.alert(data.error);
					}
				});
			}
			
		});


	});

	$('.projectArchive').live('click', function() {

		var projectDiv = $(this).parent();
		var id = $(this).attr('data-id');
		bootbox.confirm("Do you need to archive this project?", function(confirmed) {

			if(confirmed) {

				$.post(BASE_URL + 'project/doArchive', "id=" + id, function(data) {

					if(data.success) {
						projectDiv.remove();
					} else {
						bootbox.alert(data.error);
					}
				});
			}
			
		});


	});

	$('.projectUnarchive').live('click', function() {

		var projectDiv = $(this).parent();
		var id = $(this).attr('data-id');
		bootbox.confirm("Do you need to unarchive this project?", function(confirmed) {

			if(confirmed) {

				$.post(BASE_URL + 'project/doUnarchive', "id=" + id, function(data) {

					if(data.success) {
						location.href = BASE_URL + 'project/archive';
					} else {
						bootbox.alert(data.error);
					}
				});
			}
			
		});


	});
});
