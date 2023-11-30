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

	// Handle role filter dropdown
	var handleRoleFilter = () => {
		const filterStatus = document.querySelector(
			'[data-kt-ecommerce-order-filter="role"]'
		);
		$(filterStatus).on("change", (e) => {
			let value = e.target.value;
			if (value === "All") {
				value = "";
			}
			datatable.column(0).search(value).draw();
		});
	};

	// Handle role filter dropdown
	var handleCategoryFilter = () => {
		const filterStatus = document.querySelector(
			'[data-kt-ecommerce-order-filter="category"]'
		);
		$(filterStatus).on("change", (e) => {
			let value = e.target.value;
			if (value === "All") {
				value = "";
			}
			datatable.column(2).search(value).draw();
		});
	};

	// Init flatpickr --- more info :https://flatpickr.js.org/getting-started/
	var initFlatpickr = () => {
		const element = document.querySelector("#kt_ecommerce_sales_flatpickr");
		flatpickr = $(element).flatpickr({
			altInput: true,
			altFormat: "Y/m/d",
			dateFormat: "Y-m-d",
			mode: "range",
			onChange: function (selectedDates, dateStr, instance) {
				handleFlatpickr(selectedDates, dateStr, instance);
			},
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
			var activityDate = new Date(
				moment($(data[4]).text(), "dddd DD MMMM, YYYY")
			);

			if (
				(min === null && max === null) ||
				(min === null && activityDate <= max) ||
				(min <= activityDate && max === null) ||
				(min <= activityDate && activityDate <= max)
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

	// Filter Datatable
	var handleFilterDatatable = () => {
		// Select filter options
		const filterForm = document.querySelector(
			'[data-kt-user-table-filter="form"]'
		);
		const filterButton = filterForm.querySelector(
			'[data-kt-user-table-filter="filter"]'
		);
		const selectOptions = filterForm.querySelectorAll("select");

		// Filter datatable on submit
		filterButton.addEventListener("click", function () {
			var filterString = "";

			// Get filter values
			selectOptions.forEach((item, index) => {
				console.log(item, index);
				if (item.value && item.value !== "") {
					if (index !== 0) {
						filterString += " ";
					}
					// Build filter value options
					filterString += item.value;
				}
			});

			// Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
			const filterValue = "\\b" + filterString + "\\b";
			datatable.search(filterValue, true, false).draw();
		});
	};

	// Reset Filter
	var handleResetForm = () => {
		// Select reset button
		const resetButton = document.querySelector(
			'[data-kt-user-table-filter="reset"]'
		);

		// Reset datatable
		resetButton.addEventListener("click", function () {
			// Select filter options
			const filterForm = document.querySelector(
				'[data-kt-user-table-filter="form"]'
			);
			const selectOptions = filterForm.querySelectorAll("select");

			// Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items
			selectOptions.forEach((select) => {
				$(select).val("").trigger("change");
			});

			// Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
			datatable.search("").draw();
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
			handleCategoryFilter();
			handleRoleFilter();
			handleClearFlatpickr();
		},
	};
})();
// On document ready
KTUtil.onDOMContentLoaded(function () {
	KTUsersList1.init();
});
