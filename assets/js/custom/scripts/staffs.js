document.addEventListener("DOMContentLoaded", function (e) {
	const form = document.getElementById("add_staff_form");
	const form1 = document.getElementById("edit_staff_form");
	// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
	var validator = FormValidation.formValidation(form, {
		fields: {
			full_name: {
				validators: {
					notEmpty: {
						message: "Full Name is required",
					},
					stringLength: {
						message: "Full Name must be at least 5 characters",
						min: 5,
					},
				},
			},
			username: {
				validators: {
					notEmpty: {
						message: "Username is required",
					},
					stringLength: {
						message: "Username must be 4-20 characters only",
						min: 4,
						max: 20,
					},
					remote: {
						url:
							window.location.origin +
							"/TOM_S1/controllers/validusername.php",
						data: function () {
							return {
								username:
									form.querySelector('[name="username"]')
										.value,
							};
						},
						message: "The username is not available",
						method: "POST",
					},
				},
			},
			email: {
				validators: {
					emailAddress: {
						message: "Invalid email address",
					},
					notEmpty: {
						message: "Email address is required",
					},
				},
			},
			password: {
				validators: {
					notEmpty: {
						message: "The password is required and cannot be empty",
					},
					stringLength: {
						message: "Password must be at least 8 characters",
						min: 8,
					},
				},
			},
			cpassword: {
				validators: {
					notEmpty: {
						message:
							"The confirm password is required and cannot be empty",
					},
					identical: {
						compare: function () {
							return form.querySelector('[name="password"]')
								.value;
						},
						message: "Password doesn't match",
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
	// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
	var validator1 = FormValidation.formValidation(form1, {
		fields: {
			full_name: {
				validators: {
					notEmpty: {
						message: "Full Name is required",
					},
					stringLength: {
						message: "Full Name must be at least 5 characters",
						min: 5,
					},
				},
			},
			username: {
				validators: {
					notEmpty: {
						message: "Username is required",
					},
					stringLength: {
						message: "Username must be 4-20 characters only",
						min: 4,
						max: 20,
					},
				},
			},
			email: {
				validators: {
					emailAddress: {
						message: "Invalid email address",
					},
					notEmpty: {
						message: "Email address is required",
					},
				},
			},
			password: {
				validators: {
					stringLength: {
						message: "Password must be at least 8 characters",
						min: 8,
					},
				},
			},
			cpassword: {
				validators: {
					identical: {
						compare: function () {
							return form1.querySelector('[name="password"]')
								.value;
						},
						message: "Password doesn't match",
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
	// Enable the password/confirm password validators if the password is not empty
	let enabled = false;
	form.querySelector('[name="password"]').addEventListener(
		"input",
		function (e) {
			const password = e.target.value;
			const cpassword = form.querySelector('[name="password"]').value;
			if (password === "" && enabled) {
				enabled = false;
				validator
					.disableValidator("password")
					.disableValidator("cpassword");
			} else if (password != "" && !enabled) {
				enabled = true;
				validator
					.enableValidator("password")
					.enableValidator("cpassword");
			} else if (cpassword != "" && !enabled) {
				enabled = true;
				validator
					.enableValidator("password")
					.enableValidator("cpassword");
			}
			// Revalidate the confirmation password when the new password is changed
			if (password != "" && enabled) {
				validator.revalidateField("cpassword");
			}
		}
	);
	// Enable the password/confirm password validators if the password is not empty
	form1
		.querySelector('[name="password"]')
		.addEventListener("input", function (e) {
			const password = e.target.value;
			const cpassword = form1.querySelector('[name="password"]').value;
			if (password === "" && enabled) {
				enabled = false;
				validator1
					.disableValidator("password")
					.disableValidator("cpassword");
			} else if (password != "" && !enabled) {
				enabled = true;
				validator1
					.enableValidator("password")
					.enableValidator("cpassword");
			} else if (cpassword != "" && !enabled) {
				enabled = true;
				validator1
					.enableValidator("password")
					.enableValidator("cpassword");
			}
			// Revalidate the confirmation password when the new password is changed
			if (password != "" && enabled) {
				validator1.revalidateField("cpassword");
			}
		});

	const addButton = document.getElementById("add_staff_submit");
	const updateButton = document.getElementById("update_staff_submit");
	const clearButton = document.getElementById("clear_staff_form");
	const clearButtonEdit = document.getElementById("clear_staff_form_edit");
	const closeButton = document.querySelector('.btn[data-bs-dismiss="modal"]');
	const closeButtonEdit = document.querySelector(
		'.edit[data-bs-dismiss="modal"]'
	);
	const closeModal = document.getElementById("close_modal");
	const closeModalEdit = document.getElementById("close_modal1");

	// Add an event listener to the "Clear" button to show a confirmation modal
	clearButton.addEventListener("click", function () {
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
				// Trigger a click event on the close button to dismiss the modal
				closeButton.click();
			}
		});
	});
	// Add an event listener to the "Clear" button to show a confirmation modal
	clearButtonEdit.addEventListener("click", function () {
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
				form1.reset();
				validator1.resetForm();
				// Trigger a click event on the close button to dismiss the modal
				closeButtonEdit.click();
			}
		});
	});
	// Add an event listener to the "Clear" button to show a confirmation modal
	closeModal.addEventListener("click", function () {
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
				// Trigger a click event on the close button to dismiss the modal
				closeButton.click();
			}
		});
	});
	// Add an event listener to the "Clear" button to show a confirmation modal
	closeModalEdit.addEventListener("click", function () {
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
				form1.reset();
				validator1.resetForm();
				// Trigger a click event on the close button to dismiss the modal
				closeButtonEdit.click();
			}
		});
	});

	addButton.addEventListener("click", function (e) {
		// Prevent default button action
		e.preventDefault();

		// Validate form before submit
		if (validator) {
			validator.validate().then(function (status) {
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
							addButton.setAttribute("data-kt-indicator", "on");
							// Disable button to avoid multiple click
							addButton.disabled = true;
							// Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
							setTimeout(function () {
								// Remove loading indication
								addButton.removeAttribute("data-kt-indicator");
								// Enable button
								addButton.disabled = false;

								AddStaff();
							}, 2000);
						}
					});
				}
			});
		}
	});
	updateButton.addEventListener("click", function (e) {
		// Prevent default button action
		e.preventDefault();

		// Validate form before submit
		if (validator1) {
			validator1.validate().then(function (status) {
				if (status == "Valid") {
					Swal.fire({
						text: "Are you sure you would like to update staff account?",
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
							updateButton.setAttribute(
								"data-kt-indicator",
								"on"
							);

							// Disable button to avoid multiple click
							updateButton.disabled = true;

							// Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
							setTimeout(function () {
								// Remove loading indication
								updateButton.removeAttribute(
									"data-kt-indicator"
								);

								// Enable button
								updateButton.disabled = false;

								UpdateStaff();
							}, 2000);
						}
					});
				}
			});
		}
	});
});
var ModalEdit = new bootstrap.Modal(document.getElementById("kt_modal_2"), {});
document.onreadystatechange = function () {
	// myModal.show();
};
const AddStaff = () => {
	$.ajax({
		url: window.location.origin + "/TOM_S1/controllers/accounts.php", // Action
		type: "POST", // Method
		data: {
			action: "add_staff",
			full_name: $('[name="full_name"]').val(),
			username: $('[name="username"]').val(),
			email: $('[name="email"]').val(),
			password: $('[name="password"]').val(),
			cpassword: $('[name="cpassword"]').val(),
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

const UpdateStaff = () => {
	// User clicked "Yes"
	$.ajax({
		url: window.location.origin + "/TOM_S1/controllers/accounts.php", // Action
		type: "POST", // Method
		data: {
			action: "update_staff",
			staff_id: $("#staff_id").val(),
			full_name: $("#full_name").val(),
			username: $("#username").val(),
			email: $("#email").val(),
			status: $('[name="status"]:checked').val(),
			password: $("#password").val(),
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

const GetEditValue = (staff_id) => {
	ModalEdit.show();
	// Trigger validation after reading default values
	if (staff_id !== "") {
		$.ajax({
			url: window.location.origin + "/TOM_S1/controllers/accounts.php",
			type: "POST",
			data: {
				action: "get_staff_details",
				staff_id: staff_id,
			},
			dataType: "JSON",
			beforeSend: function () {},
			success: function (response) {
				$("#staff_id").val(response.staff_id);
				$("#full_name").val(response.full_name);
				$("#username").val(response.username);
				$("#email").val(response.email);
				$("input[name=status][value=" + response.status + "]").prop(
					"checked",
					true
				);
				$("#password").val(response.password);
				$("#cpassword").val(response.cpassword);
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
