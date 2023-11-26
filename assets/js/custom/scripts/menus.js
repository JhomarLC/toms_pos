document.addEventListener("DOMContentLoaded", function (e) {
	const addForm = document.getElementById("add_category_form");
	const editForm = document.getElementById("edit_category_form");
	const addSubmit = document.getElementById("add_category_submit");
	const editSubmit = document.getElementById("edit_category_submit");

	var addValidator = FormValidation.formValidation(addForm, {
		fields: {
			category_name: {
				validators: {
					notEmpty: {
						message: "Category Name is required",
					},
					stringLength: {
						message: "Category Name must be at least 2 characters",
						min: 2,
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
			category_name_edit: {
				validators: {
					notEmpty: {
						message: "Category Name is required",
					},
					stringLength: {
						message: "Category Name must be at least 2 characters",
						min: 2,
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
	const clearCategoryButton = document.getElementById("clear_category_form");
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
		"clear_category_form_edit"
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

								AddCategory();
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
	document.getElementById("add_category_modal"),
	{
		backdrop: "static",
		keyboard: false,
	}
);

var modalEditCategory = new bootstrap.Modal(
	document.getElementById("edit_category_modal"),
	{
		backdrop: "static",
		keyboard: false,
	}
);

const AddCategory = () => {
	let form_data = new FormData();
	let item_category_data = $("#category_image")[0].files;
	form_data.append("category_image", item_category_data[0]);

	form_data.append("action", "add_category");
	form_data.append("category_name", $('[name="category_name"]').val());

	// Display the key/value pairs
	for (var pair of form_data.entries()) {
		console.log(pair[0] + ", " + pair[1]);
	}
	// User clicked "Yes"
	$.ajax({
		url: window.location.origin + "/TOM_S1/controllers/menu.php", // Action
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

const UpdateCategory = () => {
	let form_data = new FormData();
	let category_image_data = $("#category_image_edit")[0].files;
	form_data.append("category_image", category_image_data[0]);

	form_data.append("action", "update_category");
	form_data.append("category_id", $("[name='category_id_edit']").val());
	form_data.append("image_old", $("[name='image_old_edit']").val());
	form_data.append("category_name", $("[name='category_name_edit']").val());

	$.ajax({
		url: window.location.origin + "/TOM_S1/controllers/menu.php", // Action
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

const ArchiveCategory = (category_id, status) => {
	var mes = "";
	if (status === "unarchived") {
		status = "archived";
		mes = "archive";
	} else if (status === "archived") {
		status = "unarchived";
		mes = "unarchive";
	}
	Swal.fire({
		text: "Are you sure you would like to " + mes + " this category?",
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
			ArchiveNow(category_id, status);
		}
	});
};
const ArchiveNow = (category_id, status) => {
	$.ajax({
		url: window.location.origin + "/TOM_S1/controllers/menu.php",
		type: "POST",
		data: {
			action: "archive_category",
			category_id: category_id,
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

const GetEditValue = (category_id) => {
	modalEditCategory.show();
	// Trigger validation after reading default values
	if (category_id !== "") {
		$.ajax({
			url: window.location.origin + "/TOM_S1/controllers/menu.php",
			type: "POST",
			data: {
				action: "get_category_details",
				category_id: category_id,
			},
			dataType: "JSON",
			beforeSend: function () {},
			success: function (response) {
				$("[name='category_id_edit']").val(response.category_id);
				img_placeholder = document.querySelector(".edit-image");
				$('[name="image_old_edit"]').val(response.category_image);

				img_placeholder.style.backgroundImage =
					"url(images/uploads/" + response.category_image + ")";
				$("[name='category_name_edit']").val(response.category_name);
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
		location.reload(); // Reload the current page
	});
};
