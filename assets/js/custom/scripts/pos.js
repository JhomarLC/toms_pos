const tbody = document.querySelector("tbody");
const clearAllButton = document.querySelector("#clear_all");
const saveOrderButton = document.querySelector("#save_order_button");
const incLeftoverBtn = document.querySelector("#incLeftOBtn");
const leftoverInput = document.querySelector("#leftover");
const decLeftoverBtn = document.querySelector("#decLeftOBtn");
const customerCash = document.querySelector("#customer_cash");
const cashSpan = document.querySelector("#cash_span");
const customerChange = document.querySelector("#customerChange");
const customerChangeInput = document.querySelector("#change_input");
const addFormOrder = document.querySelector("#add_order_form");

const grandTotalDisplay = document.querySelector("#grandTotalDisplay");
const grandTotal = document.querySelector("#grand_total");
var orderValidator = FormValidation.formValidation(addFormOrder, {
	fields: {
		customer_cash: {
			validators: {
				integer: {
					message: "Please enter number only",
					// The default separators
					thousandsSeparator: "",
					decimalSeparator: ".",
				},
				callback: {
					message: "The cash must be more than or equal to total",
					callback: function (input) {
						var cashAmount = parseFloat(input.value);
						var totalAmount = parseFloat(grandTotal.value);

						// Check if the cash amount is greater than or equal to the total amount
						return cashAmount >= totalAmount;
					},
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

// Money formatter
var moneyFormat = wNumb({
	mark: ".",
	thousand: ",",
	decimals: 2,
	prefix: "₱",
});

const revalidateOrderField = () => {
	orderValidator.revalidateField("customer_cash");
};
function enableOrderValidator() {
	orderValidator.enableValidator("customer_cash");
}
function disableOrderValidator() {
	orderValidator.disableValidator("customer_cash");
}
customerCash.addEventListener("input", (e) => {
	const customCash = parseInt(e.target.value, 10);
	const maxCash = 100000;

	if (customCash < 100000) {
		cashSpan.textContent = isNaN(customCash)
			? moneyFormat.to(0)
			: moneyFormat.to(customCash);
		calculateTotal();
	}
	cashSpan.textContent = isNaN(customCash)
		? moneyFormat.to(0)
		: moneyFormat.to(customCash);
	// Check if the entered value is greater than $100,000 and limit it to $100,000
	if (customCash > maxCash) {
		e.target.value = maxCash;
		cashSpan.textContent = moneyFormat.to(maxCash);
		calculateTotal();
		updateDiscount();
	}
});

clearAllButton.addEventListener("click", () => {
	Swal.fire({
		text: "Are you sure you would like to remove item?",
		icon: "warning",
		showCancelButton: !0,
		buttonsStyling: !1,
		confirmButtonText: "Yes, remove it!",
		cancelButtonText: "No, return",
		customClass: {
			confirmButton: "btn btn-primary",
			cancelButton: "btn btn-active-light",
		},
	}).then((result) => {
		if (result.isConfirmed) {
			clearAllDialers();
			toggleAllVisibility();
			disableOrderValidator();
		}
	});
});

function createDialer(elem, item_id, item_name, price, image) {
	var existingDialer = document.getElementById("item" + item_id);
	if (existingDialer) {
		Swal.fire({
			text: "Are you sure you would like to remove item?",
			icon: "warning",
			showCancelButton: !0,
			buttonsStyling: !1,
			confirmButtonText: "Yes, remove it!",
			cancelButtonText: "No, return",
			customClass: {
				confirmButton: "btn btn-primary",
				cancelButton: "btn btn-active-light",
			},
		}).then((result) => {
			if (result.isConfirmed) {
				removeDialer(existingDialer);
				toggleRibbonVisibility(elem);
				if (tbody.childElementCount > 0) {
				} else {
					resetAllValues();
					disableOrderValidator();
				}
			}
		});
		return; // Stop further execution if the dialer already exists
	}
	enableOrderValidator();

	var trElement = document.createElement("tr");
	trElement.setAttribute("id", "item" + item_id);
	var td1Element = document.createElement("td");
	td1Element.classList.add("pe-0");

	var div1Element = document.createElement("div");
	div1Element.classList.add("d-flex", "align-items-center");

	var imgElement = document.createElement("img");
	imgElement.setAttribute("src", image);
	imgElement.classList.add("w-50px", "h-50px", "rounded-3", "me-3");

	// Create <span> element within the <div>
	var spanElement = document.createElement("span");
	spanElement.classList.add(
		"fw-bold",
		"text-gray-800",
		"cursor-pointer",
		"text-hover-primary",
		"fs-6",
		"me-1"
	);
	spanElement.textContent = item_name;

	// Append <img> and <span> to the <div>
	div1Element.appendChild(imgElement);
	div1Element.appendChild(spanElement);

	// Append <div> to the first <td>
	td1Element.appendChild(div1Element);

	// Append first <td> to the <tr>
	trElement.appendChild(td1Element);

	// Create second <td> element
	var td2Element = document.createElement("td");
	td2Element.classList.add("pe-0");

	// Create the container <div> for the dialer
	var dialerDivElement = document.createElement("div");
	dialerDivElement.classList.add(
		"position-relative",
		"d-flex",
		"align-items-center"
	);

	// Create the decrease button
	var decreaseButton = document.createElement("button");
	decreaseButton.setAttribute("type", "button");
	decreaseButton.classList.add(
		"btn",
		"btn-icon",
		"btn-sm",
		"btn-light",
		"btn-icon-gray-400"
	);

	var decreaseIcon = document.createElement("i");
	decreaseIcon.classList.add("ki-duotone", "ki-minus", "fs-3x");

	// Create the quantity input
	var quantityInput = document.createElement("input");
	var itemIdInput = document.createElement("input");
	itemIdInput.setAttribute("type", "number");
	itemIdInput.setAttribute("name", "item_ids[]");
	itemIdInput.setAttribute("value", item_id);
	itemIdInput.setAttribute("hidden", true);

	quantityInput.setAttribute("type", "text");
	quantityInput.classList.add(
		"form-control",
		"quantity",
		"border-0",
		"text-center",
		"px-0",
		"fs-3",
		"fw-bold",
		"text-gray-800",
		"w-30px"
	);
	quantityInput.setAttribute("name", "quantities[]");
	quantityInput.setAttribute("readonly", "readonly");
	quantityInput.setAttribute("value", "1");

	// Create the price input
	var priceInput = document.createElement("input");
	priceInput.setAttribute("type", "text");
	priceInput.classList.add(
		"form-control",
		"price",
		"border-0",
		"text-center",
		"px-0",
		"fs-3",
		"fw-bold",
		"text-gray-800",
		"w-30px"
	);
	priceInput.setAttribute("name", "prices[]");
	priceInput.setAttribute("readonly", "readonly");
	priceInput.setAttribute("hidden", "hidden");
	priceInput.setAttribute("value", price);

	// Create the increase button
	var increaseButton = document.createElement("button");
	increaseButton.setAttribute("type", "button");
	increaseButton.classList.add(
		"btn",
		"btn-icon",
		"btn-sm",
		"btn-light",
		"btn-icon-gray-400"
	);

	var increaseIcon = document.createElement("i");
	increaseIcon.classList.add("ki-duotone", "ki-plus", "fs-3x");

	// Append elements to the dialer <div>
	decreaseButton.appendChild(decreaseIcon);
	increaseButton.appendChild(increaseIcon);

	dialerDivElement.appendChild(decreaseButton);
	dialerDivElement.appendChild(itemIdInput);
	dialerDivElement.appendChild(quantityInput);
	dialerDivElement.appendChild(priceInput);
	dialerDivElement.appendChild(increaseButton);

	// Append the dialer <div> to the second <td>
	td2Element.appendChild(dialerDivElement);

	// Append second <td> to the <tr>
	trElement.appendChild(td2Element);

	// Create third <td> element
	var td3Element = document.createElement("td");
	td3Element.classList.add("text-end");

	// Create <span> for the subtotal
	var subtotalSpan = document.createElement("span");
	subtotalSpan.classList.add("subtotal", "fw-bold", "text-primary", "fs-2");
	// subtotalSpan.textContent = "₱289.00";

	// Create an <input> element for mirroring the subtotal value
	var subtotalInput = document.createElement("input");
	subtotalInput.setAttribute("type", "text");
	subtotalInput.classList.add(
		"form-control",
		"subtotalInput",
		"border-0",
		"text-center",
		"px-0",
		"fs-3",
		"fw-bold",
		"text-gray-800",
		"w-30px"
	);
	subtotalInput.setAttribute("name", "subtotals[]");
	subtotalInput.setAttribute("readonly", "readonly");
	subtotalInput.setAttribute("hidden", "hidden");
	// subtotalInput.setAttribute("value", "289");

	// Append elements to the third <td>
	td3Element.appendChild(subtotalSpan);
	td3Element.appendChild(subtotalInput);

	// Append third <td> to the <tr>
	trElement.appendChild(td3Element);

	tbody.appendChild(trElement);

	decreaseButton.addEventListener("click", () =>
		updateQuantity(trElement, -1)
	);
	increaseButton.addEventListener("click", () =>
		updateQuantity(trElement, 1)
	);
	// Trigger initial update
	updateQuantity(trElement, 0);
	calculateTotal();
	updateDiscount();
	toggleRibbonVisibility(elem);
	clearAllButton.removeAttribute("disabled");
	saveOrderButton.removeAttribute("disabled");
	decLeftoverBtn.removeAttribute("disabled");
	leftoverInput.removeAttribute("disabled");
	incLeftoverBtn.removeAttribute("disabled");
	addDiscountBtn.removeAttribute("disabled");
	customerCash.removeAttribute("disabled");
}

function toggleAllVisibility() {
	const ribbons = document.querySelectorAll(".ribbon");
	for (var i = 0; i < ribbons.length; i += 1) {
		ribbons[i].style.display = "none";
	}
}
function toggleRibbonVisibility(element) {
	var ribbonWrapper = element.querySelector(".ribbon");

	// Toggle ribbon display property
	ribbonWrapper.style.display =
		ribbonWrapper.style.display === "none" ? "block" : "none";
}
// Event for individual item
function updateQuantity(trElement, change) {
	const quantityInput = trElement.querySelector(".quantity");
	const priceInput = trElement.querySelector(".price");
	const subtotalSpan = trElement.querySelector(".subtotal");
	const subtotalInput = trElement.querySelector(".subtotalInput");

	let quantity = parseInt(quantityInput.value) + change;
	if (quantity < 1 || quantity > 20) {
		return; // Don't allow quantities below 1 or above 20
	}
	quantityInput.value = quantity;
	subtotalSpan.textContent = calculateSubtotal(priceInput.value, quantity);
	subtotalInput.value = priceInput.value * quantity;
	calculateTotal();
	updateDiscount();
	revalidateOrderField();
}

// Calculate subtotal
function calculateSubtotal(price, quantity) {
	return moneyFormat.to(price * quantity);
}
// Calculate total
function calculateTotal() {
	const subtotalElements = document.querySelectorAll(".subtotalInput");
	const totalDisplay = document.querySelector("#totalDisplay");
	const discountTotal = document.querySelector("#discount_total");
	const leftoverTotal = document.querySelector("#leftover_total");

	let total = parseFloat(0);

	subtotalElements.forEach((subtotalElement) => {
		const elementValue = parseFloat(
			subtotalElement.value.replace(/[^\d.]/g, "")
		);
		if (!isNaN(elementValue)) {
			total += elementValue;
		}
	});

	totalDisplay.textContent = moneyFormat.to(total); // Subtotal
	// Subtract discount from total
	const discountValue = parseFloat(discountTotal.value) || 0;
	total -= discountValue;

	// Add leftover to total
	const leftoverValue = parseFloat(leftoverTotal.value) || 0;
	total += leftoverValue;

	const change = parseInt(customerCash.value - total, 10);
	customerChange.textContent = moneyFormat.to(change);
	customerChangeInput.value = parseInt(customerCash.value - total, 10);
	grandTotalDisplay.textContent = moneyFormat.to(total);
	grandTotal.value = parseInt(total, 10);
}
// Remove individual item
function removeDialer(trElement) {
	tbody.removeChild(trElement);
	calculateTotal();
	revalidateOrderField();
}

// Remove all items
function clearAllDialers() {
	while (tbody.firstChild) {
		tbody.removeChild(tbody.firstChild);
	}
	while (discountsContent.firstChild) {
		discountsContent.removeChild(discountsContent.firstChild);
	}
	calculateTotal();
	resetAllValues();
	disableOrderValidator();
}

function resetAllValues() {
	cashSpan.textContent = moneyFormat.to(0);
	customerCash.value = "";
	customerChange.textContent = moneyFormat.to(0);
	customerChangeInput.value = 0;
	customerCash.setAttribute("disabled", true);
	saveOrderButton.setAttribute("disabled", true);
	decLeftoverBtn.setAttribute("disabled", true);
	leftoverInput.setAttribute("disabled", true);
	incLeftoverBtn.setAttribute("disabled", true);
	addDiscountBtn.setAttribute("disabled", true);
	clearAllButton.setAttribute("disabled", true);
}
// Initial Calculation of Total
calculateTotal();

addFormOrder.addEventListener("submit", (e) => {
	e.preventDefault();
	// Validate form before submit
	if (orderValidator) {
		orderValidator.validate().then(function (status) {
			if (status == "Valid") {
				Swal.fire({
					text: "Are you sure you would like to save order?",
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
						saveOrderButton.setAttribute("data-kt-indicator", "on");

						// Disable button to avoid multiple click
						saveOrderButton.disabled = true;

						// Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
						setTimeout(function () {
							// Remove loading indication
							saveOrderButton.removeAttribute(
								"data-kt-indicator"
							);

							// Enable button
							saveOrderButton.disabled = false;

							SaveOrder();
						}, 2000);
					}
				});
			}
		});
	}
});

const SaveOrder = () => {
	const item_ids = $('[name="item_ids[]"]').toArray();
	const quantities = $('[name="quantities[]"]').toArray();
	const prices = $('[name="prices[]"]').toArray();
	const subtotals = $('[name="subtotals[]"]').toArray();

	const orderItems = [];

	for (let i = 0; i < item_ids.length; i++) {
		const item_id = $(item_ids[i]).val();
		const quantity = $(quantities[i]).val();
		const price = $(prices[i]).val();
		const subtotal = $(subtotals[i]).val();

		orderItems.push({
			item_id: item_id,
			quantity: quantity,
			price: price,
			subtotal: subtotal,
		});
	}

	$.ajax({
		url: window.location.origin + "/TOM_S1/controllers/order.php", // Action
		type: "POST", // Method
		data: {
			action: "save_order",
			order_method: $('[name="order_method"]:checked').val(),
			discount: $('[name="discount_total"]').val(),
			leftover: $('[name="leftover"]').val(),
			payment_method: $('[name="payment_method"]:checked').val(),
			grand_total: $('[name="grand_total"]').val(),
			customer_cash: $('[name="customer_cash"]').val(),
			change: $('[name="change"]').val(),
			orderItems: orderItems,
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
