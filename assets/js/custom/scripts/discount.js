const discountQty = document.querySelector(".discount_qty");
const discountTotal = document.querySelector("#discount_total");
const discountDisplay = document.querySelector("#discountDisplay");

const decreaseButton = () => {
	let quantity = parseInt(discountQty.value) - 1;
	if (quantity < 1 || quantity > 20) {
		return;
	}
	discountQty.value = quantity;
	updateDiscount();
};

const increaseButton = () => {
	let quantity = parseInt(discountQty.value) + 1;
	if (quantity < 1 || quantity > 20) {
		return;
	}
	discountQty.value = quantity;
	updateDiscount();
};

// function changeItem() {
// 	var discount_price = document.getElementById("uw_select").value;
// 	discountPrice.value = discount_price;
// 	updateDiscount();
// }

// function changeVoucher() {
// 	var voucher_percent = document.getElementById("v_select").value;
// 	voucherPercent.value = voucher_percent;
// 	updateDiscount();
// }

// const updateDiscount = () => {
// 	var discount_price = document.querySelectorAll(".item_discounts").value;
// 	var voucher_percent = document.querySelectorAll("v_select").value;

// 	const discount_total = parseFloat(
// 		discount_price * (voucher_percent / 100) * parseFloat(discountQty.value)
// 	);
// 	discountTotal.value = discount_total;
// 	discountDisplay.textContent = "- " + moneyFormat.to(discount_total);
// 	calculateTotal();
// };

