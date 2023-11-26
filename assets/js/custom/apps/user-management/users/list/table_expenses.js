"use strict";

var KTUsersList1 = (function () {
	// Define shared variables
	var table = document.getElementById("kt_table_items");
	var datatable;
	var flatpickr;
	var minDate, maxDate;

	// Private functions
	var initUserTable = function () {
		// Set date data order
		// Init datatable --- more info on datatables: https://datatables.net/manual/
		datatable = $(table).DataTable({
			info: false,
			order: [],
			pageLength: 10,
			lengthChange: false,
			columnDefs: [
				{ orderable: true, targets: 0 },
				{ orderable: false, targets: 1 },
			],
		});
	};

	// Init flatpickr --- more info :https://flatpickr.js.org/getting-started/
	var initFlatpickr = () => {
		const element = document.querySelector("#kt_ecommerce_sales_flatpickr");
		flatpickr = $(element).flatpickr({
			altInput: true,
			altFormat: "d/m/Y",
			dateFormat: "Y-m-d",
			mode: "range",
			onChange: function (selectedDates, dateStr, instance) {
				handleFlatpickr(selectedDates, dateStr, instance);
			},
		});
	};
	// Handle category filter dropdown
	var handleCategoryFilter = () => {
		const filterStatus = document.querySelector(
			'[data-kt-ecommerce-order-filter="category"]'
		);
		$(filterStatus).on("change", (e) => {
			let value = e.target.value;
			if (value === "all") {
				value = "";
			}
			datatable.column(0).search(value).draw();
		});
	};

	// Handle flatpickr --- more info: https://flatpickr.js.org/events/
	var handleFlatpickr = (selectedDates, dateStr, instance) => {
		minDate = selectedDates[0] ? new Date(selectedDates[0]) : null;
		maxDate = selectedDates[1] ? new Date(selectedDates[1]) : null;

		// Datatable date filter --- more info: https://datatables.net/extensions/datetime/examples/integration/datatables.html
		// Custom filtering function which will search data in column four between two values
		$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
			var min = minDate;
			var max = maxDate;
			var stockDate = new Date(moment($(data[0]).text(), "DD/MM/YYYY"));

			if (
				(min === null && max === null) ||
				(min === null && stockDate <= max) ||
				(min <= stockDate && max === null) ||
				(min <= stockDate && stockDate <= max)
			) {
				return true;
			}
			return false;
		});
		datatable.draw();
	};

	// Handle clear flatpickr
	var handleClearFlatpickr = () => {
		const clearButton = document.querySelector(
			"#kt_ecommerce_sales_flatpickr_clear"
		);
		clearButton.addEventListener("click", (e) => {
			flatpickr.clear();
		});
	};

	// Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
	var handleSearchDatatable = () => {
		const filterSearch = document.querySelector(
			'[data-kt-user-table-filter="search_item"]'
		);
		filterSearch.addEventListener("keyup", function (e) {
			datatable.search(e.target.value).draw();
		});
	};

	return {
		// Public functions
		init: function () {
			if (!table) {
				return;
			}
			initUserTable();
			initFlatpickr();
			handleSearchDatatable();
			// handleResetForm();
			// const filterString = "Chicken";
			// const filterValue = "\\b" + filterString + "\\b";
			// datatable.search(filterValue, true, false).draw();
			// Trigger the filter action
			// handleFilterDatatable();
			handleClearFlatpickr();
		},
	};
})();
// On document ready
KTUtil.onDOMContentLoaded(function () {
	KTUsersList1.init();
});
