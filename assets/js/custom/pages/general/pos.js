"use strict";

function initializeKTPosSystem() {
	var KTPosSystem = (function () {
		var form;

		var moneyFormat = wNumb({
			mark: ".",
			thousand: ",",
			decimals: 2,
			prefix: "$",
		});

		var calculateTotals = function () {
			var items = [].slice.call(
				form.querySelectorAll('[data-kt-pos-element="item-total"]')
			);
			var total = 0;
			var tax = 12;
			var discount = 8;
			var grantTotal = 0;

			items.map(function (item) {
				total += moneyFormat.from(item.innerHTML);
			});

			grantTotal = total;
			grantTotal -= discount;
			grantTotal += (tax * 8) / 100;

			form.querySelector('[data-kt-pos-element="total"]').innerHTML =
				moneyFormat.to(total);
			form.querySelector(
				'[data-kt-pos-element="grant-total"]'
			).innerHTML = moneyFormat.to(grantTotal);
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
					var value = parseInt(
						item.getAttribute("data-kt-pos-item-price")
					);
					var total = quantity * value;

					item.querySelector(
						'[data-kt-pos-element="item-total"]'
					).innerHTML = moneyFormat.to(total);

					calculateTotals();
				});
			});
		};
		var handleNewItems = function (newItem) {
			// Create and set attributes for the dialer container
			var dialerContainer = newItem.querySelector(
				'[data-kt-dialer="true"]'
			);
			var increaseButton = newItem.querySelector(
				'[data-kt-dialer-control="increase"]'
			);
			var itemTotal = newItem.querySelector(
				'[data-kt-pos-element="item-total"]'
			);
			var itemPrice = parseInt(
				newItem.getAttribute("data-kt-pos-item-price")
			);

			var dialerObject = KTDialer.getInstance(dialerContainer);

			dialerObject.on("kt.dialer.changed", function () {
				var quantity = parseInt(dialerObject.getValue());
				var total = quantity * itemPrice;
				itemTotal.innerHTML = moneyFormat.to(total);
				calculateTotals();
			});

			increaseButton.addEventListener("click", function () {
				const input = dialerContainer.querySelector(
					'[data-kt-dialer-control="input"]'
				);
				const currentValue = parseInt(input.value);
				if (currentValue < 10) {
					input.value = (currentValue + 1).toString();
					var total = itemPrice * (currentValue + 1);
					itemTotal.innerHTML = moneyFormat.to(total);
					calculateTotals();
				}
			});
		};
		return {
			init: function () {
				form = document.querySelector("#kt_pos_form");

				handleQuantity();
			},
			calculateTotals: calculateTotals, // Add a function to calculate totals
			handleNewItems: handleNewItems,
		};
	})();

	return KTPosSystem;
}
// On document ready
document.addEventListener("DOMContentLoaded", function () {
	var addNewItemButton = document.getElementById("addNewItemButton");

	// Initialize KTPosSystem
	var posSystem = initializeKTPosSystem();
	posSystem.init();

	addNewItemButton.addEventListener("click", function () {
		const tbody = document.querySelector(".tbody");

		// Create a new row for the item
		const newRow = document.createElement("tr");
		newRow.dataset.ktPosElement = "item";
		newRow.dataset.ktPosItemPrice = "10"; // You can set the price as needed

		// Create and set attributes for the first cell (image and name)
		const firstCell = document.createElement("td");
		firstCell.classList.add("pe-0");

		const divNamePic = document.createElement("div");
		divNamePic.classList.add("d-plex", "align-items-center");

		// Create and set attributes for the image
		const itemImage = document.createElement("img");
		itemImage.src = "assets/media/stock/food/img-2.jpg";
		itemImage.classList.add("w-50px", "h-50px", "rounded-3", "me-3");
		itemImage.alt = "";
		divNamePic.appendChild(itemImage);

		// Create and set attributes for the item name
		const itemName = document.createElement("span");
		itemName.classList.add(
			"fw-bold",
			"text-gray-800",
			"cursor-pointer",
			"text-hover-primary",
			"fs-6",
			"me-1"
		);
		itemName.textContent = "New Item";
		divNamePic.appendChild(itemName);
		firstCell.append(divNamePic);

		newRow.appendChild(firstCell);
		// Create and set attributes for the second cell (quantity adjustment dialer)
		const secondCell = document.createElement("td");
		secondCell.classList.add("pe-0");

		// Create and set attributes for the dialer container
		const dialerContainer = document.createElement("div");
		dialerContainer.classList.add(
			"position-relative",
			"d-flex",
			"align-items-center"
		);
		dialerContainer.dataset.ktDialer = "true";
		dialerContainer.dataset.ktDialerMin = "1";
		dialerContainer.dataset.ktDialerMax = "10";
		dialerContainer.dataset.ktDialerStep = "1";
		dialerContainer.dataset.ktDialerDecimals = "0";

		// Create and set attributes for the decrease control
		const decreaseButton = document.createElement("button");
		decreaseButton.type = "button";
		decreaseButton.classList.add(
			"btn",
			"btn-icon",
			"btn-sm",
			"btn-light",
			"btn-icon-gray-400"
		);
		decreaseButton.dataset.ktDialerControl = "decrease";
		const decreaseIcon = document.createElement("i");
		decreaseIcon.classList.add("ki-duotone", "ki-minus", "fs-3x");
		decreaseButton.appendChild(decreaseIcon);
		dialerContainer.appendChild(decreaseButton);

		decreaseButton.addEventListener("click", function () {
			const currentValue = parseInt(inputControl.value);
			if (currentValue > 1) {
				inputControl.value = (currentValue - 1).toString();
				const itemTotal = newRow.querySelector(
					'[data-kt-pos-element="item-total"]'
				);
				const itemPrice = parseInt(newRow.dataset.ktPosItemPrice);
				itemTotal.innerHTML = moneyFormat.to(
					itemPrice * (currentValue - 1)
				);
				posSystem.calculateTotals();
			}
		});

		// Create and set attributes for the input control
		const inputControl = document.createElement("input");
		inputControl.type = "text";
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

		inputControl.dataset.ktDialerControl = "input";
		inputControl.placeholder = "Amount";
		inputControl.setAttribute("name", "manageBudget");
		inputControl.readOnly = true;
		inputControl.value = "1"; // You can set the initial quantity as needed
		dialerContainer.appendChild(inputControl);

		// Create and set attributes for the increase control
		const increaseButton = document.createElement("button");
		increaseButton.type = "button";
		increaseButton.classList.add(
			"btn",
			"btn-icon",
			"btn-sm",
			"btn-light",
			"btn-icon-gray-400"
		);

		increaseButton.dataset.ktDialerControl = "increase";
		const increaseIcon = document.createElement("i");
		increaseIcon.classList.add("ki-duotone", "ki-plus", "fs-3x");
		increaseButton.appendChild(increaseIcon);
		dialerContainer.appendChild(increaseButton);

		increaseButton.addEventListener("click", function () {
			const currentValue = parseInt(inputControl.value);
			if (currentValue < 10) {
				inputControl.value = (currentValue + 1).toString();
				const itemTotal = newRow.querySelector(
					'[data-kt-pos-element="item-total"]'
				);
				const itemPrice = parseInt(newRow.dataset.ktPosItemPrice);
				itemTotal.innerHTML = moneyFormat.to(
					itemPrice * (currentValue + 1)
				);
				posSystem.calculateTotals();
			}
		});

		secondCell.appendChild(dialerContainer);
		newRow.appendChild(secondCell);

		// Create and set attributes for the third cell (total price)
		const thirdCell = document.createElement("td");
		thirdCell.classList.add("text-end");

		// Create and set attributes for the total price
		const totalItemPrice = document.createElement("span");
		totalItemPrice.classList.add("fw-bold", "text-primary", "fs-2");
		totalItemPrice.dataset.ktPosElement = "item-total";
		totalItemPrice.textContent = "$10.00"; // You can set the total price as needed
		thirdCell.appendChild(totalItemPrice);

		newRow.appendChild(thirdCell);

		// Append the new row to the tbody
		tbody.appendChild(newRow);

		// Call handleNewItems to ensure the new item's dialer is functional
		posSystem.handleNewItems(newRow);
	});
});
// // Add a new item and reinitialize KTPosSystem
// var addItemButton = document.getElementById("addItemButton");
// addItemButton.addEventListener("click", function () {
// 	// Get a reference to the tbody where items will be added
// 	const tbody = document.querySelector("tbody");
// 	// Create a new row for the item
// 	const newRow = document.createElement("tr");
// 	newRow.setAttribute("data-kt-pos-element", "item");
// 	newRow.setAttribute("data-kt-pos-item-price", "33"); // You can set the price as needed

