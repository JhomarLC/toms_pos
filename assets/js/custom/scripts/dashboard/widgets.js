"use strict";

// Money formatter
var moneyFormat = wNumb({
	mark: ".",
	thousand: ",",
	decimals: 2,
	prefix: "",
});
// Class definition
var KTChartsWidget3 = (function () {
	var chart = {
		self: null,
		rendered: false,
	};

	// Private methods
	var initChart = function (chart, valuee) {
		var element = document.getElementById("kt_charts_widget_3");

		if (!element) {
			return;
		}

		var height = parseInt(KTUtil.css(element, "height"));
		var labelColor = KTUtil.getCssVariableValue("--bs-gray-500");
		var borderColor = KTUtil.getCssVariableValue(
			"--bs-border-dashed-color"
		);
		var baseColor = KTUtil.getCssVariableValue("--bs-success");
		var lightColor = KTUtil.getCssVariableValue("--bs-success");

		var totalSales = document.querySelector("#total_sales_chart");
		var salesTitle = document.querySelector("#sales_title");
		if (valuee === "Weekly") {
			$.ajax({
				url:
					window.location.origin +
					"/TOM_S1/controllers/dashboard.php", // Action
				type: "POST", // Method
				data: {
					action: "get_weekly_sales",
				},
				dataType: "JSON",
				beforeSend: function () {},
				success: function (response) {
					var dataSales = response.sales;
					var dataDay = response.days;
					let maxValue = Math.max(...dataSales);

					let total_sales_D = 0;
					dataSales.forEach((sales) => {
						total_sales_D += sales;
					});
					salesTitle.textContent = "Weekly Sales";
					totalSales.textContent = moneyFormat.to(total_sales_D);

					var options = {
						series: [
							{
								name: "Sales",
								data: dataSales,
							},
						],
						chart: {
							fontFamily: "inherit",
							type: "area",
							height: height,
							toolbar: {
								show: false,
							},
						},
						plotOptions: {},
						legend: {
							show: false,
						},
						dataLabels: {
							enabled: false,
						},
						fill: {
							type: "gradient",
							gradient: {
								shadeIntensity: 1,
								opacityFrom: 0.4,
								opacityTo: 0,
								stops: [0, 80, 100],
							},
						},
						stroke: {
							curve: "smooth",
							show: true,
							width: 3,
							colors: [baseColor],
						},
						xaxis: {
							categories: dataDay,
							axisBorder: {
								show: false,
							},
							axisTicks: {
								show: false,
							},
							tickAmount: 6,
							labels: {
								rotate: 0,
								rotateAlways: true,
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
							},
							crosshairs: {
								position: "front",
								stroke: {
									color: baseColor,
									width: 1,
									dashArray: 3,
								},
							},
							tooltip: {
								enabled: true,
								formatter: undefined,
								offsetY: 0,
								style: {
									fontSize: "12px",
								},
							},
						},
						yaxis: {
							tickAmount: 4,
							max: maxValue,
							min: 0,
							labels: {
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
								formatter: function (val) {
									return "₱" + val;
								},
							},
						},
						states: {
							normal: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							hover: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							active: {
								allowMultipleDataPointsSelection: false,
								filter: {
									type: "none",
									value: 0,
								},
							},
						},
						tooltip: {
							style: {
								fontSize: "12px",
							},
							y: {
								formatter: function (val) {
									return "₱" + val;
								},
							},
						},
						colors: [lightColor],
						grid: {
							borderColor: borderColor,
							strokeDashArray: 4,
							yaxis: {
								lines: {
									show: true,
								},
							},
						},
						markers: {
							strokeColor: baseColor,
							strokeWidth: 3,
						},
					};

					chart.self = new ApexCharts(element, options);

					// Set timeout to properly get the parent elements width
					setTimeout(function () {
						chart.self.render();
						chart.rendered = true;
					}, 200);
				},
				complete: function () {},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				},
			});
		} else if (valuee === "Monthly") {
			$.ajax({
				url:
					window.location.origin +
					"/TOM_S1/controllers/dashboard.php", // Action
				type: "POST", // Method
				data: {
					action: "get_monthly_sales",
				},
				dataType: "JSON",
				beforeSend: function () {},
				success: function (response) {
					var dataSales = response.sales;
					var dataDay = response.days;
					// calculate sum using forEach() method
					let total_sales_D = 0;
					dataSales.forEach((sales) => {
						total_sales_D += sales;
					});

					salesTitle.textContent = "Monthly Sales";
					totalSales.textContent = moneyFormat.to(total_sales_D);
					let maxValue = Math.max(...dataSales);

					var options = {
						series: [
							{
								name: "Sales",
								data: dataSales,
							},
						],
						chart: {
							fontFamily: "inherit",
							type: "area",
							height: height,
							toolbar: {
								show: false,
							},
						},
						plotOptions: {},
						legend: {
							show: false,
						},
						dataLabels: {
							enabled: false,
						},
						fill: {
							type: "gradient",
							gradient: {
								shadeIntensity: 1,
								opacityFrom: 0.4,
								opacityTo: 0,
								stops: [0, 80, 100],
							},
						},
						stroke: {
							curve: "smooth",
							show: true,
							width: 3,
							colors: [baseColor],
						},
						xaxis: {
							categories: dataDay,
							axisBorder: {
								show: false,
							},
							axisTicks: {
								show: false,
							},
							tickAmount: 6,
							labels: {
								rotate: 0,
								rotateAlways: true,
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
							},
							crosshairs: {
								position: "front",
								stroke: {
									color: baseColor,
									width: 1,
									dashArray: 3,
								},
							},
							tooltip: {
								enabled: true,
								formatter: undefined,
								offsetY: 0,
								style: {
									fontSize: "12px",
								},
							},
						},
						yaxis: {
							tickAmount: 4,
							max: maxValue,
							min: 0,
							labels: {
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
								formatter: function (val) {
									return "₱" + val;
								},
							},
						},
						states: {
							normal: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							hover: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							active: {
								allowMultipleDataPointsSelection: false,
								filter: {
									type: "none",
									value: 0,
								},
							},
						},
						tooltip: {
							style: {
								fontSize: "12px",
							},
							y: {
								formatter: function (val) {
									return "₱" + val;
								},
							},
						},
						colors: [lightColor],
						grid: {
							borderColor: borderColor,
							strokeDashArray: 4,
							yaxis: {
								lines: {
									show: true,
								},
							},
						},
						markers: {
							strokeColor: baseColor,
							strokeWidth: 3,
						},
					};

					chart.self = new ApexCharts(element, options);

					// Set timeout to properly get the parent elements width
					setTimeout(function () {
						chart.self.render();
						chart.rendered = true;
					}, 200);
				},
				complete: function () {},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				},
			});
		} else if (valuee === "Yearly") {
			$.ajax({
				url:
					window.location.origin +
					"/TOM_S1/controllers/dashboard.php", // Action
				type: "POST", // Method
				data: {
					action: "get_yearly_sales",
				},
				dataType: "JSON",
				beforeSend: function () {},
				success: function (response) {
					var dataSales = response.sales;
					var dataDay = response.days;
					// calculate sum using forEach() method
					let total_sales_D = 0;
					dataSales.forEach((sales) => {
						total_sales_D += sales;
					});

					salesTitle.textContent = "Yearly Sales";
					totalSales.textContent = moneyFormat.to(total_sales_D);
					let maxValue = Math.max(...dataSales);

					var options = {
						series: [
							{
								name: "Sales",
								data: dataSales,
							},
						],
						chart: {
							fontFamily: "inherit",
							type: "area",
							height: height,
							toolbar: {
								show: false,
							},
						},
						plotOptions: {},
						legend: {
							show: false,
						},
						dataLabels: {
							enabled: false,
						},
						fill: {
							type: "gradient",
							gradient: {
								shadeIntensity: 1,
								opacityFrom: 0.4,
								opacityTo: 0,
								stops: [0, 80, 100],
							},
						},
						stroke: {
							curve: "smooth",
							show: true,
							width: 3,
							colors: [baseColor],
						},
						xaxis: {
							categories: dataDay,
							axisBorder: {
								show: false,
							},
							axisTicks: {
								show: false,
							},
							tickAmount: 6,
							labels: {
								rotate: 0,
								rotateAlways: true,
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
							},
							crosshairs: {
								position: "front",
								stroke: {
									color: baseColor,
									width: 1,
									dashArray: 3,
								},
							},
							tooltip: {
								enabled: true,
								formatter: undefined,
								offsetY: 0,
								style: {
									fontSize: "12px",
								},
							},
						},
						yaxis: {
							tickAmount: 4,
							max: maxValue,
							min: 0,
							labels: {
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
								formatter: function (val) {
									return "₱" + val;
								},
							},
						},
						states: {
							normal: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							hover: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							active: {
								allowMultipleDataPointsSelection: false,
								filter: {
									type: "none",
									value: 0,
								},
							},
						},
						tooltip: {
							style: {
								fontSize: "12px",
							},
							y: {
								formatter: function (val) {
									return "₱" + val;
								},
							},
						},
						colors: [lightColor],
						grid: {
							borderColor: borderColor,
							strokeDashArray: 4,
							yaxis: {
								lines: {
									show: true,
								},
							},
						},
						markers: {
							strokeColor: baseColor,
							strokeWidth: 3,
						},
					};

					chart.self = new ApexCharts(element, options);

					// Set timeout to properly get the parent elements width
					setTimeout(function () {
						chart.self.render();
						chart.rendered = true;
					}, 200);
				},
				complete: function () {},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				},
			});
		}
	};

	// Add a new function to destroy the chart
	var destroyChart = function () {
		if (chart.rendered && chart.self) {
			chart.self.destroy();
			chart.rendered = false;
		}
	};
	// Public methods
	return {
		init: function (valuee) {
			initChart(chart, valuee);
			// Update chart on theme mode change
			KTThemeMode.on("kt.thememode.change", function () {
				if (chart.rendered) {
					chart.self.destroy();
				}

				initChart(chart, valuee);
			});
		},
		destroy: function () {
			destroyChart(); // Destroy the chart externally if needed
		},
	};
})();

