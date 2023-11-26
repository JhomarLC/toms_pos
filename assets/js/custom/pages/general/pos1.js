var item_id = "id" + Math.random().toString(16).slice(2);
var form = document.querySelector("#kt_pos_form");

var moneyFormat = wNumb({
	mark: ".",
	thousand: ",",
	decimals: 2,
	prefix: "₱",
});

var calculateTotals = function () {
	var items = [].slice.call(
		form.querySelectorAll('[data-kt-pos-element="item-total"]')
	);
	var total = 0;
	var tax = 12;
	var discount = 0;
	var grantTotal = 0;

	items.map(function (item) {
		total += moneyFormat.from(item.innerHTML);
	});

	grantTotal = total;
	grantTotal -= discount;
	// grantTotal += (tax * 8) / 100;

	form.querySelector('[data-kt-pos-element="total"]').innerHTML =
		moneyFormat.to(total);
	form.querySelector('[data-kt-pos-element="grant-total"]').innerHTML =
		moneyFormat.to(grantTotal);
};

function handleQuantity() {
	var items = Array.from(
		form.querySelectorAll('[data-kt-pos-element="item"]')
	);

	items.forEach(function (item) {
		var itemID = item.getAttribute("data-kt-item-id"); // Use the 'data-kt-item-id' attribute

		var decreaseBtn = item.querySelector(
			`[data-kt-dialer-control="decrease-${itemID}"]` // Add the 'itemID' to the selector
		);
		var increaseBtn = item.querySelector(
			`[data-kt-dialer-control="increase-${itemID}"]` // Add the 'itemID' to the selector
		);
		var quantityInput = item.querySelector(
			`[data-kt-dialer-control="input-${itemID}"]` // Add the 'itemID' to the selector
		);
		var itemTotal = item.querySelector(
			`[data-kt-pos-element="item-total-${itemID}"]` // Add the 'itemID' to the selector
		);

		var priceElement = item.getAttribute("data-kt-pos-item-price");
		var price = priceElement;

		decreaseBtn.addEventListener("click", function () {
			var currentQuantity = parseInt(quantityInput.value);
			if (currentQuantity > 1) {
				currentQuantity--;
				quantityInput.value = currentQuantity;
				updateItemTotal(currentQuantity, price, itemTotal);
				updatePriceAttribute(item, currentQuantity, price);
			}
		});

		increaseBtn.addEventListener("click", function () {
			var currentQuantity = parseInt(quantityInput.value);
			if (currentQuantity < 30) {
				currentQuantity++;
				quantityInput.value = currentQuantity;
				updateItemTotal(currentQuantity, price, itemTotal);
				updatePriceAttribute(item, currentQuantity, price);
			}
		});
	});

	function updateItemTotal(quantity, price, itemTotalElement) {
		var total = quantity * price;
		itemTotalElement.textContent = moneyFormat.to(total);
	}

	function updatePriceAttribute(item, quantity, price) {
		var newPrice = (quantity * price).toFixed(2);
		item.setAttribute("data-kt-pos-item-price", newPrice);
	}
	calculateTotals();
}

handleQuantity();
var addNewItemButton = document.getElementById("addNewItemButton");

addNewItemButton.addEventListener("click", function () {
	addorders();
});

const addorders = () => {
	const tbody = document.querySelector(".tbody");

	var tableRow = document.createElement("tr");

	// Set the data attributes
	tableRow.setAttribute("data-kt-item-id", item_id);
	tableRow.setAttribute("data-kt-pos-element", "item");
	tableRow.setAttribute("data-kt-pos-item-price", "100");

	// Create the first table cell (td)
	var firstCell = document.createElement("td");
	firstCell.classList.add("pe-0");

	// Create the image and span elements within the first cell
	var img = document.createElement("img");
	img.src = "images/uploads/do-not-delete/logo.png";
	img.classList.add("w-50px", "h-50px", "rounded-3", "me-3");

	var span = document.createElement("span");
	span.classList.add(
		"fw-bold",
		"text-gray-800",
		"cursor-pointer",
		"text-hover-primary",
		"fs-6",
		"me-1"
	);
	span.textContent = "TM2";

	// Append the image and span to the first cell
	firstCell.appendChild(img);
	firstCell.appendChild(span);

	// Create the second table cell (td)
	var secondCell = document.createElement("td");
	secondCell.classList.add("pe-0");

	// Create the dialer elements within the second cell
	var dialerDiv = document.createElement("div");
	dialerDiv.classList.add(
		"position-relative",
		"d-flex",
		"align-items-center"
	);
	dialerDiv.setAttribute("data-kt-dialer", "true");
	dialerDiv.setAttribute("data-kt-dialer-min", "1");
	dialerDiv.setAttribute("data-kt-dialer-max", "10");
	dialerDiv.setAttribute("data-kt-dialer-step", "1");
	dialerDiv.setAttribute("data-kt-dialer-decimals", "0");

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
	decreaseButton.setAttribute(
		"data-kt-dialer-control",
		`decrease-${item_id}`
	);

	var decreaseIcon = document.createElement("i");
	decreaseIcon.classList.add("ki-duotone", "ki-minus", "fs-3x");

	decreaseButton.appendChild(decreaseIcon);

	// Create the input control
	var inputControl = document.createElement("input");
	inputControl.setAttribute("type", "text");
	inputControl.classList.add(
		"form-control",
		"border-0",
		"text-center",
		"px-0",
		"fs-3",
		"fw-bold",
		"text-gray-800",
		"w-30px"
	);
	inputControl.setAttribute("data-kt-dialer-control", `input-${item_id}`);
	inputControl.setAttribute("placeholder", "Amount");
	inputControl.setAttribute("name", "manageBudget");
	inputControl.setAttribute("readonly", "readonly");
	inputControl.setAttribute("value", "1");

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
	increaseButton.setAttribute(
		"data-kt-dialer-control",
		`increase-${item_id}`
	);

	var increaseIcon = document.createElement("i");
	increaseIcon.classList.add("ki-duotone", "ki-plus", "fs-3x");

	increaseButton.appendChild(increaseIcon);

	// Append the elements to the dialer div
	dialerDiv.appendChild(decreaseButton);
	dialerDiv.appendChild(inputControl);
	dialerDiv.appendChild(increaseButton);

	// Append the dialer div to the second cell
	secondCell.appendChild(dialerDiv);

	// Create the third table cell (td)
	var thirdCell = document.createElement("td");
	thirdCell.classList.add("text-end");

	// Create the total price span
	var totalSpan = document.createElement("span");
	totalSpan.classList.add("fw-bold", "text-primary", "fs-2");
	totalSpan.setAttribute("data-kt-pos-element", `item-total-${item_id}`);
	totalSpan.textContent = "₱100.00";

	// Append the total price span to the third cell
	thirdCell.appendChild(totalSpan);

	// Append the three cells to the table row
	tableRow.appendChild(firstCell);
	tableRow.appendChild(secondCell);
	tableRow.appendChild(thirdCell);

	tbody.append(tableRow);

	calculateTotals();
	handleQuantity();
};

calculateTotals();
handleQuantity();
