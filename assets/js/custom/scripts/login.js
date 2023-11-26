document.addEventListener("DOMContentLoaded", function (e) {
	const formLogin = document.getElementById("form_login");

	var loginFormValidator = FormValidation.formValidation(formLogin, {
		fields: {
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
		},
		plugins: {
			trigger: new FormValidation.plugins.Trigger(),
			bootstrap: new FormValidation.plugins.Bootstrap5({
				rowSelector: ".fv-row",
				eleInvalidClass: "",
				eleValidClass: "",
			}),
		},
	});

	const signInBtn = document.getElementById("sign_in_submit");

	signInBtn.addEventListener("click", function (e) {
		// Prevent default button action
		e.preventDefault();
		// Validate form before submit
		if (loginFormValidator) {
			loginFormValidator.validate().then(function (status) {
				if (status == "Valid") {
					Swal.fire({
						text: "Are you sure you would like to continue login?",
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
							LoginNow();
						}
					});
				}
			});
		}
	});
});

const LoginNow = () => {
	$.ajax({
		url:
			window.location.origin + "/TOM_S1/controllers/user_credentials.php", // Action
		type: "POST", // Method
		data: {
			action: "login_account",
			username: $('[name="username"]').val(),
			password: $('[name="password"]').val(),
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

const Alert = (message, type, ok) => {
	Swal.fire({
		text: message,
		icon: type,
		buttonsStyling: false,
		confirmButtonText: "Ok, got it!",
		customClass: { confirmButton: "btn btn-primary" },
	}).then(() => {
		if (type === "success") {
			location.reload();
		}
	});
};
