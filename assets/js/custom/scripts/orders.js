document.addEventListener("DOMContentLoaded", function (e) {
	const clearOrderButton = document.getElementById("clear_order_form_view");
	const closeAddOrderModal = document.getElementById("close_order_modal");

	// Close
	clearOrderButton.addEventListener("click", function () {
		modalViewOrder.hide();
	});
	// X
	closeAddOrderModal.addEventListener("click", function () {
		modalViewOrder.hide();
	});
});

var modalViewOrder = new bootstrap.Modal(
	document.getElementById("view_order_modal"),
	{
		backdrop: "static",
		keyboard: false,
	}
);

const ViewOrder = (order_id) => {
	$.ajax({
		url: window.location.origin + "/TOM_S1/controllers/view_order.php",
		type: "POST",
		data: { action: "get_order_items", order_id: order_id },
		dataType: "JSON",
		beforeSend: function () {},
		success: function (response) {
			$("#order_id_code").text(response.order_id);
			$("#order_date_time").text(response.order_date_time);
			$("#order_items").html(response.order_items);
			$("#total_summary").html(response.total_summary);
		},
		complete: function () {},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
		},
	});
	modalViewOrder.show();
};
const PrintOrder = () => {
	var formData = {
		order_id: $('input[name="order_id"]').val(),
		order_date: $('input[name="order_date"]').val(),
	};
	$.ajax({
		url: window.location.origin + "/TOM_S1/staff/print/index.php",
		type: "POST",
		data: formData,
		dataType: "JSON",
		beforeSend: function () {},
		success: function (response) {},
		complete: function () {},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log("AJAX Error:", textStatus, errorThrown);
			console.log("Response:", jqXHR.responseText);
		},
	});
};

const RefundOrder = (order_id) => {
	Swal.fire({
		text: "Are you sure you would like to refund?" + order_id,
		icon: "warning",
		showCancelButton: !0,
		buttonsStyling: !1,
		confirmButtonText: "Yes, refund it!",
		cancelButtonText: "No, return",
		customClass: {
			confirmButton: "btn btn-primary",
			cancelButton: "btn btn-active-light",
		},
	}).then((result) => {
		if (result.isConfirmed) {
			RefundNow(order_id);
		}
	});
};
const RefundNow = (order_id) => {
	$.ajax({
		url: window.location.origin + "/TOM_S1/controllers/view_order.php",
		type: "POST",
		data: { action: "refund_order", order_id: order_id },
		dataType: "JSON",
		beforeSend: function () {},
		success: function (response) {
			Alert(response.message, response.type);
		},
		complete: function () {},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
		},
	});
};
const Alert = (message, type) => {
	Swal.fire({
		text: message,
		icon: type,
		buttonsStyling: false,
		confirmButtonText: "Ok, got it!",
		customClass: { confirmButton: "btn btn-primary" },
	}).then(() => {
		location.reload(); // Reload the current page
	});
};
