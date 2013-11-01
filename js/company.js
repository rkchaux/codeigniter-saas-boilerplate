$(function() {

	loadCompanies();

	$('#companyList').change(function() {

		
	});
});

function getSelecteCompany() {

	return $('#companyList').find(":selected").attr("name");
}

function loadCompanies() {

	$.post(BASE_URL + "company/get", function(data) {

		$('#companyList option').remove();

		data.companies.forEach(function(company) {

			var selected = (data.selected == company)? "selected='selected'" : "";
			var option = "<option " + selected + " name='" + company + "'>" + company + "</option>";
			$('#companyList').append(option);
		});
	});
}