$(function() {

	$('#addItem').click(function() {

		var project = $(this).attr('data-project');
		bootbox.prompt("Enter name for the new item", function(item) {

			if(item) {

				var data = "name=" + item + "&project=" + project;
				$.post(BASE_URL + 'item/doCreate', data, function(data) {

					if(data.success) {
						location.href = BASE_URL + 'project/view/' + project;
					} else {
						bootbox.alert("Item already exists!");
					}
				});
			}

		});

	});

	$('.itemDelete').live('click', function() {

		var itemDiv = $(this).parent();
		var id = $(this).attr('data-id');
		var project = $(this).attr('data-project');

		bootbox.confirm("Do you need to delete this item?", function(confirmed) {

			if(confirmed) {

				var data = "id=" + id + "&project=" + project;
				$.post(BASE_URL + 'item/doDelete', data, function(data) {

					if(data.success) {
						itemDiv.remove();
					} else {
						bootbox.alert(data.error);
					}
				});
			}
			
		});


	});

	$('.itemArchive').live('click', function() {

		var itemDiv = $(this).parent();
		var id = $(this).attr('data-id');
		var project = $(this).attr('data-project');
		bootbox.confirm("Do you need to archive this item?", function(confirmed) {

			if(confirmed) {

				var data = "id=" + id + "&project=" + project;
				$.post(BASE_URL + 'item/doArchive', data, function(data) {

					if(data.success) {
						itemDiv.remove();
					} else {
						bootbox.alert(data.error);
					}
				});
			}
			
		});


	});

	$('.itemUnarchive').live('click', function() {

		var itemDiv = $(this).parent();
		var id = $(this).attr('data-id');
		var project = $(this).attr('data-project');
		bootbox.confirm("Do you need to unarchive this item?", function(confirmed) {

			if(confirmed) {

				var data = "id=" + id + "&project=" + project;
				$.post(BASE_URL + 'item/doUnarchive', data, function(data) {

					if(data.success) {
						location.href = BASE_URL + 'project/archive';
					} else {
						bootbox.alert(data.error);
					}
				});
			}
			
		});


	});

	/*
		************ Reordering Support *****************
	*/
	$('#startReorder').click(function() {

		$("#startReorder").hide();
		$("#endReorder").show();

		$('#alertReorder')
			.removeClass('alert-success')
			.html("Reorder items now, after completing click the above button.")
			.show();
		$('#itemSortList').sortable();
	});

	$('#endReorder').click(function() {

		$("#startReorder").show();
		$("#endReorder").hide();

		$('#itemSortList').sortable('destroy');

		var project = null;	
		var sortList = [];
		$('#itemSortList .item').each(function(item) {

			project = $(this).attr('data-project');
			sortList.push($(this).attr('data-id'));

		});

		var data = "project=" + project + "&sortList=" + sortList.join(",");

		console.log(data);
		$.post(BASE_URL + 'item/doReorder', data, function(data) {

			if(data.success) {

				$('#alertReorder')
					.addClass('alert-success')
					.html("Successfully Reordered!")
					.show();

				setTimeout(function() {

					$('#alertReorder').hide();
				}, 4000);
			} else {
				bootbox.alert(data.error);
			}
		});

	});
});
