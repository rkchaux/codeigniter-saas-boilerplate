$(function() {

	loadCompanies();

	$('#companyList').change(function() {

		var company = getSelecteCompany();
		if(company) {

			$.post(BASE_URL + 'company/select', "name=" + company, function() {

				loadCompanies();
			});
		}
	});

	$('#deleteCompany').click(function() {

		var confirmed = confirm("Do you need to delete selected company?");
		if(confirmed) {

			var company = getSelecteCompany();
			$.post(BASE_URL + 'company/delete', "name=" + company, function() {

				location.reload();
			});
		}
	});

	$('#createCompany').click(function() {

		var company = prompt("Enter name for your new company");
		if(company) {

			$.post(BASE_URL + 'company/create', "name=" + company, function() {

				location.reload();
			});
		}
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