document.addEventListener("DOMContentLoaded", function (e) {
	const addFormStock = document.getElementById("add_stock_form");
	const editFormStock = document.getElementById("edit_stock_form");
	const addSubmitStock = document.getElementById("add_stock_submit");
	const editSubmitStock = document.getElementById("edit_stock_submit");

	var addValidatorStock = FormValidation.formValidation(addFormStock, {
		fields: {
			stock_category: {
				validators: {
					notEmpty: {
						message: "Please choose stock category",
					},
				},
			},
			delivery_today: {
				validators: {
					integer: {
						message: "Please enter number only",
						// The default separators
						thousandsSeparator: "",
						decimalSeparator: ".",
					},
					notEmpty: {
						message: "Please enter stock name",
					},
				},
			},
			total_out: {
				validators: {
					integer: {
						message: "Please enter number only",
						// The default separators
						thousandsSeparator: "",
						decimalSeparator: ".",
					},
					notEmpty: {
						message: "Ammount cannot be empty",
					},
				},
			},
		},
		plugins: {
			trigger: new FormValidation.plugins.Trigger(),
			bootstrap: new FormValidation.plugins.Bootstrap5({
				rowSelector: ".fv-row",
				eleInvalidClass: "",
				eleValidClass: "",
			}),
			// Again, remember to register the Tooltip plugin before Icon plugin
			tooltip: new FormValidation.plugins.Tooltip(),
			icon: new FormValidation.plugins.Icon({
				valid: "fa fa-check",
				invalid: "fa fa-times",
				validating: "fa fa-refresh",
			}),
		},
	});

	var editValidatorStock = FormValidation.formValidation(editFormStock, {
		fields: {
			delivery_today: {
				validators: {
					integer: {
						message: "Please enter number only",
						// The default separators
						thousandsSeparator: "",
						decimalSeparator: ".",
					},
					notEmpty: {
						message: "Please enter stock name",
					},
				},
			},
			total_out: {
				validators: {
					integer: {
						message: "Please enter number only",
						// The default separators
						thousandsSeparator: "",
						decimalSeparator: ".",
					},
					notEmpty: {
						message: "Total Out cannot be empty",
					},
				},
			},
		},
		plugins: {
			trigger: new FormValidation.plugins.Trigger(),
			bootstrap: new FormValidation.plugins.Bootstrap5({
				rowSelector: ".fv-row",
				eleInvalidClass: "",
				eleValidClass: "",
			}),
			// Again, remember to register the Tooltip plugin before Icon plugin
			tooltip: new FormValidation.plugins.Tooltip(),
			icon: new FormValidation.plugins.Icon({
				valid: "fa fa-check",
				invalid: "fa fa-times",
				validating: "fa fa-refresh",
			}),
		},
	});

	const closeConfirmation = (form, validator, modal) => {
		Swal.fire({
			text: "Are you sure you would like to cancel?",
			icon: "warning",
			showCancelButton: !0,
			buttonsStyling: !1,
			confirmButtonText: "Yes, cancel it!",
			cancelButtonText: "No, return",
			customClass: {
				confirmButton: "btn btn-primary",
				cancelButton: "btn btn-active-light",
			},
		}).then((result) => {
			if (result.isConfirmed) {
				modal.hide();
				validator.resetForm();
				form.reset();
			}
		});
	};
	// ADD MODAL
	const clearStockButton = document.getElementById("clear_stock_form");
	const closeAddStockModal = document.getElementById("close_stock_modal");

	// Close
	clearStockButton.addEventListener("click", function () {
		closeConfirmation(addFormStock, addValidatorStock, modalAddStock);
	});
	// X
	closeAddStockModal.addEventListener("click", function () {
		closeConfirmation(addFormStock, addValidatorStock, modalAddStock);
	});

	// EDIT MODAL
	const clearStockButtonEdit = document.getElementById(
		"clear_stock_form_edit"
	);
	const closeEditStockModal = document.getElementById(
		"close_edit_modal_stock"
	);

	// Close
	clearStockButtonEdit.addEventListener("click", function () {
		closeConfirmation(editFormStock, editValidatorStock, modalEditStock);
	});
	// X
	closeEditStockModal.addEventListener("click", function () {
		closeConfirmation(editFormStock, editValidatorStock, modalEditStock);
	});

	addSubmitStock.addEventListener("click", function (e) {
		// Prevent default button action
		e.preventDefault();

		// Validate form before submit
		if (addValidatorStock) {
			addValidatorStock.validate().then(function (status) {
				if (status == "Valid") {
					Swal.fire({
						text: "Are you sure you would like to continue?",
						icon: "warning",
						showCancelButton: true,
						buttonsStyling: false,
						confirmButtonText: "Yes",
						cancelButtonText: "No",
						customClass: {
							confirmButton: "btn btn-primary",
							cancelButton: "btn btn-active-light",
						},
					}).then((result) => {
						if (result.isConfirmed) {
							// Show loading indication
							addSubmitStock.setAttribute(
								"data-kt-indicator",
								"on"
							);

							// Disable button to avoid multiple click
							addSubmitStock.disabled = true;

							// Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
							setTimeout(function () {
								// Remove loading indication
								addSubmitStock.removeAttribute(
									"data-kt-indicator"
								);

								// Enable button
								addSubmitStock.disabled = false;

								AddStock();
							}, 2000);
						}
					});
				}
			});
		}
	});

	editSubmitStock.addEventListener("click", function (e) {
		// Prevent default button action
		e.preventDefault();

		// Validate form before submit
		if (editValidatorStock) {
			editValidatorStock.validate().then(function (status) {
				if (status == "Valid") {
					Swal.fire({
						text: "Are you sure you would like to continue?",
						icon: "warning",
						showCancelButton: true,
						buttonsStyling: false,
						confirmButtonText: "Yes",
						cancelButtonText: "No",
						customClass: {
							confirmButton: "btn btn-primary",
							cancelButton: "btn btn-active-light",
						},
					}).then((result) => {
						if (result.isConfirmed) {
							// Show loading indication
							editSubmitStock.setAttribute(
								"data-kt-indicator",
								"on"
							);

							// Disable button to avoid multiple click
							editSubmitStock.disabled = true;

							// Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
							setTimeout(function () {
								// Remove loading indication
								editSubmitStock.removeAttribute(
									"data-kt-indicator"
								);

								// Enable button
								editSubmitStock.disabled = false;

								UpdateStock();
							}, 2000);
						}
					});
				}
			});
		}
	});
});