// 	// Create and set attributes for the first cell (image and name)
// 	const firstCell = document.createElement("td");
// 	firstCell.classList.add("pe-0");

// 	// Create and set attributes for the image
// 	const itemImage = document.createElement("img");
// 	itemImage.src = "assets/media/stock/food/img-2.jpg";
// 	itemImage.classList.add("w-50px", "h-50px", "rounded-3", "me-3");
// 	itemImage.alt = "";
// 	firstCell.appendChild(itemImage);

// 	// Create and set attributes for the item name
// 	const itemName = document.createElement("span");
// 	itemName.classList.add(
// 		"fw-bold",
// 		"text-gray-800",
// 		"cursor-pointer",
// 		"text-hover-primary",
// 		"fs-6",
// 		"me-1"
// 	);
// 	itemName.textContent = "New Item";
// 	firstCell.appendChild(itemName);

// 	newRow.appendChild(firstCell);

// 	// Create and set attributes for the second cell (quantity adjustment dialer)
// 	const secondCell = document.createElement("td");
// 	secondCell.classList.add("pe-0");

// 	// Create and set attributes for the dialer container
// 	const dialerContainer = document.createElement("div");
// 	dialerContainer.classList.add(
// 		"position-relative",
// 		"d-flex",
// 		"align-items-center"
// 	);
// 	dialerContainer.setAttribute("data-kt-dialer", "true");
// 	dialerContainer.setAttribute("data-kt-dialer-min", "1");
// 	dialerContainer.setAttribute("data-kt-dialer-max", "10");
// 	dialerContainer.setAttribute("data-kt-dialer-step", "1");
// 	dialerContainer.setAttribute("data-kt-dialer-decimals", "0");

