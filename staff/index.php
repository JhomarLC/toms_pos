<?php
    session_start();
    require("../controllers/db_connection.php");
    date_default_timezone_set('Asia/Manila');
    if(isset($_COOKIE['account_signed_in'])){
        $user = json_decode($_COOKIE['account_signed_in'], true);
        if($user['role'] == "Admin"){
            header("Location: ../other/illegal_access/admin.php");
        }
    } else {
        header("Location: ../");
    }
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../" />
    <title>TCH | Staff</title>
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
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <!--begin::Theme mode setup on page load-->
    <?php
        require("../other/message.php");
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
                    <div class="container-xxxl px-10" id="kt_content_container">
                        <!--begin::Layout-->
                        <div class="d-flex flex-column flex-xl-row">
                            <!--begin::Content-->
                            <div class="d-flex flex-row-fluid me-xl-9 mb-10 mb-xl-0">
                                <!--begin::Pos food-->
                                <div class="card card-flush card-p-0 bg-transparent border-0">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Nav-->
                                        <div class="hover-scroll-x mb-5">
                                            <ul
                                                class="nav nav-pills d-flex flex-nowrap text-wrap nav-pills-custom gap-3 mb-6">
                                                <!--begin::Item-->
                                                <?php 
                                            $query = "SELECT  * FROM category WHERE status != 'archived'";
                                            $stmt = $connection->prepare($query);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            
                                            if($result->num_rows > 0){
                                                $isFirstResult = true;
                                                while($category = $result->fetch_assoc()){ 
                                            ?>
                                                <li class="nav-item mb-3 me-0">
                                                    <!--begin::Nav link-->
                                                    <?php if( $isFirstResult ) { ?>
                                                    <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack pt-9 pb-7 page-bg show active"
                                                        data-bs-toggle="pill" href="#<?= $category['category_id'] ?>"
                                                        style="width: 150px;height: 180px">
                                                        <?php   
                                                $isFirstResult = false;
                                                } else { ?>
                                                        <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack pt-9 pb-7 page-bg show"
                                                            data-bs-toggle="pill"
                                                            href="#<?= $category['category_id'] ?>"
                                                            style="width: 150px;height: 180px">
                                                            <?php
                                                }?>
                                                            <!--begin::Icon-->
                                                            <div class="nav-icon mb-3">
                                                                <!--begin::Food icon-->
                                                                <img src="images/uploads/<?= $category['image'] ?>"
                                                                    class="w-50px" alt="" />
                                                                <!--end::Food icon-->
                                                            </div>
                                                            <!--end::Icon-->
                                                            <!--begin::Info-->
                                                            <div class="">
                                                                <span
                                                                    class="text-gray-800 fw-bold fs-2 d-block"><?= $category['category_name'] ?></span>
                                                                <!-- <span class="text-gray-400 fw-semibold fs-7">8 Options</span> -->
                                                            </div>
                                                            <!--end::Info-->
                                                        </a>
                                                        <!--end::Nav link-->
                                                        <?php }
                                                }
                                            ?>
                                            </ul>
                                            <!--end::Nav-->
                                        </div>
                                        <!--begin::Tab Content-->
                                        <div class="tab-content">
                                            <?php 
                                            $query_c = "SELECT  * FROM category WHERE status != 'archived'";
                                            $stmt_c = $connection->prepare($query_c);
                                            $stmt_c->execute();
                                            $result_c = $stmt_c->get_result();
                                            
                                            if($result_c->num_rows > 0){
                                                $isFirstResult1 = true;
                                                while($category = $result_c->fetch_assoc()){ 

                                                    if( $isFirstResult1) { 
                                            ?>
                                            <!--begin::Tap pane-->
                                            <div class="tab-pane fade show active" id="<?= $category['category_id'] ?>">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-wrap align-content-start d-grid gap-3 gap-xxl-5 scroll pe-5"
                                                    data-kt-scroll="true"
                                                    data-kt-scroll-height="{default: '100px', lg: '700px'}">
                                                    <?php
                                                    $query_i = "SELECT * FROM items WHERE category_id = ?";
                                                    $stmt_i = $connection->prepare($query_i);
                                                    $stmt_i->bind_param("i", $category['category_id']);
                                                    $stmt_i->execute();
                                                    $result_i = $stmt_i->get_result();
                                                    
                                                    if($result_i->num_rows > 0){
                                                        while($item = $result_i->fetch_assoc()){
                                                    ?>
                                                    <!--begin::Card-->
                                                    <!--begin::Ribbon wrapper 1-->
                                                    <?php if($item['status'] == "unarchived") {?>
                                                    <div class="overflow-hidden position-relative mw-100 card-rounded  cursor-pointer"
                                                        onclick="createDialer(this, <?= $item['item_id'] ?>, '<?= $item['item_name'] ?>', <?= $item['price'] ?>, 'images/uploads/<?= $item['image'] ?>')">
                                                        <?php } elseif ($item['status'] == "archived") { ?>
                                                        <div
                                                            class="overflow-hidden position-relative mw-100 card-rounded  cursor-pointer">
                                                            <?php }  ?>
                                                            <!--begin::Ribbon-->
                                                            <div class="ribbon ribbon-triangle ribbon-top-end border-primary"
                                                                style="display: none;">
                                                                <!--begin::Ribbon icon-->
                                                                <div class="ribbon-icon mt-n5 me-n6">
                                                                    <i class="bi bi-check2 fs-2 text-white"></i>
                                                                </div>
                                                                <!--end::Ribbon icon-->
                                                            </div>
                                                            <div class="card card-flush text-wrap p-6 pb-5 mw-100 h-100 overlay"
                                                                style="width: 250px;">
                                                                <!--begin::Body-->
                                                                <div class="card-body text-center overlay-wrapper">
                                                                    <!--begin::Food img-->
                                                                    <img src="images/uploads/<?= $item['image'] ?>"
                                                                        class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                        alt="" />
                                                                    <!--end::Food img-->
                                                                    <!--begin::Info-->
                                                                    <div class="mb-2">
                                                                        <!--begin::Title-->
                                                                        <div class="text-center">
                                                                            <span
                                                                                class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1"><?= $item['item_name'] ?></span>
                                                                            <span
                                                                                class="text-gray-400 fw-semibold d-block fs-6 mt-n1"><?= $item['description'] ?></span>
                                                                        </div>
                                                                        <!--end::Title-->
                                                                    </div>
                                                                    <!--end::Info-->
                                                                    <!--begin::Total-->
                                                                    <span
                                                                        class="text-success mt-auto fw-bold fs-1">P<?= $item['price'] ?></span>
                                                                    <!--end::Total-->
                                                                </div>
                                                                <!--end::Body-->
                                                                <?php if($item['status'] == "archived") {?>
                                                                <div class="overlay-layer card-rounded">
                                                                    <h1 class="bg-primary p-5 rounded-1"
                                                                        style="transform: rotate(-45deg);">NOT AVAILABLE
                                                                    </h1>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                            <!--end::Card-->
                                                        </div>
                                                        <?php } 
                                                    } 
                                                    $stmt_i->close();?>
                                                    </div>
                                                    <!--end::Wrapper-->
                                                </div>
                                                <!--end::Tap pane-->
                                                <?php
                                            $isFirstResult1 = false;
                                                }else {
                                            ?>
                                                <!--begin::Tap pane-->
                                                <div class="tab-pane fade show" id="<?= $category['category_id'] ?>">
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex flex-wrap align-content-start d-grid gap-3 gap-xxl-5 scroll pe-5"
                                                        data-kt-scroll="true"
                                                        data-kt-scroll-height="{default: '100px', lg: '700px'}">
                                                        <?php
                                                    $query_i = "SELECT * FROM items WHERE category_id = ?";
                                                    $stmt_i = $connection->prepare($query_i);
                                                    $stmt_i->bind_param("i", $category['category_id']);
                                                    $stmt_i->execute();
                                                    $result_i = $stmt_i->get_result();
                                                    
                                                    if($result_i->num_rows > 0){
                                                        while($item = $result_i->fetch_assoc()){
                                                    ?>
                                                        <!--begin::Ribbon wrapper 1-->
                                                        <div class="overflow-hidden position-relative mw-100 card-rounded cursor-pointer"
                                                            onclick="createDialer(this, <?= $item['item_id'] ?>, '<?= $item['item_name'] ?>', <?= $item['price'] ?>, 'images/uploads/<?= $item['image'] ?>')">
                                                            <!--begin::Ribbon-->
                                                            <div class="ribbon ribbon-triangle ribbon-top-end border-primary"
                                                                style="display: none;">
                                                                <!--begin::Ribbon icon-->
                                                                <div class="ribbon-icon mt-n5 me-n6">
                                                                    <i class="bi bi-check2 fs-2 text-white"></i>
                                                                </div>
                                                                <!--end::Ribbon icon-->
                                                            </div>
                                                            <div class="card card-flush text-wrap p-6 pb-5 mw-100 h-100"
                                                                style="width: 250px;">
                                                                <!--begin::Body-->
                                                                <div class="card-body text-center">
                                                                    <!--begin::Food img-->
                                                                    <img src="images/uploads/<?= $item['image'] ?>"
                                                                        class="rounded-3 mb-4 w-150px h-150px w-xxl-200px h-xxl-200px"
                                                                        alt="" />
                                                                    <!--end::Food img-->
                                                                    <!--begin::Info-->
                                                                    <div class="mb-2">
                                                                        <!--begin::Title-->
                                                                        <div class="text-center">
                                                                            <span
                                                                                class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1"><?= $item['item_name'] ?></span>
                                                                            <span
                                                                                class="text-gray-400 fw-semibold d-block fs-6 mt-n1"><?= $item['description'] ?></span>
                                                                        </div>
                                                                        <!--end::Title-->
                                                                    </div>
                                                                    <!--end::Info-->
                                                                    <!--begin::Total-->
                                                                    <span
                                                                        class="text-success text-end fw-bold fs-1">P<?= $item['price'] ?></span>
                                                                    <!--end::Total-->
                                                                </div>
                                                                <!--end::Body-->
                                                            </div>
                                                            <!--end::Card-->
                                                        </div>
                                                        <?php } 
                                                    } 
                                                    $stmt_i->close();?>
                                                    </div>
                                                    <!--end::Wrapper-->
                                                </div>
                                                <!--end::Tap pane-->
                                                <?php
                                            }}
                                            }
                                            ?>
                                            </div>
                                            <!--end::Tab Content-->
                                        </div>
                                        <!--end: Card Body-->
                                    </div>
                                    <!--end::Pos food-->
                                </div>
                                <!--end::Content-->
                                <!--begin::Sidebar-->
                                <div class="flex-row-auto w-xl-450px">
                                    <!--begin::Pos order-->
                                    <div class="card card-flush bg-body h-100" id="kt_pos_form">
                                        <!--begin::Header-->
                                        <div class="card-header pt-5">
                                            <h3 class="card-title fw-bold text-gray-800 fs-2qx">Current Order</h3>
                                            <!--begin::Toolbar-->
                                            <div class="card-toolbar">
                                                <button id="clear_all" disabled
                                                    class="btn btn-light-primary fs-4 fw-bold py-4">
                                                    Clear All
                                                </button>
                                            </div>
                                            <!--end::Toolbar-->
                                        </div>
                                        <!--end::Header-->
                                        <style>
                                        .table-responsive {
                                            max-height: 200px;
                                            overflow-y: auto;
                                        }
                                        </style>
                                        <!--begin::Body-->
                                        <div class="card card-body pt-0">
                                            <form action="#" id="add_order_form" class="form" autocomplete="off">
                                                <div class="d-flex gap-3 align-items-center mt-5 mb-5">
                                                    <!--begin::Option-->
                                                    <input type="radio" class="btn-check" name="order_method" checked
                                                        value="dine-in" id="kt_radio_buttons_2_option_1" />
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center"
                                                        for="kt_radio_buttons_2_option_1">
                                                        <i class="ki-duotone ki-arrow-down fs-2x me-4">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>

                                                        <span class="d-block fw-semibold text-start">
                                                            <span
                                                                class="text-gray-900 fw-bold d-block fs-3">DINE-IN</span>
                                                            <span class="text-muted fw-semibold fs-6">
                                                                This order is dine-in
                                                            </span>
                                                        </span>
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <input type="radio" class="btn-check" name="order_method"
                                                        value="take-out" id="kt_radio_buttons_2_option_2" />
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center"
                                                        for="kt_radio_buttons_2_option_2">
                                                        <i class="ki-duotone ki-arrow-up fs-2x me-4"><span
                                                                class="path1"></span><span class="path2"></span></i>

                                                        <span class="d-block fw-semibold text-start">
                                                            <span
                                                                class="text-gray-900 fw-bold d-block fs-3">TAKE-OUT</span>
                                                            <span class="text-muted fw-semibold fs-6">
                                                                This order is take-out
                                                            </span>
                                                        </span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--begin::Table container-->
                                                <div class="table-responsive h-300 mb-5">
                                                    <!--begin::Table-->
                                                    <table class="table align-middle gs-0 gy-4 my-0">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                            <tr>
                                                                <th class="min-w-160px"></th>
                                                                <th class="w-100px"></th>
                                                                <th class="w-30px"></th>
                                                            </tr>
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <!--begin::Table body-->
                                                        <tbody class="tbody scroll" id="table-item">
                                                        </tbody>
                                                        <!--end::Table body-->
                                                    </table>
                                                    <!--end::Table-->
                                                </div>
                                                <!--end::Table container-->
                                                <div class="separator border-light border-3 mb-5"></div>
                                                <div class="d-flex align-items-center mb-2 justify-content-between">
                                                    <label class="fw-semibold fs-6 mb-2">Discount</label>
                                                    <button type="button" class="btn btn-sm btn-primary mb-2"
                                                        id="add_discount_btn" disabled>
                                                        <i class="ki-duotone ki-plus fs-2"></i>Discount
                                                    </button>
                                                </div>
                                                <div id="discounts_content"></div>
                                                <input type="text" id="discount_total" name="discount_total" hidden>
                                                <input type="number" id="leftover_total" name="leftover_total" hidden>

                                                <!--begin::Input group-->
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="fv-row mb-7 flex-fill">
                                                        <!--begin::Label-->
                                                        <label class="fw-semibold fs-6 mb-2">Leftover</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" name="leftover" id="leftover" disabled
                                                            oninput="ComputeLeftover()"
                                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Leftover" />
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="position-relative d-flex align-items-center">
                                                        <button type="button" id="decLeftOBtn" disabled
                                                            onclick="decreaseLeftOButton()"
                                                            class="btn btn-icon btn-sm btn-light btn-icon-gray-400">
                                                            <i class="ki-duotone ki-minus fs-3x"></i>
                                                        </button>
                                                        <input type="text"
                                                            class="form-control leftover_qty border-0 text-center px-0 fs-3 fw-bold text-gray-800 w-30px"
                                                            name="leftover_qty" readonly="readonly" value="1">
                                                        <button type="button" id="incLeftOBtn"
                                                            onclick="increaseLeftOButton()" disabled
                                                            class="btn btn-icon btn-sm btn-light btn-icon-gray-400">
                                                            <i class="ki-duotone ki-plus fs-3x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Payment Method-->
                                                <div class="m-0">
                                                    <!--begin::Title-->
                                                    <h1 class="fw-bold text-gray-800 mb-5">
                                                        Payment Method
                                                    </h1>
                                                    <!--end::Title-->
                                                    <!--begin::Radio group-->
                                                    <div class="d-flex flex-equal gap-5 gap-xxl-9 px-0 mb-12"
                                                        data-kt-buttons="true"
                                                        data-kt-buttons-target="[data-kt-button]">
                                                        <!--begin::Radio-->
                                                        <label
                                                            class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4 "
                                                            data-kt-button="true">
                                                            <!--begin::Input-->
                                                            <input class="btn-check" type="radio" name="payment_method"
                                                                value="Gcash" />
                                                            <!--end::Input-->
                                                            <!--begin::Icon-->
                                                            <i class="ki-duotone ki-credit-cart fs-2hx mb-2 pe-0">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            <!--end::Icon-->
                                                            <!--begin::Title-->
                                                            <span class="fs-7 fw-bold d-block">GCash</span>
                                                            <!--end::Title-->
                                                        </label>
                                                        <!--end::Radio-->
                                                        <!--begin::Radio-->
                                                        <label
                                                            class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4 active"
                                                            data-kt-button="true">
                                                            <!--begin::Input-->
                                                            <input class="btn-check" type="radio" name="payment_method"
                                                                checked value="Cash" />
                                                            <!--end::Input-->
                                                            <!--begin::Icon-->
                                                            <i class="ki-duotone ki-dollar fs-2hx mb-2 pe-0">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                            <!--end::Icon-->
                                                            <!--begin::Title-->
                                                            <span class="fs-7 fw-bold d-block">Cash</span>
                                                            <!--end::Title-->
                                                        </label>
                                                        <!--end::Radio-->
                                                        <!--begin::Radio-->
                                                        <label
                                                            class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4"
                                                            data-kt-button="true">
                                                            <!--begin::Input-->
                                                            <input class="btn-check" type="radio" name="payment_method"
                                                                value="Maya" />
                                                            <!--end::Input-->
                                                            <!--begin::Icon-->
                                                            <i class="ki-duotone ki-bill fs-2hx mb-2 pe-0">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                                <span class="path5"></span>
                                                                <span class="path6"></span>
                                                            </i>
                                                            <!--end::Icon-->
                                                            <!--begin::Title-->
                                                            <span class="fs-7 fw-bold d-block">MAYA</span>
                                                            <!--end::Title-->
                                                        </label>
                                                        <!--end::Radio-->
                                                    </div>
                                                    <!--end::Radio group-->
                                                </div>
                                                <!--end::Payment Method-->
                                                <!--begin::Summary-->
                                                <div class="d-flex flex-stack bg-success rounded-3 p-6 mb-11">
                                                    <!--begin::Content-->
                                                    <div class="fs-6 fw-bold text-white">
                                                        <span class="d-block lh-1 mb-2">Subtotal</span>
                                                        <span class="d-block lh-1 mb-2">Leftover</span>
                                                        <span class="d-block lh-1 mb-4">Discount</span>
                                                        <!-- <span class="d-block mb-9">Tax(12%)</span> -->
                                                        <span class="d-block fs-2qx lh-1 mb-9">Total</span>
                                                        <span class="d-block lh-1 mb-2">Cash</span>
                                                        <span class="d-block mb-2">Change</span>
                                                    </div>
                                                    <!--end::Content-->
                                                    <!--begin::Content-->
                                                    <div class="fs-6 fw-bold text-white text-end">
                                                        <span id="totalDisplay" class="d-block lh-1 mb-2">₱100.50</span>
                                                        <span id="leftoverDisplay" class="d-block lh-1 mb-2">+
                                                            ₱0.00</span>
                                                        <span id="discountDisplay" class="d-block lh-1 mb-4">-
                                                            ₱0.00</span>
                                                        <!-- <span class="d-block mb-9" data-kt-pos-element="tax">₱11.20</span> -->
                                                        <span class="d-block fs-2qx lh-1 mb-9"
                                                            id="grandTotalDisplay"></span>
                                                        <span id="cash_span" class="d-block lh-1 mb-2">-</span>
                                                        <span id="customerChange" class="d-block mb-2">-</span>
                                                    </div>
                                                    <!--end::Content-->
                                                    <input type="number" hidden name="grand_total" id="grand_total">
                                                </div>
                                                <!--end::Summary-->
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">Customer
                                                        Cash</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="customer_cash" id="customer_cash"
                                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                                        placeholder="Customer Cash" disabled />
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <input type="number" name="change" id="change_input" hidden>
                                                <!--begin::Actions-->
                                                <button id="save_order_button" type="submit" disabled
                                                    class="btn btn-primary fs-1 w-100 py-4 bottom-0">
                                                    <span class="indicator-label">
                                                        Save Order
                                                    </span>
                                                    <span class="indicator-progress">
                                                        Please wait... <span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                                <!--end::Actions-->
                                            </form>
                                        </div>
                                        <!--end: Card Body-->
                                    </div>
                                    <!--end::Pos order-->
                                </div>
                                <!--end::Sidebar-->
                            </div>
                            <!--end::Layout-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Content-->
                    <?php include("templates/_edititem.php") ?>
                    <!--begin::Footer-->
                    <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                        <!--begin::Container-->
                        <div class="container-fluid d-flex flex-column flex-md-row flex-stack">
                            <!--begin::Copyright-->
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-gray-400 fw-semibold me-1">Created by</span>
                                <a href="" target="_blank"
                                    class="text-muted text-hover-primary fw-semibold me-2 fs-6">BSIT
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
        <!-- assets/js/custom/scripts/pos.js -->
        <script src="assets/js/custom/scripts/discount.js"></script>
        <script src="assets/js/custom/scripts/pos.js"></script>
        <script src="assets/js/custom/scripts/leftover.js"></script>
        <script src="assets/js/custom/scripts/menu_item.js"></script>
        <script src="assets/js/custom/scripts/image-input.js"></script>
        <!--end::Global Javascript Bundle-->
        <!--begin::Vendors Javascript(used for this page only)-->
        <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
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