var modalAddStock = new bootstrap.Modal(
	document.getElementById("add_stock_modal"),
	{
		backdrop: "static",
		keyboard: false,
	}
);

var modalEditStock = new bootstrap.Modal(
	document.getElementById("edit_stock_modal"),
	{
		backdrop: "static",
		keyboard: false,
	}
);

function AddStock() {
	$.ajax({
		url: window.location.origin + "/controllers/stock_inventory.php",
		type: "POST",
		data: {
			action: "add_stock",
			stock_category: $('[name="stock_category"]').val(),
			delivery: $('[name="delivery_today"]').val(),
			total_out: $('[name="total_out"]').val(),
		},
		dataType: "JSON",
		beforeSend: function () {},
		success: function (response) {
			console.log(response.message);
			console.log(response.type);
			Alert(response.message, response.type);
		},
		complete: function () {},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
		},
	});
}

function Alert(message, type) {
	Swal.fire({
		text: message,
		icon: type,
		buttonsStyling: false,
		confirmButtonText: "Ok, got it!",
		customClass: { confirmButton: "btn btn-primary" },
	}).then(() => {
		location.reload(); // Reload the current page
	});
}
const GetEditValueStock = (stock_id) => {
	modalEditStock.show();
	// // Trigger validation after reading default values
	if (stock_id !== "") {
		$.ajax({
			url: window.location.origin + "/controllers/stock_inventory.php",
			type: "POST",
			data: {
				action: "get_stock_details",
				stock_id: stock_id,
			},
			dataType: "JSON",
			beforeSend: function () {},
			success: function (response) {
				$('[name="stock_id_edit"]').val(response.stock_id);
				$('[name="delivery_today_edit"]').val(response.delivery);
				$('[name="total_out_edit"]').val(response.total_out);
				$('[name="price_edit"]').val(response.price);
				$('[name="stock_category_edit"]').val(response.stock_category);
			},
			complete: function () {},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			},
		});
	}
};

const UpdateStock = () => {
	$.ajax({
		url: window.location.origin + "/controllers/stock_inventory.php", // Action
		type: "POST", // Method
		data: {
			action: "update_stock",
			stock_id: $('[name="stock_id_edit"]').val(),
			delivery: $('[name="delivery_today_edit"]').val(),
			total_out: $('[name="total_out_edit"]').val(),
			price_today: $('[name="price_edit"]').val(),
			stock_category: $('[name="stock_category_edit"]').val(),
		},
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
