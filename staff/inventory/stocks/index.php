<?php
    session_start();
    require("../../../controllers/db_connection.php");
    date_default_timezone_set('Asia/Manila');
    
    if(isset($_COOKIE['account_signed_in'])){
        $user = json_decode($_COOKIE['account_signed_in'], true);
        if($user['role'] == "Admin"){
            header("Location: ../../../other/illegal_access/admin.php");
        }
    } else {
        header("Location: ../../../");
    }
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../../../" />
    <title>TCH | Admin</title>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="assets/media/logos/logo.png" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/custom/vis-timeline/vis-timeline.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <!--begin::Image placeholder-->
    <style>
    .image-input-placeholder {
        background-image: url("assets/media/svg/files/blank-image.svg");
    }

    [data-bs-theme="dark"] .image-input-placeholder {
        background-image: url("assets/media/svg/files/blank-image-dark.svg");
    }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <!--begin::Theme mode setup on page load-->
    <?php
        require("../../../other/message.php");
    ?>
    <!--begin::Theme mode setup on page load-->
    <script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode =
                document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ?
                "dark" :
                "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
    </script>
    <!--end::Theme mode setup on page load-->
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
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card header-->
                            <div class="card-header border-0 pt-6">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">

                                        <input type="text" hidden data-kt-user-table-filter="search_item"
                                            class="form-control form-control-solid w-250px ps-13"
                                            placeholder="Search Stock" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--begin::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Toolbar-->
                                    <div class="d-flex gap-3 justify-content-end" data-kt-user-table-toolbar="base">
                                        <!--begin::Flatpickr-->
                                        <div class="input-group w-250px">
                                            <select class="form-select form-select-solid" data-control="select2"
                                                data-kt-select2="true" data-hide-search="true"
                                                data-placeholder="Category" data-kt-ecommerce-order-filter="category">
                                                <option></option>
                                                <option value="Chicken" selected>
                                                    Chicken
                                                </option>
                                                <option value="Isaw">
                                                    Isaw
                                                </option>
                                            </select>
                                            <!--end::Select2-->
                                        </div>
                                        <!--end::Flatpickr-->
                                        <?php
                                        // $checkQuery = "SELECT COUNT(*) FROM stockinventory WHERE stock_date = CURDATE()";
                                        // $checkResult = $connection->query($checkQuery);

                                        // if ($checkResult->fetch_row()[0] > 0) {
                                        ?>
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#add_stock_modal" disabled>
                                            <i class="ki-duotone ki-plus fs-2"></i>Add Stock Today
                                        </button> -->
                                        <?php // } else { ?>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#add_stock_modal">
                                            <i class="ki-duotone ki-plus fs-2"></i>Add Stock Today
                                        </button>
                                        <?php
                                        //}
                                        ?>
                                        <!--end::Add user-->
                                    </div>
                                    <!--end::Toolbar-->
                                    <!--begin::Modal - Adjust Balance-->
                                    <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-650px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content">
                                                <!--begin::Modal header-->
                                                <div class="modal-header">
                                                    <!--begin::Modal title-->
                                                    <h2 class="fw-bold">Export Users</h2>
                                                    <!--end::Modal title-->
                                                    <!--begin::Close-->
                                                    <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                        data-kt-users-modal-action="close">
                                                        <i class="ki-duotone ki-cross fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </div>
                                                    <!--end::Close-->
                                                </div>
                                                <!--end::Modal header-->
                                            </div>
                                            <!--end::Modal content-->
                                        </div>
                                        <!--end::Modal dialog-->
                                    </div>
                                    <!--end::Modal - New Card-->
                                    <!--begin::Modal - Add task-->
                                    <!--end::Modal - Add task-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <?php include("templates/_addstock.php") ?>

                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body py-4">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_items">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Category</th>
                                            <th class="min-w-125px">Date</th>
                                            <th class="min-w-125px">Old Stock</th>
                                            <th class="min-w-125px">Delivery</th>
                                            <th class="min-w-125px">Total Out</th>
                                            <th class="min-w-125px">New Stock</th>
                                            <th class="min-w-125px">Price</th>
                                            <th class="min-w-125px">Expense</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        <?php
								$query = "SELECT * FROM stockinventory WHERE stock_date = CURDATE() ORDER BY stock_date DESC";
                                $stmt = $connection->prepare($query);
                                $stmt->execute();
                                $result = $stmt->get_result();
                    
                                $num = 0;
                                $currentDate = date("d/m/Y");
                                if($result->num_rows > 0){
                                    while($stock = $result->fetch_assoc()){
                                        $stockDate = date("d/m/Y", strtotime($stock['stock_date']));
                                        $isCurrentDate = ($currentDate == $stockDate);
                                        $stockData =  date("Y-m-d", strtotime($stock['stock_date']));?>
                                        <tr>
                                            <td><?= $stock['stock_category'] ?></td>
                                            <td data-order="<?= $stockData ?>">
                                                <span
                                                    class="fw-bold badge badge-light-warning fw-bold"><?= $stockDate ?></span>
                                            </td>
                                            <td><?= $stock['old_stock'] ?> kg</td>
                                            <td><?= $stock['delivery'] ?> kg</td>
                                            <td>
                                                <div class="badge badge-light-danger fw-bold">
                                                    <?= $stock['total_out'] ?> kg
                                                </div>
                                            </td>
                                            <td>
                                                <div class="badge badge-light-success fw-bold"><?= $stock['newstock'] ?>
                                                    kg
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($stock['price_today'] == 0) { ?>
                                                Edit to add Price
                                                <?php } else { ?>
                                                P<?= $stock['price_today'] ?>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <div class="badge badge-light-success fw-bold">
                                                    P<?= $stock['expense_today'] ?>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <!--begin::Edit user-->
                                                <?php if ($isCurrentDate) { ?>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    onclick="GetEditValueStock(<?= $stock['stock_id'] ?>)">
                                                    <i class="ki-duotone ki-pencil fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>Edit
                                                </button>
                                                <?php } else { ?>
                                                <button type="button" class="btn btn-sm btn-light-success" disabled>
                                                    <i class="ki-duotone ki-pencil fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>Edit
                                                </button>
                                                <?php } ?>
                                                <!--end::Edit user-->
                                            </td>
                                        </tr>
                                        <?php } 
                                        }?>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!-- ################################### -->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->
                <?php include("templates/_editstock.php") ?>
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

    <!--end::Main-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Scrolltop-->
    <!--begin::Javascript-->
    <script>
    var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/js/custom/scripts/inventory_stock.js"></script>
    <script src="assets/js/custom/scripts/image-input.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!-- <script src="assets/plugins/custom/vis-timeline/vis-timeline.bundle.js"></script> -->
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="assets/js/custom/apps/user-management/users/list/table_stocks.js"></script>
    <!-- <script src="assets/js/custom/apps/user-management/users/list/export-users.js"></script> -->
    <!-- <script src="assets/js/custom/apps/user-management/users/list/add.js"></script> -->
    <script src="assets/js/custom/validation.js"></script>
    <script src="assets/js/custom/authentication/sign-in/general.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>