document.addEventListener("DOMContentLoaded", function (e) {
	const addForm = document.getElementById("add_voucher_form");
	const editForm = document.getElementById("edit_voucher_form");
	const addSubmit = document.getElementById("add_voucher_submit");
	const editSubmit = document.getElementById("edit_voucher_submit");

	var addValidator = FormValidation.formValidation(addForm, {
		fields: {
			voucher_code: {
				validators: {
					notEmpty: {
						message: "Voucher Code is required",
					},
					stringLength: {
						message: "Voucher Code must be at least 2 characters",
						min: 2,
					},
				},
			},
			voucher_percent: {
				validators: {
					notEmpty: {
						message: "Voucher Percent is required",
					},
					between: {
						min: 1,
						max: 100,
						message:
							"Percent must be between 1 to 100 percent only",
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

	var editValidator = FormValidation.formValidation(editForm, {
		fields: {
			voucher_code_edit: {
				validators: {
					notEmpty: {
						message: "Voucher Code is required",
					},
					stringLength: {
						message: "Voucher Code must be at least 2 characters",
						min: 2,
					},
				},
			},
			voucher_percent_edit: {
				validators: {
					notEmpty: {
						message: "Voucher Percent is required",
					},
					between: {
						min: 1,
						max: 100,
						message:
							"Percent must be between 1 to 100 percent only",
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

	// ADD MODAL
	const clearCategoryButton = document.getElementById("clear_voucher_form");
	const closeAddCategoryModal = document.getElementById("close_add_modal");

	// Close
	clearCategoryButton.addEventListener("click", function () {
		closeConfirmation(addForm, addValidator, modalAddCategory);
	});
	// X
	closeAddCategoryModal.addEventListener("click", function () {
		closeConfirmation(addForm, addValidator, modalAddCategory);
	});

	// EDIT MODAL
	const clearCategoryButtonEdit = document.getElementById(
		"clear_voucher_form_edit"
	);
	const closeEditCategoryModal = document.getElementById("close_edit_modal");

	// Close
	clearCategoryButtonEdit.addEventListener("click", function () {
		closeConfirmation(editForm, editValidator, modalEditCategory);
	});
	// X
	closeEditCategoryModal.addEventListener("click", function () {
		closeConfirmation(editForm, editValidator, modalEditCategory);
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
	addSubmit.addEventListener("click", function (e) {
		// Prevent default button action
		e.preventDefault();

		// Validate form before submit
		if (addValidator) {
			addValidator.validate().then(function (status) {
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
							addSubmit.setAttribute("data-kt-indicator", "on");

							// Disable button to avoid multiple click
							addSubmit.disabled = true;

							// Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
							setTimeout(function () {
								// Remove loading indication
								addSubmit.removeAttribute("data-kt-indicator");

								// Enable button
								addSubmit.disabled = false;

								AddVoucher();
							}, 2000);
						}
					});
				}
			});
		}
	});

	editSubmit.addEventListener("click", function (e) {
		// Prevent default button action
		e.preventDefault();
		console.log(editValidator);
		// Validate form before submit
		if (editValidator) {
			editValidator.validate().then(function (status) {
				if (status == "Valid") {
					Swal.fire({
						text: "Are you sure you would like to update voucher?",
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
							editSubmit.setAttribute("data-kt-indicator", "on");

							// Disable button to avoid multiple click
							editSubmit.disabled = true;

							// Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
							setTimeout(function () {
								// Remove loading indication
								editSubmit.removeAttribute("data-kt-indicator");

								// Enable button
								editSubmit.disabled = false;

								UpdateCategory();
							}, 2000);
						}
					});
				}
			});
		}
	});
});

var modalAddCategory = new bootstrap.Modal(
	document.getElementById("add_voucher_modal"),
	{
		backdrop: "static",
		keyboard: false,
	}
);

var modalEditCategory = new bootstrap.Modal(
	document.getElementById("edit_voucher_modal"),
	{
		backdrop: "static",
		keyboard: false,
	}
);

const AddVoucher = () => {
	$.ajax({
		url: window.location.origin + "/TOM_S1/controllers/discounts.php", // Action
		type: "POST", // Method
		data: {
			action: "add_voucher",
			voucher_code: $('[name="voucher_code"]').val(),
			voucher_percent: $('[name="voucher_percent"]').val(),
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

const UpdateCategory = () => {
	$.ajax({
		url: window.location.origin + "/TOM_S1/controllers/discounts.php", // Action
		type: "POST", // Method
		data: {
			action: "update_voucher",
			voucher_id: $('[name="voucher_id_edit"]').val(),
			voucher_code: $('[name="voucher_code_edit"]').val(),
			voucher_percent: $('[name="voucher_percent_edit"]').val(),
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
const SetStatus = (voucher_id, status) => {
	var mes = "";
	if (status === "inactive") {
		status = "active";
		mes = "active";
	} else if (status === "active") {
		status = "inactive";
		mes = "inactive";
	}
	Swal.fire({
		text: "Are you sure you would like to set this voucher " + mes + "?",
		icon: "warning",
		showCancelButton: !0,
		buttonsStyling: !1,
		confirmButtonText: "Yes, set it to " + mes + "!",
		cancelButtonText: "No, return",
		customClass: {
			confirmButton: "btn btn-primary",
			cancelButton: "btn btn-active-light",
		},
	}).then((result) => {
		if (result.isConfirmed) {
			SetNow(voucher_id, status);
		}
	});
};
const SetNow = (voucher_id, status) => {
	$.ajax({
		url: window.location.origin + "/TOM_S1/controllers/discounts.php",
		type: "POST",
		data: {
			action: "set_status",
			voucher_id: voucher_id,
			status: status,
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

const GetEditValue = (voucher_id) => {
	modalEditCategory.show();
	// Trigger validation after reading default values
	if (voucher_id !== "") {
		$.ajax({
			url: window.location.origin + "/TOM_S1/controllers/discounts.php",
			type: "POST",
			data: {
				action: "get_voucher_details",
				voucher_id: voucher_id,
			},
			dataType: "JSON",
			beforeSend: function () {},
			success: function (response) {
				$("[name='voucher_id_edit']").val(response.voucher_id);
				$("[name='voucher_code_edit']").val(response.voucher_code);
				$("[name='voucher_percent_edit']").val(
					response.voucher_percent
				);
			},
			complete: function () {},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			},
		});
	}
};

const Alert = (message, type) => {
	Swal.fire({
		text: message,
		icon: type,
		buttonsStyling: false,
		confirmButtonText: "Ok, got it!",
		customClass: { confirmButton: "btn btn-primary" },
	}).then(() => {
		location.reload();
	});
};
