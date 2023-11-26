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
                        <!--begin::List Widget 5-->
                        <div class="card mb-5 mb-xl-8">
                            <!--begin::Header-->
                            <div class="card-header align-items-center border-0 mt-4">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="fw-bold mb-2 text-dark">Activities</span>
                                    <span class="text-muted fw-semibold fs-7">890,344 Sales</span>
                                </h3>
                                <div class="card-toolbar">
                                    <!--begin::Menu-->
                                    <button type="button"
                                        class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="ki-duotone ki-category fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <!--begin::Menu 1-->
                                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                        id="kt_menu_64b785078d292">
                                        <!--begin::Header-->
                                        <div class="px-7 py-5">
                                            <div class="fs-5 text-dark fw-bold">
                                                Filter Options
                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Menu separator-->
                                        <div class="separator border-gray-200"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Form-->
                                        <div class="px-7 py-5">
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fw-semibold">Status:</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div>
                                                    <select class="form-select form-select-solid" multiple="multiple"
                                                        data-kt-select2="true" data-close-on-select="false"
                                                        data-placeholder="Select option"
                                                        data-dropdown-parent="#kt_menu_64b785078d292"
                                                        data-allow-clear="true">
                                                        <option></option>
                                                        <option value="1">Approved</option>
                                                        <option value="2">Pending</option>
                                                        <option value="2">In Process</option>
                                                        <option value="2">Rejected</option>
                                                    </select>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fw-semibold">Member Type:</label>
                                                <!--end::Label-->
                                                <!--begin::Options-->
                                                <div class="d-flex">
                                                    <!--begin::Options-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" value="1" />
                                                        <span class="form-check-label">Author</span>
                                                    </label>
                                                    <!--end::Options-->
                                                    <!--begin::Options-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="2"
                                                            checked="checked" />
                                                        <span class="form-check-label">Customer</span>
                                                    </label>
                                                    <!--end::Options-->
                                                </div>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fw-semibold">Notifications:</label>
                                                <!--end::Label-->
                                                <!--begin::Switch-->
                                                <div
                                                    class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        name="notifications" checked="checked" />
                                                    <label class="form-check-label">Enabled</label>
                                                </div>
                                                <!--end::Switch-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Actions-->
                                            <div class="d-flex justify-content-end">
                                                <button type="reset"
                                                    class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                    data-kt-menu-dismiss="true">
                                                    Reset
                                                </button>
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    data-kt-menu-dismiss="true">
                                                    Apply
                                                </button>
                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Menu 1-->
                                    <!--end::Menu-->
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-5">
                                <!--begin::Timeline-->
                                <div class="timeline-label">
                                    <?php
								$query = "SELECT al.*, a.full_name FROM activitylog as al INNER JOIN accounts as a ON al.account_id = a.account_id ORDER BY activity_date DESC LIMIT 5";
                                $stmt = $connection->prepare($query);
                                $stmt->execute();
                                $result = $stmt->get_result();
                    
                                $num = 0;
                                if($result->num_rows > 0){
                                    while($log = $result->fetch_assoc()){
                                        $formattedTime = date('H:i', strtotime($log['activity_date']));
                                        ?>
                                    <!--begin::Item-->
                                    <div class="timeline-item">
                                        <!--begin::Label-->
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">
                                            <?= $formattedTime; ?>
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-warning fs-1"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Text-->
                                        <div class="fw-mormal timeline-content ps-3">
                                            <?= $log['full_name'] ?> <span
                                                class="badge badge-primary"><?= $log['activity_description'] ?></span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <?php 
                                    }}
                                    ?>
                                    <!--begin::Item-->
                                    <div class="timeline-item">
                                        <!--begin::Label-->
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">
                                            10:00
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-success fs-1"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Content-->
                                        <div class="timeline-content d-flex">
                                            <span class="fw-bold text-gray-800 ps-3">AEOL meeting</span>
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="timeline-item">
                                        <!--begin::Label-->
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">
                                            14:37
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-danger fs-1"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Desc-->
                                        <div class="timeline-content fw-bold text-gray-800 ps-3">
                                            Make deposit
                                            <a href="#" class="text-primary">USD 700</a>. to ESL
                                        </div>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="timeline-item">
                                        <!--begin::Label-->
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">
                                            16:50
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-primary fs-1"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Text-->
                                        <div class="timeline-content fw-mormal text-muted ps-3">
                                            Indulging in poorly driving and keep structure keep
                                            great
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="timeline-item">
                                        <!--begin::Label-->
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">
                                            21:03
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-danger fs-1"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Desc-->
                                        <div class="timeline-content fw-semibold text-gray-800 ps-3">
                                            New order placed
                                            <a href="#" class="text-primary">#XF-2356</a>.
                                        </div>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="timeline-item">
                                        <!--begin::Label-->
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">
                                            16:50
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-primary fs-1"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Text-->
                                        <div class="timeline-content fw-mormal text-muted ps-3">
                                            Indulging in poorly driving and keep structure keep
                                            great
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="timeline-item">
                                        <!--begin::Label-->
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">
                                            21:03
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-danger fs-1"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Desc-->
                                        <div class="timeline-content fw-semibold text-gray-800 ps-3">
                                            New order placed
                                            <a href="#" class="text-primary">#XF-2356</a>.
                                        </div>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="timeline-item">
                                        <!--begin::Label-->
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">
                                            10:30
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Badge-->
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless text-success fs-1"></i>
                                        </div>
                                        <!--end::Badge-->
                                        <!--begin::Text-->
                                        <div class="timeline-content fw-mormal text-muted ps-3">
                                            Finance KPI Mobile app launch preparion meeting
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Timeline-->
                            </div>
                            <!--end: Card Body-->
                        </div>
                        <!--end: List Widget 5-->
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