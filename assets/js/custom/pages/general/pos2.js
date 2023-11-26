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

var handleQuantity = function () {
	var dialers = [].slice.call(
		form.querySelectorAll(
			'[data-kt-pos-element="item"] [data-kt-dialer="true"]'
		)
	);

	dialers.map(function (dialer) {
		var dialerObject = KTDialer.getInstance(dialer);

		dialerObject.on("kt.dialer.changed", function () {
			var quantity = parseInt(dialerObject.getValue());
			var item = dialerObject
				.getElement()
				.closest('[data-kt-pos-element="item"]');
			var value = parseInt(item.getAttribute("data-kt-pos-item-price"));
			var total = quantity * value;

			item.querySelector('[data-kt-pos-element="item-total"]').innerHTML =
				moneyFormat.to(total);

			calculateTotals();
		});
	});
};
handleQuantity();
const addOrder = () => {
	// Create a new table row element
	const newRow = document.createElement("tr");
	newRow.setAttribute("data-kt-pos-element", "item");
	newRow.setAttribute("data-kt-pos-item-price", "33");

	// Create the first table cell
	const firstCell = document.createElement("td");
	firstCell.classList.add("pe-0");
	const firstCellContent = document.createElement("div");
	firstCellContent.classList.add("d-flex", "align-items-center");
	const firstCellImage = document.createElement("img");
	firstCellImage.setAttribute("src", "assets/media/stock/food/img-2.jpg");
	firstCellImage.classList.add("w-50px", "h-50px", "rounded-3", "me-3");
	firstCellImage.setAttribute("alt", "");
	const firstCellText = document.createElement("span");
	firstCellText.classList.add(
		"fw-bold",
		"text-gray-800",
		"cursor-pointer",
		"text-hover-primary",
		"fs-6",
		"me-1"
	);
	firstCellText.textContent = "T-Bone Stake";

	firstCellContent.appendChild(firstCellImage);
	firstCellContent.appendChild(firstCellText);
	firstCell.appendChild(firstCellContent);

	// Create the second table cell with the Dialer
	const secondCell = document.createElement("td");
	secondCell.classList.add("pe-0");
	const dialerDiv = document.createElement("div");
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

	// Create the Decrease control button
	const decreaseControlButton = document.createElement("button");
	decreaseControlButton.setAttribute("type", "button");
	decreaseControlButton.classList.add(
		"btn",
		"btn-icon",
		"btn-sm",
		"btn-light",
		"btn-icon-gray-400"
	);
	decreaseControlButton.setAttribute("data-kt-dialer-control", "decrease");
	decreaseControlButton.innerHTML =
		'<i class="ki-duotone ki-minus fs-3x"></i>';

	// Create the Input control input element
	const inputControlInput = document.createElement("input");
	inputControlInput.setAttribute("type", "text");
	inputControlInput.classList.add(
		"form-control",
		"border-0",
		"text-center",
		"px-0",
		"fs-3",
		"fw-bold",
		"text-gray-800",
		"w-30px"
	);
	inputControlInput.setAttribute("data-kt-dialer-control", "input");
	inputControlInput.setAttribute("placeholder", "Amount");
	inputControlInput.setAttribute("name", "manageBudget");
	inputControlInput.setAttribute("readonly", "readonly");
	inputControlInput.setAttribute("value", "2");

	// Create the Increase control button
	const increaseControlButton = document.createElement("button");
	increaseControlButton.setAttribute("type", "button");
	increaseControlButton.classList.add(
		"btn",
		"btn-icon",
		"btn-sm",
		"btn-light",
		"btn-icon-gray-400"
	);
	increaseControlButton.setAttribute("data-kt-dialer-control", "increase");
	increaseControlButton.innerHTML =
		'<i class="ki-duotone ki-plus fs-3x"></i>';

	dialerDiv.appendChild(decreaseControlButton);
	dialerDiv.appendChild(inputControlInput);
	dialerDiv.appendChild(increaseControlButton);

	secondCell.appendChild(dialerDiv);

	// Create the third table cell
	const thirdCell = document.createElement("td");
	thirdCell.classList.add("text-end");
	const itemTotalSpan = document.createElement("span");
	itemTotalSpan.classList.add("fw-bold", "text-primary", "fs-2");
	itemTotalSpan.setAttribute("data-kt-pos-element", "item-total");
	itemTotalSpan.textContent = "₱66.00";

	thirdCell.appendChild(itemTotalSpan);

	// Append the table cells to the new table row
	newRow.appendChild(firstCell);
	newRow.appendChild(secondCell);
	newRow.appendChild(thirdCell);

	// Append the new table row to your table (e.g., by selecting the table by its ID)
	const table = document.getElementById("table-item"); // Replace 'your-table-id' with your actual table ID
	table.appendChild(newRow);

	calculateTotals();

	// Create input element for quantity
	const quantityInput = document.createElement("input");
	quantityInput.setAttribute("type", "number");
	quantityInput.classList.add("form-control", "text-center", "w-30px");
	quantityInput.setAttribute("placeholder", "Amount");
	quantityInput.value = 2;

	// Add an input event listener to update the total when quantity changes
	quantityInput.addEventListener("input", function () {
		const quantity = parseInt(this.value);
		const price = parseInt(newRow.getAttribute("data-kt-pos-item-price"));
		const total = quantity * price;

		itemTotalSpan.textContent = moneyFormat.to(total);
		calculateTotals();
	});

	// Replace the input control input element with the quantityInput
	secondCell.replaceChild(quantityInput, inputControlInput);
};

addOrder();
addOrder();
addOrder();
// Dialer container element
var dialerElement = document.querySelector("#kt_dialer_example_1");

// Create dialer object and initialize a new instance
var dialerObject = new KTDialer(dialerElement, {
	min: 1000,
	max: 50000,
	step: 1000,
	prefix: "$",
	decimals: 2,
});
