$(document).ready(function () {

	var gridLoad = []
	gridLoad["picAddForm"] = "index.php/welcome/picgrid";
	gridLoad["picEditForm"] = "index.php/welcome/picgrid";


	$('#data_grid').DataTable({
		"ajax": {
			url: '<?php echo base_url(); ?>' + "index.php/books/books_page",
				type: 'GET'
		},
	});
	// Activate tooltip
	$('[data-toggle="tooltip"]').tooltip();

	// $('#picAddForm, #picEditForm').submit(function () {
	// 	console.log("here");
	// 	var id = this.id;
	// 	event.preventDefault();
	// 	var $inputs = $('#picAddForm :input');
	// 	var values = {};

	// 	//form data
	// 	$inputs.each(function () {
	// 		if (this.name != "") {
	// 			values[this.name] = $(this).val();
	// 		}
	// 	});

	// 	var data = {
	// 		"data": "sajid"
	// 	}

	// 	$.post("index.php/welcome/testdata", data, function (data, status) {
	// 		data = JSON.parse(data);
	// 		$("#cancel").click();
	// 		event.preventDefault();
	// 		console.log(gridLoad[id]);
	// 		var alert = (data.success) ? "#successMsg" : "#failureMsg";
	// 		$(alert).removeClass("hidden");
	// 		setTimeout(function () {
	// 			$(alert).addClass("hidden");
	// 			$("#contentDiv").load("index.php/welcome/picgrid");
	// 		}, 2000);
	// 	});

	// });

});