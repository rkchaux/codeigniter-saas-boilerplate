$(function() {

	loadCompanies();

	$('#addProject').click(function() {

		var project = prompt("Enter name for the new project");
		if(project) {

			$.post(BASE_URL + 'project/create', "name=" + project, function(data) {

				if(data.success) {
					location.href = BASE_URL + 'user/dashboard';
				} else {
					alert("Project already exists!");
				}
			});
		}
	});
});
