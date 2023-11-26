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
document.addEventListener("DOMContentLoaded", function (e) {
	const addForm = document.getElementById("add_category_form");
	const editForm = document.getElementById("edit_category_form");
	const addSubmit = document.getElementById("add_category_button");
	const editSubmit = document.getElementById("edit_category_button");

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
				form.reset();
				validator.resetForm();
				modal.hide();
			}
		});
	};
	addSubmit.addEventListener("click", function (e) {
		// Prevent default button action
		e.preventDefault();

		// Validate form before submit
		addValidator.validate().then(function (status) {
			if (status === "Valid") {
				// Show loading indication
				addButton.setAttribute("data-kt-indicator", "on");

				// Disable button to avoid multiple click
				addButton.disabled = true;

				// Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
				setTimeout(function () {
					// Remove loading indication
					addButton.removeAttribute("data-kt-indicator");

					// Enable button
					addButton.disabled = false;

					// AddStaff();
				}, 2000);
			}
		});
	});
});

const GetEditValue = (category_id) => {
	modalEditCategory.show();
	// Trigger validation after reading default values
	// if (staff_id !== "") {
	// 	$.ajax({
	// 		url: window.location.origin + "/TOM_S1/controllers/menu.php",
	// 		type: "POST",
	// 		data: {
	// 			action: "get_staff_details",
	// 			staff_id: staff_id,
	// 		},
	// 		dataType: "JSON",
	// 		beforeSend: function () {},
	// 		success: function (response) {
	// 			$("#staff_id").val(response.staff_id);
	// 			$("#full_name").val(response.full_name);
	// 			$("#username").val(response.username);
	// 			$("#email").val(response.email);
	// 			$("input[name=status][value=" + response.status + "]").prop(
	// 				"checked",
	// 				true
	// 			);
	// 			$("#password").val(response.password);
	// 			$("#cpassword").val(response.cpassword);
	// 		},
	// 		complete: function () {},
	// 		error: function (jqXHR, textStatus, errorThrown) {
	// 			console.log(errorThrown);
	// 		},
	// 	});
	// }
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