// Class definition
var KTChartsWidget4 = (function () {
	var chart = {
		self: null,
		rendered: false,
	};

	// Private methods
	var initChart = function (chart, valuee, category) {
		var element = document.getElementById("kt_charts_widget_4");

		if (!element) {
			return;
		}
		var height = parseInt(KTUtil.css(element, "height"));
		var labelColor = KTUtil.getCssVariableValue("--bs-gray-500");
		var borderColor = KTUtil.getCssVariableValue(
			"--bs-border-dashed-color"
		);
		var baseColor = KTUtil.getCssVariableValue("--bs-primary");
		var lightColor = KTUtil.getCssVariableValue("--bs-primary");

		var totalSales = document.querySelector("#total_sales_chart_4");
		var salesTitle = document.querySelector("#sales_title_4");
		var categoryExpense = document.querySelector("#category_text");
		if (valuee === "Weekly") {
			$.ajax({
				url:
					window.location.origin +
					"/TOM_S1/controllers/dashboard.php", // Action
				type: "POST", // Method
				data: {
					action: "get_weekly_sales_chicken",
					category: category,
				},
				dataType: "JSON",
				beforeSend: function () {},
				success: function (response) {
					var dataSales = response.sales;
					var dataDay = response.days;
					let maxValue = Math.max(...dataSales);

					let total_sales_D = 0;
					dataSales.forEach((sales) => {
						total_sales_D += sales;
					});
					salesTitle.textContent = "Weekly Expenses";
					categoryExpense.textContent = category;
					totalSales.textContent = moneyFormat.to(total_sales_D);

					var options = {
						series: [
							{
								name: "Expense",
								data: dataSales,
							},
						],
						chart: {
							fontFamily: "inherit",
							type: "area",
							height: height,
							toolbar: {
								show: false,
							},
						},
						plotOptions: {},
						legend: {
							show: false,
						},
						dataLabels: {
							enabled: false,
						},
						fill: {
							type: "gradient",
							gradient: {
								shadeIntensity: 1,
								opacityFrom: 0.4,
								opacityTo: 0,
								stops: [0, 80, 100],
							},
						},
						stroke: {
							curve: "smooth",
							show: true,
							width: 3,
							colors: [baseColor],
						},
						xaxis: {
							categories: dataDay,
							axisBorder: {
								show: false,
							},
							axisTicks: {
								show: false,
							},
							tickAmount: 6,
							labels: {
								rotate: 0,
								rotateAlways: true,
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
							},
							crosshairs: {
								position: "front",
								stroke: {
									color: baseColor,
									width: 1,
									dashArray: 3,
								},
							},
							tooltip: {
								enabled: true,
								formatter: undefined,
								offsetY: 0,
								style: {
									fontSize: "12px",
								},
							},
						},
						yaxis: {
							tickAmount: 4,
							max: maxValue,
							min: 0,
							labels: {
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
								formatter: function (val) {
									return "₱" + val;
								},
							},
						},
						states: {
							normal: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							hover: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							active: {
								allowMultipleDataPointsSelection: false,
								filter: {
									type: "none",
									value: 0,
								},
							},
						},
						tooltip: {
							style: {
								fontSize: "12px",
							},
							y: {
								formatter: function (val) {
									return "₱" + val;
								},
							},
						},
						colors: [lightColor],
						grid: {
							borderColor: borderColor,
							strokeDashArray: 4,
							yaxis: {
								lines: {
									show: true,
								},
							},
						},
						markers: {
							strokeColor: baseColor,
							strokeWidth: 3,
						},
					};

					chart.self = new ApexCharts(element, options);

					// Set timeout to properly get the parent elements width
					setTimeout(function () {
						chart.self.render();
						chart.rendered = true;
					}, 200);
				},
				complete: function () {},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				},
			});
		} else if (valuee === "Monthly") {
			$.ajax({
				url:
					window.location.origin +
					"/TOM_S1/controllers/dashboard.php", // Action
				type: "POST", // Method
				data: {
					action: "get_monthly_sales_chicken",
					category: category,
				},
				dataType: "JSON",
				beforeSend: function () {},
				success: function (response) {
					var dataSales = response.sales;
					var dataDay = response.days;
					// calculate sum using forEach() method
					let total_sales_D = 0;
					dataSales.forEach((sales) => {
						total_sales_D += sales;
					});

					salesTitle.textContent = "Monthly Expenses";
					categoryExpense.textContent = category;
					totalSales.textContent = moneyFormat.to(total_sales_D);
					let maxValue = Math.max(...dataSales);

					var options = {
						series: [
							{
								name: "Sales",
								data: dataSales,
							},
						],
						chart: {
							fontFamily: "inherit",
							type: "area",
							height: height,
							toolbar: {
								show: false,
							},
						},
						plotOptions: {},
						legend: {
							show: false,
						},
						dataLabels: {
							enabled: false,
						},
						fill: {
							type: "gradient",
							gradient: {
								shadeIntensity: 1,
								opacityFrom: 0.4,
								opacityTo: 0,
								stops: [0, 80, 100],
							},
						},
						stroke: {
							curve: "smooth",
							show: true,
							width: 3,
							colors: [baseColor],
						},
						xaxis: {
							categories: dataDay,
							axisBorder: {
								show: false,
							},
							axisTicks: {
								show: false,
							},
							tickAmount: 6,
							labels: {
								rotate: 0,
								rotateAlways: true,
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
							},
							crosshairs: {
								position: "front",
								stroke: {
									color: baseColor,
									width: 1,
									dashArray: 3,
								},
							},
							tooltip: {
								enabled: true,
								formatter: undefined,
								offsetY: 0,
								style: {
									fontSize: "12px",
								},
							},
						},
						yaxis: {
							tickAmount: 4,
							max: maxValue,
							min: 0,
							labels: {
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
								formatter: function (val) {
									return "₱" + val;
								},
							},
						},
						states: {
							normal: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							hover: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							active: {
								allowMultipleDataPointsSelection: false,
								filter: {
									type: "none",
									value: 0,
								},
							},
						},
						tooltip: {
							style: {
								fontSize: "12px",
							},
							y: {
								formatter: function (val) {
									return "₱" + val;
								},
							},
						},
						colors: [lightColor],
						grid: {
							borderColor: borderColor,
							strokeDashArray: 4,
							yaxis: {
								lines: {
									show: true,
								},
							},
						},
						markers: {
							strokeColor: baseColor,
							strokeWidth: 3,
						},
					};

					chart.self = new ApexCharts(element, options);

					// Set timeout to properly get the parent elements width
					setTimeout(function () {
						chart.self.render();
						chart.rendered = true;
					}, 200);
				},
				complete: function () {},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				},
			});
		} else if (valuee === "Yearly") {
			$.ajax({
				url:
					window.location.origin +
					"/TOM_S1/controllers/dashboard.php", // Action
				type: "POST", // Method
				data: {
					action: "get_yearly_sales_chicken",
					category: category,
				},
				dataType: "JSON",
				beforeSend: function () {},
				success: function (response) {
					var dataSales = response.sales;
					var dataDay = response.days;
					// calculate sum using forEach() method
					let total_sales_D = 0;
					dataSales.forEach((sales) => {
						total_sales_D += sales;
					});

					salesTitle.textContent = "Yearly Expenses";
					categoryExpense.textContent = category;
					totalSales.textContent = moneyFormat.to(total_sales_D);
					let maxValue = Math.max(...dataSales);

					var options = {
						series: [
							{
								name: "Sales",
								data: dataSales,
							},
						],
						chart: {
							fontFamily: "inherit",
							type: "area",
							height: height,
							toolbar: {
								show: false,
							},
						},
						plotOptions: {},
						legend: {
							show: false,
						},
						dataLabels: {
							enabled: false,
						},
						fill: {
							type: "gradient",
							gradient: {
								shadeIntensity: 1,
								opacityFrom: 0.4,
								opacityTo: 0,
								stops: [0, 80, 100],
							},
						},
						stroke: {
							curve: "smooth",
							show: true,
							width: 3,
							colors: [baseColor],
						},
						xaxis: {
							categories: dataDay,
							axisBorder: {
								show: false,
							},
							axisTicks: {
								show: false,
							},
							tickAmount: 6,
							labels: {
								rotate: 0,
								rotateAlways: true,
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
							},
							crosshairs: {
								position: "front",
								stroke: {
									color: baseColor,
									width: 1,
									dashArray: 3,
								},
							},
							tooltip: {
								enabled: true,
								formatter: undefined,
								offsetY: 0,
								style: {
									fontSize: "12px",
								},
							},
						},
						yaxis: {
							tickAmount: 4,
							max: maxValue,
							min: 0,
							labels: {
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
								formatter: function (val) {
									return "₱" + val;
								},
							},
						},
						states: {
							normal: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							hover: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							active: {
								allowMultipleDataPointsSelection: false,
								filter: {
									type: "none",
									value: 0,
								},
							},
						},
						tooltip: {
							style: {
								fontSize: "12px",
							},
							y: {
								formatter: function (val) {
									return "₱" + val;
								},
							},
						},
						colors: [lightColor],
						grid: {
							borderColor: borderColor,
							strokeDashArray: 4,
							yaxis: {
								lines: {
									show: true,
								},
							},
						},
						markers: {
							strokeColor: baseColor,
							strokeWidth: 3,
						},
					};

					chart.self = new ApexCharts(element, options);

					// Set timeout to properly get the parent elements width
					setTimeout(function () {
						chart.self.render();
						chart.rendered = true;
					}, 200);
				},
				complete: function () {},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				},
			});
		}
	};

	// Add a new function to destroy the chart
	var destroyChart = function () {
		if (chart.rendered && chart.self) {
			chart.self.destroy();
			chart.rendered = false;
		}
	};
	// Public methods
	return {
		init: function (valuee, category) {
			initChart(chart, valuee, category);
			// Update chart on theme mode change
			KTThemeMode.on("kt.thememode.change", function () {
				if (chart.rendered) {
					chart.self.destroy();
				}

				initChart(chart, valuee, category);
			});
		},
		destroy: function () {
			destroyChart(); // Destroy the chart externally if needed
		},
	};
})();