const discountsContent = document.getElementById("discounts_content");
const addDiscountBtn = document.getElementById("add_discount_btn");
document.addEventListener("DOMContentLoaded", () => {
	addDiscountBtn.addEventListener("click", () => {
		const discountParent = document.createElement("div");
		discountParent.classList.add(
			"d-flex",
			"justify-content-between",
			"gap-3",
			"mb-3"
		);

		// Create the first section for voucher discount
		const voucherSection = document.createElement("div");
		voucherSection.classList.add("flex-fill");
		discountParent.appendChild(voucherSection);

		const divFvRow1 = document.createElement("div");
		divFvRow1.classList.add(
			"fv-row",
			"d-flex",
			"align-items-center",
			"flex-fill"
		);
		voucherSection.appendChild(divFvRow1);

		const inputGroup1 = document.createElement("div");
		inputGroup1.classList.add(
			"input-group",
			"input-group-solid",
			"flex-nowrap"
		);
		divFvRow1.appendChild(inputGroup1);

		const overflow1 = document.createElement("div");
		overflow1.classList.add("overflow-hidden", "flex-grow-1");
		inputGroup1.appendChild(overflow1);

		// Create the select element for voucher discount
		const voucherSelect = document.createElement("select");
		voucherSelect.classList.add(
			"form-select",
			"form-select-solid",
			"slct_discount_code"
		);
		voucherSelect.setAttribute("data-control", "select2");
		voucherSelect.name = "discount_code";

		// Initialize Select2 on the voucherSelect element
		// voucherSelect.id = "v_select";
		// voucherSelect.setAttribute("onchange", "changeVoucher()");
		voucherSelect.setAttribute("data-placeholder", "Discount");
		// Set onchange attribute for voucherSelect
		voucherSelect.setAttribute("onchange", "updateDiscount()");

		const emptyVoucherOption = document.createElement("option");
		emptyVoucherOption.textContent = "";
		voucherSelect.appendChild(emptyVoucherOption);

		$.ajax({
			url: window.location.origin + "/TOM_S1/controllers/discounts.php", // Action
			type: "POST", // Method
			data: {
				action: "get_vouchers",
			},
			dataType: "JSON",
			beforeSend: function () {},
			success: function (response) {
				for (var i = 0; i < response.length; i++) {
					// Create an option element within the select for voucher discount
					const voucherOption = document.createElement("option");
					voucherOption.value = response[i].voucher_percent;
					voucherOption.textContent = response[i].voucher_code;
					voucherSelect.appendChild(voucherOption);
				}
			},
			complete: function () {},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			},
		});

		overflow1.appendChild(voucherSelect);
		$(voucherSelect).select2();
		// Add an onchange event listener
		discountParent.appendChild(voucherSection);

		// Create the second section for voucher discount
		const itemSection = document.createElement("div");
		itemSection.classList.add(
			"fv-row",
			"d-flex",
			"align-items-center",
			"flex-fill"
		);

		const inputGroup2 = document.createElement("div");
		inputGroup2.classList.add(
			"input-group",
			"input-group-solid",
			"flex-nowrap"
		);
		itemSection.appendChild(inputGroup2);

		const overflow2 = document.createElement("div");
		overflow2.classList.add("overflow-hidden", "flex-grow-1");
		inputGroup2.appendChild(overflow2);

		// Create the select element for voucher discount
		const itemSelect = document.createElement("select");
		itemSelect.classList.add(
			"form-select",
			"form-select-solid",
			"slct_item_discounts"
		);
		itemSelect.setAttribute("data-control", "select2");
		itemSelect.name = "item_discounts";
		// Add an onchange event listener
		// voucherSelect.setAttribute("onchange", "changeVoucher()");
		itemSelect.setAttribute("data-placeholder", "Item");
		itemSelect.setAttribute("onchange", "updateDiscount()");
		// Set onchange attribute for itemSelect

		// Create an option element within the select for voucher discount
		const emptyItemOption = document.createElement("option");
		emptyItemOption.textContent = "";
		itemSelect.appendChild(emptyItemOption);

		$.ajax({
			url: window.location.origin + "/TOM_S1/controllers/discounts.php", // Action
			type: "POST", // Method
			data: {
				action: "get_items",
			},
			dataType: "JSON",
			beforeSend: function () {},
			success: function (response) {
				for (var i = 0; i < response.length; i++) {
					// Create an option element within the select for voucher discount
					const itemOption = document.createElement("option");
					itemOption.value = response[i].price;
					itemOption.textContent = response[i].item_name;
					itemSelect.appendChild(itemOption);
				}
			},
			complete: function () {},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			},
		});

		overflow2.appendChild(itemSelect);
		// Add an onchange event listener
		$(itemSelect).select2();

		discountParent.appendChild(itemSection);

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

		quantityInput.setAttribute("type", "text");
		quantityInput.classList.add(
			"form-control",
			"discount_qty",
			"border-0",
			"text-center",
			"px-0",
			"fs-3",
			"fw-bold",
			"text-gray-800",
			"w-30px"
		);
		quantityInput.setAttribute("name", "discount_qty");
		quantityInput.setAttribute("readonly", "readonly");
		quantityInput.setAttribute("value", "1");

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
		// dialerDivElement.appendChild(itemIdInput);
		dialerDivElement.appendChild(quantityInput);
		// dialerDivElement.appendChild(priceInput);
		dialerDivElement.appendChild(increaseButton);

		discountParent.appendChild(dialerDivElement);

		discountsContent.appendChild(discountParent);

		decreaseButton.addEventListener("click", () =>
			updateQuantity(discountParent, -1)
		);

		increaseButton.addEventListener("click", () =>
			updateQuantity(discountParent, 1)
		);
	});

	function updateQuantity(discountParent, change) {
		const quantityInput = discountParent.querySelector(".discount_qty");

		let quantity = parseInt(quantityInput.value) + change;
		if (quantity < 1) {
			removeDialer(discountParent);
		}
		if (quantity < 1 || quantity > 20) {
			return; // Don't allow quantities below 1 or above 20
		}
		quantityInput.value = quantity;
		updateDiscount();
	}

	// Remove individual discount
	function removeDialer(discountParent) {
		discountsContent.removeChild(discountParent);
		if (discountsContent.children.length === 0) {
			addDiscountBtn.setAttribute("disabled", true);
		} else {
			addDiscountBtn.removeAttribute("disabled");
		}
		updateDiscount();
	}
});

// Calculate total
function updateDiscount() {
	var discountPriceElements = document.querySelectorAll(
		"[data-control='select2'][name='item_discounts']"
	);
	var voucherPercentElements = document.querySelectorAll(
		"[data-control='select2'][name='discount_code']"
	);
	var discountQtyElements = document.querySelectorAll(
		"[name='discount_qty']"
	);

	let totalDiscount = 0;

	discountPriceElements.forEach((discountPrice, index) => {
		const voucherPercent = voucherPercentElements[index];
		const discountQty = discountQtyElements[index];

		if (
			discountPrice &&
			voucherPercent &&
			discountQty &&
			discountPrice.value !== undefined &&
			voucherPercent.value !== undefined &&
			discountQty.value !== undefined &&
			!isNaN(discountPrice.value) &&
			!isNaN(voucherPercent.value) &&
			!isNaN(discountQty.value)
		) {
			const discountTotal =
				discountPrice.value *
				(voucherPercent.value / 100) *
				discountQty.value;
			totalDiscount += discountTotal;
		}
	});
	discountTotal.value = totalDiscount;
	discountDisplay.textContent = "- " + moneyFormat.to(totalDiscount);
	calculateTotal();
}
