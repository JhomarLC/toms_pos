<?php
    session_start();
    require("../controllers/db_connection.php");

    if(isset($_COOKIE['account_signed_in'])){
        $user = json_decode($_COOKIE['account_signed_in'], true);
        if($user['role'] == "Staff"){
            header("Location: ../other/illegal_access/staff.php");
        }
    } else {
        header("Location: ../");
    }
    date_default_timezone_set('Asia/Manila');
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../" />
    <title>TCH | Admin</title>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="assets/media/logos/logo.png" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/custom/vis-timeline/vis-timeline.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <!--begin::Theme mode setup on page load-->
    <?php
			require("../other/message.php");
		?>
    <script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Aside-->
            <div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
                data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
                <?php include("./templates/nav.php") ?>
                <?php include("./templates/footer.php") ?>
            </div>
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include("./templates/header-tb.php") ?>
                <?php include("./templates/header.php") ?>
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-xxl" id="kt_content_container">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3">
                                <!--begin::Card widget 5-->
                                <div class="card card-flush mb-10">
                                    <!--begin::Header-->
                                    <div class="card-header pt-5">
                                        <!--begin::Title-->
                                        <div class="card-body d-flex flex-column">
                                            <div class="mb-auto">
                                                <!--begin::Info-->
                                                <div class="d-flex align-items-center">
                                                    <?php  
                                                $query = "SELECT
                                                last_month.orders AS last_month_orders,
                                                this_month.orders AS this_month_orders,
                                                CASE
                                                    WHEN last_month.orders = 0 THEN NULL  -- Avoid division by zero
                                                    ELSE ((this_month.orders - last_month.orders) / last_month.orders) * 100
                                                END AS percent_change
                                            FROM
                                                (
                                                    SELECT COUNT(*) AS orders
                                                    FROM orders
                                                    WHERE MONTH(order_date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
                                                      AND YEAR(order_date) = YEAR(CURRENT_DATE())
                                                      AND status != 'refunded'
                                                ) AS last_month,
                                                (
                                                    SELECT COUNT(*) AS orders
                                                    FROM orders
                                                    WHERE MONTH(order_date) = MONTH(CURRENT_DATE())
                                                      AND YEAR(order_date) = YEAR(CURRENT_DATE())
                                                      AND status != 'refunded'
                                                ) AS this_month;";
                                                $stmt = $connection->prepare($query);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $otMonth = $result->fetch_assoc();
                                                ?>
                                                    <!--begin::Amount-->
                                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2"
                                                        data-kt-countup="true"
                                                        data-kt-countup-value="<?= $otMonth['this_month_orders'] ?>">0</span>
                                                    <!--end::Amount-->
                                                    <!--begin::Badge-->

                                                    <?php
                                                if ($otMonth['percent_change'] < 0) {?>
                                                    <span class=" badge badge-light-danger fs-base">
                                                        <i class="ki-duotone ki-arrow-down fs-5 text-danger ms-n1">
                                                            <?php } else { ?>
                                                            <span class="badge badge-light-success fs-base">
                                                                <i
                                                                    class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                                                    <?php } ?>
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i><?= number_format($otMonth['percent_change'], 2); ?>%</span>
                                                            <!--end::Badge-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Subtitle-->
                                                <span class="text-success pt-1 fw-semibold fs-6">Orders This
                                                    Month</span>
                                                <!--end::Subtitle-->
                                            </div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 5-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3">
                                <!--begin::Card widget 5-->
                                <div class="card card-flush mb-10">
                                    <!--begin::Header-->
                                    <div class="card-header pt-5">
                                        <!--begin::Title-->
                                        <div class="card-body d-flex flex-column">
                                            <div class="mb-auto">
                                                <!--begin::Info-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Currency-->
                                                    <?php 
                                                $query = "SELECT
                                                DATE_FORMAT(calendar_date, '%b %e') AS shorten_day,
                                                calendar_date AS sale_day,
                                                COALESCE(SUM(CASE WHEN status != 'refunded' THEN total ELSE 0 END), 0) AS daily_sales
                                            FROM
                                                (
                                                    SELECT CURDATE() as calendar_date
                                                ) calendar
                                                LEFT JOIN orders ON DATE(orders.order_date) = calendar.calendar_date AND orders.status != 'refunded'
                                            WHERE
                                                calendar_date = CURDATE() AND YEAR(calendar_date) = YEAR(CURDATE())
                                            GROUP BY
                                                sale_day
                                            ORDER BY
                                                sale_day ASC;";
                                                $stmt = $connection->prepare($query);
                                                $stmt->execute();

                                                $result = $stmt->get_result();
                                                $dSales = $result->fetch_assoc();
                                                ?>
                                                    <span
                                                        class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">₱</span>
                                                    <!--end::Currency-->
                                                    <!--begin::Amount-->
                                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2"
                                                        data-kt-countup="true" data-kt-countup-decimal-places="2"
                                                        data-kt-countup-value="<?= $dSales['daily_sales'] ?>">0</span>
                                                    <?php $stmt->close(); ?>
                                                    <!--end::Amount-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Subtitle-->
                                                <span class="text-success pt-1 fw-semibold fs-6">Today's Sale</span>
                                                <!--end::Subtitle-->
                                            </div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 6-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3">
                                <!--begin::Card widget 5-->
                                <div class="card card-flush mb-10">
                                    <!--begin::Header-->
                                    <div class="card-header pt-5">
                                        <!--begin::Title-->
                                        <div class="card-body d-flex flex-column">
                                            <div class="mb-auto">
                                                <!--begin::Info-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Currency-->
                                                    <?php 
                                                $query = "SELECT 
                                                        COALESCE(SUM(price_today * total_out), 0) AS total_expense_today
                                                    FROM 
                                                        stockinventory
                                                    WHERE 
                                                        stock_category = 'Chicken' AND
                                                        stock_date = CURDATE();";
                                                $stmt = $connection->prepare($query);
                                                $stmt->execute();

                                                $result = $stmt->get_result();
                                                $chickenExpense = $result->fetch_assoc();
                                                ?>
                                                    <span
                                                        class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">₱</span>
                                                    <!--end::Currency-->
                                                    <!--begin::Amount-->
                                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2"
                                                        data-kt-countup="true" data-kt-countup-decimal-places="2"
                                                        data-kt-countup-value="<?= $chickenExpense['total_expense_today'] ?>">0</span>
                                                    <?php $stmt->close(); ?>
                                                    <!--end::Amount-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Subtitle-->
                                                <span class="text-success pt-1 fw-semibold fs-6">Chicken Expense
                                                    Today</span>
                                                <!--end::Subtitle-->
                                            </div>

                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 6-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3">
                                <!--begin::Card widget 5-->
                                <div class="card card-flush mb-10">
                                    <!--begin::Header-->
                                    <div class="card-header pt-5">
                                        <!--begin::Title-->
                                        <div class="card-body d-flex flex-column">
                                            <div class="mb-auto">
                                                <!--begin::Info-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Currency-->
                                                    <?php 
                                                $query = "SELECT 
                                                        COALESCE(SUM(price_today * total_out), 0) AS total_expense_today
                                                    FROM 
                                                        stockinventory
                                                    WHERE 
                                                        stock_category = 'Isaw' AND
                                                        stock_date = CURDATE();";
                                                $stmt = $connection->prepare($query);
                                                $stmt->execute();

                                                $result = $stmt->get_result();
                                                $isawExpense = $result->fetch_assoc();
                                                ?>
                                                    <span
                                                        class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">₱</span>
                                                    <!--end::Currency-->
                                                    <!--begin::Amount-->
                                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2"
                                                        class="fs-2 fw-bold" data-kt-countup="true"
                                                        data-kt-countup-decimal-places="2"
                                                        data-kt-countup-value="<?= $isawExpense['total_expense_today'] ?>">0
                                                        >0</span>
                                                    <?php $stmt->close(); ?>
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Subtitle-->
                                                <span class="text-success pt-1 fw-semibold fs-6">Isaw Expense
                                                    Today</span>
                                                <!--end::Subtitle-->
                                            </div>

                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 6-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0 mb-10">
                                <!--begin::Chart widget 3-->
                                <div class="card card-flush overflow-hidden h-md-100">
                                    <!--begin::Header-->
                                    <div class="card-header py-5">
                                        <!--begin::Title-->
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold text-dark" id="sales_title"></span>
                                        </h3>
                                        <!--begin::Flatpickr-->
                                        <div class="input-group w-150px">
                                            <select class="form-select form-select-solid" data-control="select2"
                                                data-kt-select2="true" data-hide-search="true"
                                                data-placeholder="Category" id="sales_filter_select">
                                                <option></option>
                                                <option value="Weekly" selected>
                                                    Weekly
                                                </option>
                                                <option value="Monthly">
                                                    Monthly
                                                </option>
                                            </select>
                                            <!--end::Select2-->
                                        </div>
                                        <!--end::Flatpickr-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Card body-->
                                    <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                                        <!--begin::Statistics-->
                                        <div class="px-9 mb-5">
                                            <!--begin::Statistics-->
                                            <div class="d-flex mb-2">
                                                <span class="fs-4 fw-semibold text-gray-400 me-1">₱</span>
                                                <span id="total_sales_chart"
                                                    class="fs-2hx fw-bold text-success me-2 lh-1 ls-n2"></span>
                                            </div>
                                            <!--end::Statistics-->
                                            <!--begin::Description-->
                                            <!-- <span class="fs-6 fw-semibold text-gray-400">Another ₱48,346 to Goal</span> -->
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Statistics-->
                                        <!--begin::Chart-->
                                        <div id="kt_charts_widget_3" class="min-h-auto ps-4 pe-6" style="height: 300px">
                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Chart widget 3-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0 mb-10">
                                <!--begin::Chart widget 3-->
                                <div class="card card-flush overflow-hidden h-md-100">
                                    <!--begin::Header-->
                                    <div class="card-header py-5">
                                        <!--begin::Title-->
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="badge badge-primary" id="category_text"></span>
                                            <span class="card-label fw-bold text-dark" id="sales_title_4"></span>
                                        </h3>
                                        <div class="d-flex gap-3">
                                            <!--begin::Flatpickr-->
                                            <div class="input-group w-150px">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-kt-select2="true" data-hide-search="true"
                                                    data-placeholder="Category" id="stockcategory_filter_select">
                                                    <option></option>
                                                    <option value="Chicken" selected>
                                                        Chicken
                                                    </option>
                                                    <option value="Isaw">
                                                        Isaw
                                                    </option>
                                                    <option value="Others">
                                                        Others
                                                    </option>
                                                </select>
                                            </div>
                                            <!--end::Flatpickr-->
                                            <!--begin::Flatpickr-->
                                            <div class="input-group w-150px">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-kt-select2="true" data-hide-search="true"
                                                    data-placeholder="Category" id="stock_filter_select">
                                                    <option></option>
                                                    <option value="Weekly" selected>
                                                        Weekly
                                                    </option>
                                                    <option value="Monthly">
                                                        Monthly
                                                    </option>
                                                </select>
                                            </div>
                                            <!--end::Flatpickr-->

                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Card body-->
                                    <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                                        <!--begin::Statistics-->
                                        <div class="px-9 mb-5">
                                            <!--begin::Statistics-->
                                            <div class="d-flex mb-2">
                                                <span class="fs-4 fw-semibold text-gray-400 me-1">₱</span>
                                                <span id="total_sales_chart_4"
                                                    class="fs-2hx fw-bold text-primary me-2 lh-1 ls-n2"></span>
                                            </div>
                                            <!--end::Statistics-->
                                            <!--begin::Description-->
                                            <!-- <span class="fs-6 fw-semibold text-gray-400">Another ₱48,346 to Goal</span> -->
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Statistics-->
                                        <!--begin::Chart-->
                                        <div id="kt_charts_widget_4" class="min-h-auto ps-4 pe-6" style="height: 300px">
                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Chart widget 3-->
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0 mt-10">
                                <!--begin::Chart widget 3-->
                                <div class="card card-flush overflow-hidden h-md-100">
                                    <!--begin::Header-->
                                    <div class="card-header py-5">
                                        <!--begin::Title-->
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="badge badge-light-warning" id="orders_text"></span>
                                            <span class="card-label fw-bold text-dark" id="sales_title_5"></span>
                                        </h3>
                                        <div class="d-flex gap-3">
                                            <!--begin::Flatpickr-->
                                            <div class="input-group w-200px">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-kt-select2="true" data-hide-search="true"
                                                    data-placeholder="Category" id="orderscategory_filter_select">
                                                    <?php 
                                                        $query = "SELECT * FROM category";
                                                        $stmt = $connection->prepare($query);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();

                                                        if($result->num_rows > 0){
                                                            while($category = $result->fetch_assoc()){
                                                                if(isset($item) && $item['category_id'] == $category['category_id']){
                                                                ?>
                                                    <option value="<?= $category['category_id'] ?>" selected>
                                                        <?= $category['category_name'] ?></option>
                                                    <?php
                                                        } else {
                                                        ?>
                                                    <option value="<?= $category['category_id'] ?>">
                                                        <?= $category['category_name'] ?>
                                                    </option>
                                                    <?php
                                                                }
                                                            }
                                                        } else {
                                                            ?>
                                                    <option value="" disabled>No Category to Show</option>
                                                    <?php
                                                        }
                                                        $stmt->close();
                                                        ?>
                                                </select>
                                            </div>
                                            <!--end::Flatpickr-->
                                            <!--begin::Flatpickr-->
                                            <div class="input-group w-150px">
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-kt-select2="true" data-hide-search="true"
                                                    data-placeholder="Category" id="orders_filter_select">
                                                    <option></option>
                                                    <option value="Weekly" selected>
                                                        Weekly
                                                    </option>
                                                    <option value="Monthly">
                                                        Monthly
                                                    </option>
                                                </select>
                                            </div>
                                            <!--end::Flatpickr-->

                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Card body-->
                                    <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                                        <!--begin::Statistics-->
                                        <div class="px-9 mb-5">
                                            <!--begin::Statistics-->
                                            <div class="d-flex mb-2">
                                                <span id="total_sales_chart_5"
                                                    class="fs-2hx fw-bold text-warning me-2 lh-1 ls-n2"></span>
                                            </div>
                                            <!--end::Statistics-->
                                            <!--begin::Description-->
                                            <!-- <span class="fs-6 fw-semibold text-gray-400">Another ₱48,346 to Goal</span> -->
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Statistics-->
                                        <!--begin::Chart-->
                                        <div id="kt_charts_widget_5" class="min-h-auto ps-4 pe-6" style="height: 300px">
                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Chart widget 3-->
                            </div>
                            <!--end::Col-->
                        </div>
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                    <!--begin::Container-->
                    <div class="container-fluid d-flex flex-column flex-md-row flex-stack">
                        <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-gray-400 fw-semibold me-1">Created by</span>
                            <a href="" target="_blank" class="text-muted text-hover-primary fw-semibold me-2 fs-6">BSIT
                                3-1</a>
                        </div>
                        <!--end::Copyright-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Scrolltop-->
    <!--end::Modals-->
    <!--begin::Javascript-->
    <script>
    var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="assets/plugins/custom/vis-timeline/vis-timeline.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <!-- <script src="assets/js/widgets.bundle.js"></script> -->
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/scripts/dashboard/widgets.js"></script>
    <!-- <script src="assets/js/custom/scripts/dashboard/widgets_4.js"></script> -->
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>