// Class definition
var KTChartsWidget5 = (function () {
	var chart = {
		self: null,
		rendered: false,
	};

	// Private methods
	var initChart = function (chart, valuee, category, text) {
		var element = document.getElementById("kt_charts_widget_5");

		if (!element) {
			return;
		}
		var height = parseInt(KTUtil.css(element, "height"));
		var labelColor = KTUtil.getCssVariableValue("--bs-gray-500");
		var borderColor = KTUtil.getCssVariableValue(
			"--bs-border-dashed-color"
		);
		var baseColor = KTUtil.getCssVariableValue("--bs-warning");
		var lightColor = KTUtil.getCssVariableValue("--bs-warning");

		var totalSales = document.querySelector("#total_sales_chart_5");
		var salesTitle = document.querySelector("#sales_title_5");
		var categoryExpense = document.querySelector("#orders_text");
		if (valuee === "Weekly") {
			$.ajax({
				url:
					window.location.origin +
					"/TOM_S1/controllers/dashboard.php", // Action
				type: "POST", // Method
				data: {
					action: "get_weekly_orders",
					category: category,
				},
				dataType: "JSON",
				beforeSend: function () {},
				success: function (response) {
					var dataSales = response.sales;
					var dataDay = response.days;
					let maxValue = Math.max(...dataSales);

					let total_sales_D = 0;
					dataSales.forEach((sales) => {
						total_sales_D += sales;
					});
					salesTitle.textContent = "Weekly Orders";
					categoryExpense.textContent = text;
					totalSales.textContent = total_sales_D;

					var options = {
						series: [
							{
								name: "Orders",
								data: dataSales,
							},
						],
						chart: {
							fontFamily: "inherit",
							type: "area",
							height: height,
							toolbar: {
								show: false,
							},
						},
						plotOptions: {},
						legend: {
							show: false,
						},
						dataLabels: {
							enabled: false,
						},
						fill: {
							type: "gradient",
							gradient: {
								shadeIntensity: 1,
								opacityFrom: 0.4,
								opacityTo: 0,
								stops: [0, 80, 100],
							},
						},
						stroke: {
							curve: "smooth",
							show: true,
							width: 3,
							colors: [baseColor],
						},
						xaxis: {
							categories: dataDay,
							axisBorder: {
								show: false,
							},
							axisTicks: {
								show: false,
							},
							tickAmount: 6,
							labels: {
								rotate: 0,
								rotateAlways: true,
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
							},
							crosshairs: {
								position: "front",
								stroke: {
									color: baseColor,
									width: 1,
									dashArray: 3,
								},
							},
							tooltip: {
								enabled: true,
								formatter: undefined,
								offsetY: 0,
								style: {
									fontSize: "12px",
								},
							},
						},
						yaxis: {
							tickAmount: 4,
							max: maxValue,
							min: 0,
							labels: {
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
								formatter: function (val) {
									return val;
								},
							},
						},
						states: {
							normal: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							hover: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							active: {
								allowMultipleDataPointsSelection: false,
								filter: {
									type: "none",
									value: 0,
								},
							},
						},
						tooltip: {
							style: {
								fontSize: "12px",
							},
							y: {
								formatter: function (val) {
									return val;
								},
							},
						},
						colors: [lightColor],
						grid: {
							borderColor: borderColor,
							strokeDashArray: 4,
							yaxis: {
								lines: {
									show: true,
								},
							},
						},
						markers: {
							strokeColor: baseColor,
							strokeWidth: 3,
						},
					};

					chart.self = new ApexCharts(element, options);

					// Set timeout to properly get the parent elements width
					setTimeout(function () {
						chart.self.render();
						chart.rendered = true;
					}, 200);
				},
				complete: function () {},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				},
			});
		} else if (valuee === "Monthly") {
			$.ajax({
				url:
					window.location.origin +
					"/TOM_S1/controllers/dashboard.php", // Action
				type: "POST", // Method
				data: {
					action: "get_monthly_orders",
					category: category,
				},
				dataType: "JSON",
				beforeSend: function () {},
				success: function (response) {
					var dataSales = response.sales;
					var dataDay = response.days;
					let maxValue = Math.max(...dataSales);

					let total_sales_D = 0;
					dataSales.forEach((sales) => {
						total_sales_D += sales;
					});
					salesTitle.textContent = "Monthly Orders";
					categoryExpense.textContent = text;
					totalSales.textContent = total_sales_D;

					var options = {
						series: [
							{
								name: "Orders",
								data: dataSales,
							},
						],
						chart: {
							fontFamily: "inherit",
							type: "area",
							height: height,
							toolbar: {
								show: false,
							},
						},
						plotOptions: {},
						legend: {
							show: false,
						},
						dataLabels: {
							enabled: false,
						},
						fill: {
							type: "gradient",
							gradient: {
								shadeIntensity: 1,
								opacityFrom: 0.4,
								opacityTo: 0,
								stops: [0, 80, 100],
							},
						},
						stroke: {
							curve: "smooth",
							show: true,
							width: 3,
							colors: [baseColor],
						},
						xaxis: {
							categories: dataDay,
							axisBorder: {
								show: false,
							},
							axisTicks: {
								show: false,
							},
							tickAmount: 6,
							labels: {
								rotate: 0,
								rotateAlways: true,
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
							},
							crosshairs: {
								position: "front",
								stroke: {
									color: baseColor,
									width: 1,
									dashArray: 3,
								},
							},
							tooltip: {
								enabled: true,
								formatter: undefined,
								offsetY: 0,
								style: {
									fontSize: "12px",
								},
							},
						},
						yaxis: {
							tickAmount: 4,
							max: maxValue,
							min: 0,
							labels: {
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
								formatter: function (val) {
									return val;
								},
							},
						},
						states: {
							normal: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							hover: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							active: {
								allowMultipleDataPointsSelection: false,
								filter: {
									type: "none",
									value: 0,
								},
							},
						},
						tooltip: {
							style: {
								fontSize: "12px",
							},
							y: {
								formatter: function (val) {
									return val;
								},
							},
						},
						colors: [lightColor],
						grid: {
							borderColor: borderColor,
							strokeDashArray: 4,
							yaxis: {
								lines: {
									show: true,
								},
							},
						},
						markers: {
							strokeColor: baseColor,
							strokeWidth: 3,
						},
					};

					chart.self = new ApexCharts(element, options);

					// Set timeout to properly get the parent elements width
					setTimeout(function () {
						chart.self.render();
						chart.rendered = true;
					}, 200);
				},
				complete: function () {},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				},
			});
		} else if (valuee === "Yearly") {
			$.ajax({
				url:
					window.location.origin +
					"/TOM_S1/controllers/dashboard.php", // Action
				type: "POST", // Method
				data: {
					action: "get_yearly_orders",
					category: category,
				},
				dataType: "JSON",
				beforeSend: function () {},
				success: function (response) {
					var dataSales = response.sales;
					var dataDay = response.days;
					let maxValue = Math.max(...dataSales);

					let total_sales_D = 0;
					dataSales.forEach((sales) => {
						total_sales_D += sales;
					});
					salesTitle.textContent = "Yearly Orders";
					categoryExpense.textContent = text;
					totalSales.textContent = total_sales_D;

					var options = {
						series: [
							{
								name: "Orders",
								data: dataSales,
							},
						],
						chart: {
							fontFamily: "inherit",
							type: "area",
							height: height,
							toolbar: {
								show: false,
							},
						},
						plotOptions: {},
						legend: {
							show: false,
						},
						dataLabels: {
							enabled: false,
						},
						fill: {
							type: "gradient",
							gradient: {
								shadeIntensity: 1,
								opacityFrom: 0.4,
								opacityTo: 0,
								stops: [0, 80, 100],
							},
						},
						stroke: {
							curve: "smooth",
							show: true,
							width: 3,
							colors: [baseColor],
						},
						xaxis: {
							categories: dataDay,
							axisBorder: {
								show: false,
							},
							axisTicks: {
								show: false,
							},
							tickAmount: 6,
							labels: {
								rotate: 0,
								rotateAlways: true,
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
							},
							crosshairs: {
								position: "front",
								stroke: {
									color: baseColor,
									width: 1,
									dashArray: 3,
								},
							},
							tooltip: {
								enabled: true,
								formatter: undefined,
								offsetY: 0,
								style: {
									fontSize: "12px",
								},
							},
						},
						yaxis: {
							tickAmount: 4,
							max: maxValue,
							min: 0,
							labels: {
								style: {
									colors: labelColor,
									fontSize: "12px",
								},
								formatter: function (val) {
									return val;
								},
							},
						},
						states: {
							normal: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							hover: {
								filter: {
									type: "none",
									value: 0,
								},
							},
							active: {
								allowMultipleDataPointsSelection: false,
								filter: {
									type: "none",
									value: 0,
								},
							},
						},
						tooltip: {
							style: {
								fontSize: "12px",
							},
							y: {
								formatter: function (val) {
									return val;
								},
							},
						},
						colors: [lightColor],
						grid: {
							borderColor: borderColor,
							strokeDashArray: 4,
							yaxis: {
								lines: {
									show: true,
								},
							},
						},
						markers: {
							strokeColor: baseColor,
							strokeWidth: 3,
						},
					};

					chart.self = new ApexCharts(element, options);

					// Set timeout to properly get the parent elements width
					setTimeout(function () {
						chart.self.render();
						chart.rendered = true;
					}, 200);
				},
				complete: function () {},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				},
			});
		}
	};

	// Add a new function to destroy the chart
	var destroyChart = function () {
		if (chart.rendered && chart.self) {
			chart.self.destroy();
			chart.rendered = false;
		}
	};
	// Public methods
	return {
		init: function (valuee, category, text) {
			initChart(chart, valuee, category, text);
			// Update chart on theme mode change
			KTThemeMode.on("kt.thememode.change", function () {
				if (chart.rendered) {
					chart.self.destroy();
				}

				initChart(chart, valuee, category, text);
			});
		},
		destroy: function () {
			destroyChart(); // Destroy the chart externally if needed
		},
	};
})();

