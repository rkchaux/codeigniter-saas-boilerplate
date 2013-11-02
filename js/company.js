$(function() {

	$('#companyList').change(function() {

		var company = $(this).find(":selected").attr("name");
		location.href = BASE_URL + 'user/dashboard/' + company;
	});
	
});