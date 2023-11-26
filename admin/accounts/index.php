<?php
    session_start();
    require("../../controllers/db_connection.php");

    if(isset($_COOKIE['account_signed_in'])){
        $user = json_decode($_COOKIE['account_signed_in'], true);
        if($user['role'] == "Staff"){
            header("Location: ../../other/illegal_access/staff.php");
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
    <script>
    // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
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
                                        <input type="text" data-kt-user-table-filter="search"
                                            class="form-control form-control-solid w-250px ps-13"
                                            placeholder="Search Staff" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--begin::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Toolbar-->
                                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                        <!--begin::Filter-->
                                        <!-- <button
									type="button"
									class="btn btn-light-primary me-3"
									data-kt-menu-trigger="click"
									data-kt-menu-placement="bottom-end"
								>
									<i class="ki-duotone ki-filter fs-2">
									<span class="path1"></span>
									<span class="path2"></span> </i
									>Filter
								</button> -->
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                            data-kt-menu="true">
                                            <!--begin::Header-->
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bold">
                                                    Filter Options
                                                </div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Separator-->
                                            <div class="separator border-gray-200"></div>
                                            <!--end::Separator-->
                                            <!--begin::Content-->
                                            <div class="px-7 py-5" data-kt-user-table-filter="form">
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <label class="form-label fs-6 fw-semibold">Status:</label>
                                                    <select class="form-select form-select-solid fw-bold"
                                                        data-kt-select2="true" data-placeholder="Select option"
                                                        data-allow-clear="true" data-kt-user-table-filter="status"
                                                        data-hide-search="true">
                                                        <option></option>
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                    </select>
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Actions-->
                                                <div class="d-flex justify-content-end">
                                                    <button type="reset"
                                                        class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                                        data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">
                                                        Reset
                                                    </button>
                                                    <button type="submit" class="btn btn-primary fw-semibold px-6"
                                                        data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">
                                                        Apply
                                                    </button>
                                                </div>
                                                <!--end::Actions-->
                                            </div>
                                            <!--end::Content-->
                                        </div>
                                        <!--end::Menu 1-->
                                        <!--end::Filter-->

                                        <!--begin::Add user-->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_1">
                                            <i class="ki-duotone ki-plus fs-2"></i>Add Staff
                                        </button>
                                        <!--end::Add user-->
                                    </div>
                                    <!--end::Toolbar-->
                                    <!--begin::Group actions-->
                                    <div class="d-flex justify-content-end align-items-center d-none"
                                        data-kt-user-table-toolbar="selected">
                                        <div class="fw-bold me-5">
                                            <span class="me-2"
                                                data-kt-user-table-select="selected_count"></span>Selected
                                        </div>
                                        <button type="button" class="btn btn-danger"
                                            data-kt-user-table-select="delete_selected">
                                            Delete Selected
                                        </button>
                                    </div>
                                    <!--end::Group actions-->
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
                                    <?php 
                                    if(isset($_COOKIE['correct_values'])){
                                        $account = json_decode($_COOKIE['correct_values'], true);
                                    } 
                                    ?>

                                    <!--begin::Modal - Add task-->
                                    <?php include("templates/_adduser.php") ?>

                                    <!--end::Modal - Add task-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body py-4">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Name</th>
                                            <th class="min-w-125px">Username</th>
                                            <th class="min-w-125px">Email</th>
                                            <th class="min-w-125px">Status</th>
                                            <th class="min-w-125px">Account Created</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        <?php
								$acc_query = "SELECT account_id, full_name, username, email, role, status, created_at FROM accounts WHERE account_id != ? ORDER BY created_at DESC";
								$acc_stmt = $connection->prepare($acc_query);
								$acc_stmt->bind_param("i", $user['account_id']);
								$acc_stmt->execute();
								$acc_result = $acc_stmt->get_result();
					 
								$num = 0;
								if($acc_result->num_rows > 0){
									while($accounts = $acc_result->fetch_assoc()){
										$acc_created_at = date("M d, Y | h:i:s A", strtotime($accounts['created_at']));
								?>
                                        <tr>
                                            <td><?= $accounts['full_name'] ?></td>
                                            <td>
                                                <div class="badge badge-light fw-bold"><?= $accounts['username'] ?>
                                                </div>
                                            </td>
                                            <td><?= $accounts['email'] ?></td>
                                            <td>
                                                <?php if ($accounts['status'] == "Active"){ ?>
                                                <div class="badge badge-light-success fw-bold">Active</div>
                                                <?php } elseif ($accounts['status'] == "Inactive"){ ?>
                                                <div class="badge badge-light-danger fw-bold">Inactive</div>
                                                <?php } ?>
                                            </td>
                                            <td><?= $acc_created_at ?></td>
                                            <td class="text-end">
                                                <!--begin::Edit user-->
                                                <button type="button" class="btn btn-sm btn-success"
                                                    onclick="GetEditValue(<?= $accounts['account_id'] ?>)">
                                                    <i class="ki-duotone ki-pencil fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>Edit
                                                </button>
                                                <!--end::Edit user-->

                                            </td>
                                        </tr>
                                        <?php }
								}
								?>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->
                <?php include("templates/_edituser.php") ?>
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
    <script src="assets/js/custom/scripts/staffs.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="assets/plugins/custom/vis-timeline/vis-timeline.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="assets/js/custom/apps/user-management/users/list/table.js"></script>
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