// Webpack support
if (typeof module !== "undefined") {
	module.exports = KTChartsWidget3;
}

// On document ready
KTUtil.onDOMContentLoaded(function () {
	const saleDisplaySelect = document.querySelector("#sales_filter_select");
	KTChartsWidget3.init(saleDisplaySelect.value);
	// --------------------------------------
	const stockDisplaySelect = document.querySelector("#stock_filter_select");
	const stockCategoryDisplaySelect = document.querySelector(
		"#stockcategory_filter_select"
	);
	// --------------------------------------
	KTChartsWidget4.init(
		stockDisplaySelect.value,
		stockCategoryDisplaySelect.value
	);
	// --------------------------------------
	const ordersDisplaySelect = document.querySelector("#orders_filter_select");
	const ordersCategoryDisplaySelect = document.querySelector(
		"#orderscategory_filter_select"
	);
	let initialSelectedText = $(ordersCategoryDisplaySelect)
		.find("option:selected")
		.text();
	KTChartsWidget5.init(
		ordersDisplaySelect.value,
		ordersCategoryDisplaySelect.value,
		initialSelectedText
	);
	// --------------------------------------
	$(saleDisplaySelect).on("change", (e) => {
		let value = e.target.value;
		// Do something with the selected value
		KTChartsWidget3.destroy();
		KTChartsWidget3.init(value);
	});
	// --------------------------------------
	$(stockDisplaySelect).on("change", (e) => {
		let value = e.target.value;
		// Do something with the selected value
		KTChartsWidget4.destroy();
		KTChartsWidget4.init(value, stockCategoryDisplaySelect.value);
	});
	$(stockCategoryDisplaySelect).on("change", (e) => {
		let value = e.target.value;
		// Do something with the selected value
		KTChartsWidget4.destroy();
		KTChartsWidget4.init(stockDisplaySelect.value, value);
	});
	// --------------------------------------
	$(ordersDisplaySelect).on("change", (e) => {
		let value = e.target.value;
		// Do something with the selected value
		KTChartsWidget5.destroy();
		KTChartsWidget5.init(
			value,
			ordersCategoryDisplaySelect.value,
			initialSelectedText
		);
	});
	$(ordersCategoryDisplaySelect).on("change", (e) => {
		let value = e.target.value;
		let text = $(e.target).find("option:selected").text();
		// Do something with the selected value
		KTChartsWidget5.destroy();
		KTChartsWidget5.init(ordersDisplaySelect.value, value, text);
	});
	// KTChartsWidget3.init("");
});
