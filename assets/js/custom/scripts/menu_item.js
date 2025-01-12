document.addEventListener("DOMContentLoaded", function (e) {
	const addFormItem = document.getElementById("add_item_form");
	const editFormItem = document.getElementById("edit_item_form");
	const addSubmitItem = document.getElementById("add_item_submit");
	const editSubmitItem = document.getElementById("edit_item_submit");

	var addValidatorItem = FormValidation.formValidation(addFormItem, {
		fields: {
			category_id: {
				validators: {
					notEmpty: {
						message: "Please select a item category",
					},
				},
			},
			item_name: {
				validators: {
					notEmpty: {
						message: "Item Name cannot be empty",
					},
				},
			},
			price: {
				validators: {
					integer: {
						message: "Please enter number only",
						// The default separators
						thousandsSeparator: "",
						decimalSeparator: ".",
					},
					notEmpty: {
						message: "Price cannot be empty",
					},
				},
			},
			description: {
				validators: {
					notEmpty: {
						message: "Description cannot be empty",
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

	var editValidatorItem = FormValidation.formValidation(editFormItem, {
		fields: {
			category_id: {
				validators: {
					notEmpty: {
						message: "Please select a item category",
					},
				},
			},
			item_name: {
				validators: {
					notEmpty: {
						message: "Item Name cannot be empty",
					},
				},
			},
			price: {
				validators: {
					integer: {
						message: "Please enter number only",
						// The default separators
						thousandsSeparator: "",
						decimalSeparator: ".",
					},
					notEmpty: {
						message: "Price cannot be empty",
					},
				},
			},
			description: {
				validators: {
					notEmpty: {
						message: "Description cannot be empty",
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
	const clearItemButton = document.getElementById("clear_item_form");
	const closeAddItemModal = document.getElementById("close_item_modal");

	// Close
	clearItemButton.addEventListener("click", function () {
		closeConfirmation(addFormItem, addValidatorItem, modalAddItem);
	});
	// X
	closeAddItemModal.addEventListener("click", function () {
		closeConfirmation(addFormItem, addValidatorItem, modalAddItem);
	});

	// EDIT MODAL
	const clearItemButtonEdit = document.getElementById("clear_item_form_edit");
	const closeEditItemModal = document.getElementById("close_edit_modal_item");

	// Close
	clearItemButtonEdit.addEventListener("click", function () {
		closeConfirmation(editFormItem, editValidatorItem, modalEditItem);
	});
	// X
	closeEditItemModal.addEventListener("click", function () {
		closeConfirmation(editFormItem, editValidatorItem, modalEditItem);
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
	addSubmitItem.addEventListener("click", function (e) {
		// Prevent default button action
		e.preventDefault();

		// Validate form before submit
		if (addValidatorItem) {
			addValidatorItem.validate().then(function (status) {
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
							addSubmitItem.setAttribute(
								"data-kt-indicator",
								"on"
							);

							// Disable button to avoid multiple click
							addSubmitItem.disabled = true;

							// Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
							setTimeout(function () {
								// Remove loading indication
								addSubmitItem.removeAttribute(
									"data-kt-indicator"
								);

								// Enable button
								addSubmitItem.disabled = false;

								AddItem();
							}, 2000);
						}
					});
				}
			});
		}
	});

	editSubmitItem.addEventListener("click", function (e) {
		// Prevent default button action
		e.preventDefault();
		// Validate form before submit
		if (editValidatorItem) {
			editValidatorItem.validate().then(function (status) {
				if (status == "Valid") {
					Swal.fire({
						text: "Are you sure you would like to update category menu?",
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
							editSubmitItem.setAttribute(
								"data-kt-indicator",
								"on"
							);

							// Disable button to avoid multiple click
							editSubmitItem.disabled = true;

							// Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
							setTimeout(function () {
								// Remove loading indication
								editSubmitItem.removeAttribute(
									"data-kt-indicator"
								);

								// Enable button
								editSubmitItem.disabled = false;

								UpdateItem();
							}, 2000);
						}
					});
				}
			});
		}
	});
});
var modalAddItem = new bootstrap.Modal(
	document.getElementById("add_item_modal"),
	{
		backdrop: "static",
		keyboard: false,
	}
);

var modalEditItem = new bootstrap.Modal(
	document.getElementById("edit_item_modal"),
	{
		backdrop: "static",
		keyboard: false,
	}
);
const AddItem = () => {
	let form_data = new FormData();
	let item_image_data = $("#item_image")[0].files;
	form_data.append("item_image", item_image_data[0]);

	// Append other form inputs to the FormData object
	form_data.append("action", "add_item");
	form_data.append("category_id", $('[name="category_id"]').val());
	form_data.append("item_name", $('[name="item_name"]').val());
	form_data.append("price", $('[name="price"]').val());
	form_data.append("description", $('[name="description"]').val());

	$.ajax({
		url: window.location.origin + "/controllers/menu.php",
		type: "POST",
		data: form_data,
		processData: false,
		contentType: false,
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

const UpdateItem = () => {
	let form_data = new FormData();
	let item_image_data = $("#item_image_edit")[0].files;
	form_data.append("item_image", item_image_data[0]);

	// Append other form inputs to the FormData object
	form_data.append("action", "update_item");
	form_data.append("item_id", $('[name="item_id_edit"]').val());
	form_data.append("image_old", $('[name="image_old_edit"]').val());
	form_data.append("category_id", $('[name="category_id_edit"]').val());
	form_data.append("item_name", $('[name="item_name_edit"]').val());
	form_data.append("price", $('[name="price_edit"]').val());
	form_data.append("description", $('[name="description_edit"]').val());

	$.ajax({
		url: window.location.origin + "/controllers/menu.php", // Action
		type: "POST", // Method
		data: form_data,
		processData: false,
		contentType: false,
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

const GetEditValueItem = (item_id) => {
	modalEditItem.show();
	// Trigger validation after reading default values
	if (item_id !== "") {
		$.ajax({
			url: window.location.origin + "/controllers/menu.php",
			type: "POST",
			data: {
				action: "get_item_details",
				item_id: item_id,
			},
			dataType: "JSON",
			beforeSend: function () {},
			success: function (response) {
				$('[name="item_id_edit"]').val(response.item_id);
				$('[name="image_old_edit"]').val(response.item_image);
				$('[name="item_name_edit"]').val(response.item_name);
				$('[name="price_edit"]').val(response.price);
				$('[name="description_edit"]').val(response.description);
				img_placeholder = document.querySelector(".edit-image");
				img_placeholder.style.backgroundImage =
					"url(images/uploads/" + response.item_image + ")";
				category_dom = document.getElementById("category_id_edit");
				category_dom.value = response.category_id;
			},
			complete: function () {},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			},
		});
	}
};
const ArchiveItem = (item_id, status) => {
	var mes = "";
	if (status === "unarchived") {
		status = "archived";
		mes = "archive";
	} else if (status === "archived") {
		status = "unarchived";
		mes = "unarchive";
	}
	Swal.fire({
		text: "Are you sure you would like to " + mes + " this item?",
		icon: "warning",
		showCancelButton: !0,
		buttonsStyling: !1,
		confirmButtonText: "Yes, " + mes + " it!",
		cancelButtonText: "No, return",
		customClass: {
			confirmButton: "btn btn-primary",
			cancelButton: "btn btn-active-light",
		},
	}).then((result) => {
		if (result.isConfirmed) {
			ArchiveNow(item_id, status);
		}
	});
};
const ArchiveNow = (item_id, status) => {
	$.ajax({
		url: window.location.origin + "/controllers/menu.php",
		type: "POST",
		data: { action: "archive_item", item_id: item_id, status: status },
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
