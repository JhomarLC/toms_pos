<?php
    session_start();
    require("../../../controllers/db_connection.php");

    if(isset($_COOKIE['account_signed_in'])){
        $user = json_decode($_COOKIE['account_signed_in'], true);
        if($user['role'] == "Staff"){
            header("Location: ../../../other/illegal_access/staff.php");
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
                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" data-kt-user-table-filter="search_item"
                                            class="form-control form-control-solid w-250px ps-13"
                                            placeholder="Search Discounts" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--begin::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Toolbar-->
                                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                        <!--begin::Add user-->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#add_voucher_modal">
                                            <i class="ki-duotone ki-plus fs-2"></i>Add Voucher
                                        </button>
                                        <!--end::Add user-->
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <?php include("templates/_addcategory.php") ?>

                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body py-4">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_items">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Discount Code</th>
                                            <th class="min-w-125px">Discount Percent</th>
                                            <th class="min-w-125px">Status</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        <?php
								$query = "SELECT  * FROM vouchers ORDER BY voucher_id DESC";
                                $stmt = $connection->prepare($query);
                                $stmt->execute();
                                $result = $stmt->get_result();
                    
                                if($result->num_rows > 0){
                                    while($voucher = $result->fetch_assoc()){ ?>
                                        <tr>
                                            <td>
                                                <?= $voucher['voucher_code'] ?>
                                            </td>
                                            <td>
                                                <?= $voucher['voucher_percent'] ?>
                                            </td>
                                            <td>
                                                <?php if($voucher['voucher_status'] == "active") { ?>
                                                <div class="badge badge-light-success fw-bold">
                                                    <?= $voucher['voucher_status'] ?>
                                                </div>
                                                <?php } else { ?>
                                                <div class="badge badge-light-danger fw-bold">
                                                    <?= $voucher['voucher_status'] ?>
                                                </div>
                                                <?php }  ?>
                                            </td>
                                            <td class="text-end">
                                                <!--begin::Edit user-->
                                                <button type="button" class="btn btn-sm btn-success"
                                                    onclick="GetEditValue(<?= $voucher['voucher_id'] ?>)">
                                                    <i class="ki-duotone ki-pencil fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>Edit
                                                </button>
                                                <!--end::Edit user-->
                                                <!--begin::Set status-->
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="SetStatus(<?= $voucher['voucher_id'] ?>, '<?= $voucher['voucher_status'] ?>')">
                                                    <i class="ki-duotone ki-price-tag fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                    <?php if($voucher['voucher_status'] == 'active') { ?>
                                                    Set inactive
                                                    <?php } elseif ($voucher['voucher_status'] == 'inactive') {?>
                                                    Set active
                                                    <?php } ?>
                                                </button>
                                                <!--end::Set status-->
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
                <?php include("templates/_editcategory.php") ?>
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
    <script src="assets/js/custom/scripts/discounts_admin.js"></script>
    <script src="assets/js/custom/scripts/image-input.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="assets/plugins/custom/vis-timeline/vis-timeline.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="assets/js/custom/apps/user-management/users/list/table2.js"></script>
    <script src="assets/js/custom/apps/user-management/users/list/export-users.js"></script>
    <script src="assets/js/custom/apps/user-management/users/list/add.js"></script>
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