document.addEventListener("DOMContentLoaded", function (e) {
	const addFormExpense = document.getElementById("add_expense_form");
	const editFormExpense = document.getElementById("edit_expense_form");
	const addSubmitExpense = document.getElementById("add_expense_submit");
	const editSubmitExpense = document.getElementById("edit_expense_submit");

	var addValidatorExpense = FormValidation.formValidation(addFormExpense, {
		fields: {
			// expense_name_dd: {
			// 	validators: {
			// 		notEmpty: {
			// 			message: "Select expense name",
			// 		},
			// 	},
			// },
			// expense_name: {
			// 	validators: {
			// 		notEmpty: {
			// 			message: "Please enter expense name",
			// 		},
			// 	},
			// },
			amount: {
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

	var editValidatorExpense = FormValidation.formValidation(editFormExpense, {
		fields: {
			expense_name: {
				validators: {
					notEmpty: {
						message: "Please enter expense name",
					},
				},
			},
			amount: {
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
	// ADD MODAL
	const clearExpenseButton = document.getElementById("clear_expense_form");
	const closeAddExpenseModal = document.getElementById("close_expense_modal");

	// Close
	clearExpenseButton.addEventListener("click", function () {
		closeConfirmation(addFormExpense, addValidatorExpense, modalAddExpense);
	});
	// X
	closeAddExpenseModal.addEventListener("click", function () {
		closeConfirmation(addFormExpense, addValidatorExpense, modalAddExpense);
	});
	// EDIT MODAL
	const clearExpenseButtonEdit = document.getElementById(
		"clear_expense_form_edit"
	);
	const closeEditExpenseModal = document.getElementById(
		"close_edit_modal_expense"
	);

	// Close
	clearExpenseButtonEdit.addEventListener("click", function () {
		closeConfirmation(
			addFormExpense,
			addValidatorExpense,
			modalEditExpense
		);
	});
	// X
	closeEditExpenseModal.addEventListener("click", function () {
		closeConfirmation(
			editFormExpense,
			editValidatorExpense,
			modalEditExpense
		);
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
	addSubmitExpense.addEventListener("click", function (e) {
		// Prevent default button action
		e.preventDefault();

		// Validate form before submit
		if (addValidatorExpense) {
			addValidatorExpense.validate().then(function (status) {
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
							addSubmitExpense.setAttribute(
								"data-kt-indicator",
								"on"
							);

							// Disable button to avoid multiple click
							addSubmitExpense.disabled = true;

							// Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
							setTimeout(function () {
								// Remove loading indication
								addSubmitExpense.removeAttribute(
									"data-kt-indicator"
								);

								// Enable button
								addSubmitExpense.disabled = false;

								AddExpense();
							}, 2000);
						}
					});
				}
			});
		}
	});

	editSubmitExpense.addEventListener("click", function (e) {
		// Prevent default button action
		e.preventDefault();

		// Validate form before submit
		if (editValidatorExpense) {
			editValidatorExpense.validate().then(function (status) {
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
							editSubmitExpense.setAttribute(
								"data-kt-indicator",
								"on"
							);

							// Disable button to avoid multiple click
							editSubmitExpense.disabled = true;

							// Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
							setTimeout(function () {
								// Remove loading indication
								editSubmitExpense.removeAttribute(
									"data-kt-indicator"
								);

								// Enable button
								editSubmitExpense.disabled = false;

								UpdateExpense();
							}, 2000);
						}
					});
				}
			});
		}
	});
});
var modalAddExpense = new bootstrap.Modal(
	document.getElementById("add_expense_modal"),
	{
		backdrop: "static",
		keyboard: false,
	}
);

var modalEditExpense = new bootstrap.Modal(
	document.getElementById("edit_expense_modal"),
	{
		backdrop: "static",
		keyboard: false,
	}
);

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

const AddExpense = () => {
	var selectedCategory = document.querySelector("#expense_name_dd").value;
	var expense_name = "";
	if (selectedCategory === "Others") {
		expense_name = $('[name="expense_name"]').val();
	} else {
		expense_name = selectedCategory;
	}
	console.log(expense_name);
	$.ajax({
		url:
			window.location.origin +
			"/TOM_S1/controllers/expense_inventory.php",
		type: "POST",
		data: {
			action: "add_expense",
			expense_name: expense_name,
			amount: $('[name="amount"]').val(),
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

const GetEditValueExpense = (expense_id) => {
	modalEditExpense.show();
	// Trigger validation after reading default values
	if (expense_id !== "") {
		$.ajax({
			url:
				window.location.origin +
				"/TOM_S1/controllers/expense_inventory.php",
			type: "POST",
			data: {
				action: "get_expense_details",
				expense_id: expense_id,
			},
			dataType: "JSON",
			beforeSend: function () {},
			success: function (response) {
				$('[name="expense_id"]').val(response.expense_id);
				$('[name="expense_name_edit"]').val(response.expense_name);
				$('[name="amount_edit"]').val(response.expense_total);
			},
			complete: function () {},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			},
		});
	}
};
// Hide the Expense Name input initially
var expenseNameGroup = document.getElementById("expense-name-group");
expenseNameGroup.style.display = "none";

const ChangeCategory = () => {
	var selectedCategory = document.querySelector("#expense_name_dd").value;
	if (selectedCategory === "Others") {
		expenseNameGroup.style.display = "block";
	} else {
		expenseNameGroup.style.display = "none";
	}
};

const UpdateExpense = () => {
	$.ajax({
		url:
			window.location.origin +
			"/TOM_S1/controllers/expense_inventory.php", // Action
		type: "POST", // Method
		data: {
			action: "update_expense",
			expense_id: $('[name="expense_id"]').val(),
			expense_name: $('[name="expense_name_edit"]').val(),
			expense_total: $('[name="amount_edit"]').val(),
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

const DeleteExpense = (expense_id) => {
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
			DeleteNow(expense_id);
		}
	});
};

const DeleteNow = (expense_id) => {
	$.ajax({
		url:
			window.location.origin +
			"/TOM_S1/controllers/expense_inventory.php", // Action
		type: "POST", // Method
		data: {
			action: "delete_expense",
			expense_id: expense_id,
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
