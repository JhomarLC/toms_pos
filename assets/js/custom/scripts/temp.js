const tbody = document.querySelector("tbody");
const clearAllButton = document.querySelector("#clear_all");
const totalDisplay = document.querySelector("#grandtotal");

clearAllButton.addEventListener("click", clearAllDialers);

function createDialer(item_name, price) {
	var trElement = document.createElement("tr");
	var td1Element = document.createElement("td");
	var divElement = document.createElement("div");
	var spanElement = document.createElement("span");
	spanElement.textContent = item_name;
	divElement.appendChild(spanElement);
	td1Element.appendChild(divElement);
	trElement.appendChild(td1Element);

	var td2Element = document.createElement("td");
	var dialerDivElement = document.createElement("div");
	var decreaseButton = document.createElement("button");
	decreaseButton.setAttribute("type", "button");
	decreaseButton.innerHTML = "<i> - </i>";

	var quantityInput = document.createElement("input");
	quantityInput.setAttribute("type", "text");
	quantityInput.setAttribute("class", "quantity"); // Add a class for selection
	quantityInput.setAttribute("name", "quantities[]");
	quantityInput.setAttribute("readonly", "readonly");
	quantityInput.setAttribute("value", "1");

	var priceInput = document.createElement("input");
	priceInput.setAttribute("type", "text");
	priceInput.setAttribute("class", "price"); // Add a class for selection
	priceInput.setAttribute("hidden", "readonly");
	priceInput.setAttribute("value", price);

	var increaseButton = document.createElement("button");
	increaseButton.setAttribute("type", "button");
	increaseButton.innerHTML = "<i> + </i>";

	dialerDivElement.appendChild(decreaseButton);
	dialerDivElement.appendChild(quantityInput);
	dialerDivElement.appendChild(priceInput);
	dialerDivElement.appendChild(increaseButton);
	td2Element.appendChild(dialerDivElement);
	trElement.appendChild(td2Element);

	var td3Element = document.createElement("td");
	var subtotalSpan = document.createElement("span");
	subtotalSpan.setAttribute("class", "subtotal"); // Add a class for selection
	td3Element.appendChild(subtotalSpan);

	// Create an <input> element for mirroring the subtotal value
	var subtotalInput = document.createElement("input");
	subtotalInput.setAttribute("type", "text");
	subtotalInput.setAttribute("name", "subtotals[]");
	subtotalInput.setAttribute("class", "subtotalInput");
	subtotalInput.setAttribute("readonly", "readonly");

	// Append <input> to the third <td>
	td3Element.appendChild(subtotalInput);

	trElement.appendChild(td3Element);

	// Create Remove button
	var removeButton = document.createElement("button");
	removeButton.setAttribute("type", "button");
	removeButton.textContent = "Remove Dialer";
	removeButton.addEventListener("click", () => removeDialer(trElement));

	// Append Remove button to the created <tr>
	trElement.appendChild(removeButton);

	tbody.appendChild(trElement);

	decreaseButton.addEventListener("click", () =>
		updateQuantity(trElement, -1)
	);
	increaseButton.addEventListener("click", () =>
		updateQuantity(trElement, 1)
	);

	// Trigger initial update
	updateQuantity(trElement, 0);
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
}

// Money formatter
var moneyFormat = wNumb({
	mark: ".",
	thousand: ",",
	decimals: 2,
	prefix: "₱",
});

// Calculate subtotal
function calculateSubtotal(price, quantity) {
	return moneyFormat.to(price * quantity);
}
// Calculate total
function calculateTotal() {
	const subtotalElements = document.querySelectorAll(".subtotalInput");
	let total = 0;

	subtotalElements.forEach((subtotalElement) => {
		total += parseFloat(subtotalElement.value.replace(/[^\d.]/g, ""));
	});

	totalDisplay.textContent = "Total: " + moneyFormat.to(total);
}
// Remove individual item
function removeDialer(trElement) {
	tbody.removeChild(trElement);
	calculateTotal();
}

// Remove all items
function clearAllDialers() {
	while (tbody.firstChild) {
		tbody.removeChild(tbody.firstChild);
	}
	calculateTotal();
}
// Initial Calculation of Total
calculateTotal();