// 	// Create and set attributes for the decrease control
// 	const decreaseButton = document.createElement("button");
// 	decreaseButton.type = "button";
// 	decreaseButton.classList.add(
// 		"btn",
// 		"btn-icon",
// 		"btn-sm",
// 		"btn-light",
// 		"btn-icon-gray-400"
// 	);
// 	decreaseButton.setAttribute("data-kt-dialer-control", "decrease");
// 	const decreaseIcon = document.createElement("i");
// 	decreaseIcon.classList.add("ki-duotone", "ki-minus", "fs-3x");
// 	decreaseButton.appendChild(decreaseIcon);
// 	dialerContainer.appendChild(decreaseButton);

// 	// Create and set attributes for the input control
// 	const inputControl = document.createElement("input");
// 	inputControl.type = "text";
// 	inputControl.classList.add(
// 		"form-control",
// 		"border-0",
// 		"text-center",
// 		"px-0",
// 		"fs-3",
// 		"fw-bold",
// 		"text-gray-800",
// 		"w-30px"
// 	);
// 	inputControl.setAttribute("data-kt-dialer-control", "input");
// 	inputControl.placeholder = "Amount";
// 	inputControl.setAttribute("name", "manageBudget");
// 	inputControl.readOnly = true;
// 	inputControl.value = "2"; // You can set the initial quantity as needed
// 	dialerContainer.appendChild(inputControl);

// 	// Create and set attributes for the increase control
// 	const increaseButton = document.createElement("button");
// 	increaseButton.type = "button";
// 	increaseButton.classList.add(
// 		"btn",
// 		"btn-icon",
// 		"btn-sm",
// 		"btn-light",
// 		"btn-icon-gray-400"
// 	);
// 	increaseButton.setAttribute("data-kt-dialer-control", "increase");
// 	const increaseIcon = document.createElement("i");
// 	increaseIcon.classList.add("ki-duotone", "ki-plus", "fs-3x");
// 	increaseButton.appendChild(increaseIcon);
// 	dialerContainer.appendChild(increaseButton);

// 	secondCell.appendChild(dialerContainer);
// 	newRow.appendChild(secondCell);

// 	// Create and set attributes for the third cell (total price)
// 	const thirdCell = document.createElement("td");
// 	thirdCell.classList.add("text-end");

// 	// Create and set attributes for the total price
// 	const totalItemPrice = document.createElement("span");
// 	totalItemPrice.classList.add("fw-bold", "text-primary", "fs-2");
// 	totalItemPrice.setAttribute("data-kt-pos-element", "item-total");
// 	totalItemPrice.textContent = "$66.00"; // You can set the total price as needed
// 	thirdCell.appendChild(totalItemPrice);

// 	newRow.appendChild(thirdCell);

// 	// Append the new row to the tbody
// 	tbody.appendChild(newRow);
// });
