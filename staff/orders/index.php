<?php
    session_start();
    require("../../controllers/db_connection.php");
    date_default_timezone_set('Asia/Manila');
    
    if(isset($_COOKIE['account_signed_in'])){
        $user = json_decode($_COOKIE['account_signed_in'], true);
        if($user['role'] == "Admin"){
            header("Location: ../../other/illegal_access/admin.php");
        }
    } else {
        header("Location: ../../");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../../" />
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
        require("../../other/message.php");
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
                                            placeholder="Search Order" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--begin::Card title-->
                                <!--begin::Card toolbar-->
                                <!-- <div class="card-toolbar">
                                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#add_item_modal">
                                            <i class="ki-duotone ki-plus fs-2"></i>Add Item
                                        </button>
                                    </div>
                                </div> -->
                                <!--end::Card toolbar-->
                            </div>
                            <?php //include("templates/_additem.php") ?>

                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body py-4">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_items">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Order ID</th>
                                            <th class="min-w-125px">Order Date</th>
                                            <th class="min-w-125px">Order Method</th>
                                            <th class="min-w-125px">Payment Method</th>
                                            <th class="min-w-125px">Cash</th>
                                            <th class="min-w-125px">Change</th>
                                            <th class="min-w-125px">Total</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        <?php
                                        $user_id = $user['account_id'];
								$query = "SELECT o.*, a.full_name FROM orders as o
                                INNER JOIN accounts as a ON o.account_id = a.account_id WHERE a.account_id = ? ORDER BY order_date DESC ";
                                $stmt = $connection->prepare($query);
                                $stmt->bind_param("i", $user_id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                    
                                $num = 0;
                                $currentDate = date("M d, Y");
                                if($result->num_rows > 0){
                                    while($order = $result->fetch_assoc()){
                                        $order_date = date("M d, Y | h:i:s A", strtotime($order['order_date']));
                                        $order_date_wt = date("M d, Y", strtotime($order['order_date']));
                                        $isCurrentDate = ($currentDate == $order_date_wt);
                                        ?>
                                        <tr>
                                            <td>
                                                <?php if($order['status'] == "refunded"){ ?>
                                                <div class="badge badge-light-danger fw-bold">
                                                    <?= $order['order_id'] ?>
                                                </div>
                                                <?php } else { ?>
                                                <div class="badge badge-light-success fw-bold">
                                                    <?= $order['order_id'] ?>
                                                </div>
                                                <?php } ?>
                                            </td>
                                            <td><?= $order_date ?></td>
                                            <td>
                                                <?php if($order['status'] == "refunded"){ ?>
                                                <div class="badge badge-light-danger fw-bold">
                                                    <?= $order['order_method'] ?>
                                                </div>
                                                <?php } else { ?>
                                                <div class="badge badge-light-success fw-bold">
                                                    <?= $order['order_method'] ?>
                                                </div>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($order['status'] == "refunded"){ ?>
                                                <div class="badge badge-light-danger fw-bold">
                                                    <?= $order['payment_method'] ?>
                                                </div>
                                                <?php } else { ?>
                                                <div class="badge badge-light-success fw-bold">
                                                    <?= $order['payment_method'] ?>
                                                </div>
                                                <?php } ?>
                                            </td>
                                            <td>P<?= $order['cash'] ?></td>
                                            <td>P<?= $order['change_amount'] ?></td>
                                            <td>P<?= $order['total'] ?></td>
                                            <td class="d-flex gap-2 text-end">
                                                <!--begin::Edit user-->
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="ViewOrder('<?= $order['order_id'] ?>')">
                                                    <i class="ki-duotone ki-notepad fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>View
                                                </button>
                                                <!--end::Edit user-->
                                                <!--begin::Print order-->
                                                <?php if($order['status'] != "refunded" && $isCurrentDate){ ?>
                                                <form action="staff/print/" method="post" target="_blank">
                                                    <input type="hidden" name="order_id"
                                                        value="<?= $order['order_id']?>">
                                                    <input type="hidden" name="order_date"
                                                        value="<?= $order['order_date']?>">
                                                    <button type="submit" class="btn btn-sm btn-info">
                                                        <i class="ki-duotone ki-printer fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                            <span class="path5"></span>
                                                        </i>Print
                                                    </button>
                                                </form>
                                                <!--begin::Print order-->
                                                <!--begin::Refund order-->
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="RefundOrder('<?= $order['order_id'] ?>')">
                                                    <i class="ki-duotone ki-notepad fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>Refund
                                                </button>
                                                <!--end::Refund order-->
                                                <?php } else { ?>
                                                <button type="submit" class="btn btn-sm btn-light-info" disabled>
                                                    <i class="ki-duotone ki-printer fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>Print
                                                </button>
                                                <!--begin::Print order-->
                                                <!--begin::Refund order-->
                                                <button type="button" class="btn btn-sm btn-light-danger" disabled>
                                                    <i class="ki-duotone ki-notepad fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>Refund
                                                </button>
                                                <!--end::Refund order-->
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } 
                                        $stmt->close();
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
                <?php include("templates/_vieworder.php") ?>
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
    <!-- assets/js/custom/scripts/pos.js -->
    <script src="assets/js/custom/scripts/orders.js"></script>
    <script src="assets/js/custom/scripts/discount.js"></script>
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