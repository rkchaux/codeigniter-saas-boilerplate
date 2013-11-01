$(function() {

	loadCompanies();

	$('#addProject').click(function() {

		var project = prompt("Enter name for the new project");
		if(project) {

			$.post(BASE_URL + 'project/create', "name=" + project, function() {

				location.reload();
			});
		}
	});
});
