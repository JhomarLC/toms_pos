const leftoverQty = document.querySelector(".leftover_qty");
const leftoverDisplay = document.querySelector("#leftoverDisplay");
const leftoverTotal = document.querySelector("#leftover_total");

const decreaseLeftOButton = () => {
	let quantity = parseInt(leftoverQty.value) - 1;
	if (quantity < 1 || quantity > 20) {
		return;
	}
	leftoverQty.value = quantity;
	ComputeLeftover();
};

const increaseLeftOButton = () => {
	let quantity = parseInt(leftoverQty.value) + 1;
	if (quantity < 1 || quantity > 20) {
		return;
	}
	leftoverQty.value = quantity;
	ComputeLeftover();
};

const ComputeLeftover = () => {
	const leftover_price = document.getElementById("leftover").value;
	const leftover_total_price = parseFloat(leftover_price * leftoverQty.value);

	leftoverTotal.value = leftover_total_price;
	leftoverDisplay.textContent = "+ " + moneyFormat.to(leftover_total_price);
	calculateTotal();
};
