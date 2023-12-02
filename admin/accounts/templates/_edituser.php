<div class="modal fade" tabindex="-1" id="kt_modal_2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Staff Account</h3>
                <!--begin::Close-->
                <div class="btn edit btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                </div>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" id="close_modal1">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <form action="#" id="edit_staff_form" class="form" autocomplete="off">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Full
                            Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input hidden type="number" name="staff_id" id="staff_id"
                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" />
                        <input type="text" name="full_name" id="full_name"
                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Username</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="current_username" id="current_username" hidden>
                        <input type="text" name="username" id="username"
                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Username" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Email</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="email" name="email" id="email" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="example@domain.com" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="d-flex gap-3 align-items-center justify-content-center mb-5">
                        <!--begin::Option-->
                        <input type="radio" class="btn-check status" name="status" value="Active"
                            id="kt_radio_buttons_2_option_1" />
                        <label
                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center"
                            for="kt_radio_buttons_2_option_1">
                            <i class="ki-duotone ki-check-circle fs-2x me-4"><span class="path1"></span><span
                                    class="path2"></span></i>

                            <span class="d-block fw-semibold text-start">
                                <span class="text-gray-900 fw-bold d-block fs-3">Active</span>
                                <span class="text-muted fw-semibold fs-6">
                                    This staff is active
                                </span>
                            </span>
                        </label>
                        <!--end::Option-->

                        <!--begin::Option-->
                        <input type="radio" class="btn-check status" name="status" value="Inactive"
                            id="kt_radio_buttons_2_option_2" />
                        <label
                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center"
                            for="kt_radio_buttons_2_option_2">
                            <i class="ki-duotone ki-cross-circle fs-2x me-4"><span class="path1"></span><span
                                    class="path2"></span></i>

                            <span class="d-block fw-semibold text-start">
                                <span class="text-gray-900 fw-bold d-block fs-3">INACTIVE</span>
                                <span class="text-muted fw-semibold fs-6">This staff is inactive</span>
                            </span>
                        </label>
                        <!--end::Option-->
                    </div>
                    <div class="separator my-2"></div>
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold fs-6 mb-2">New Password</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password" name="password" id="password"
                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Password" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold fs-6 mb-2">Confirm
                            Password</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password" name="cpassword" id="cpassword"
                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Confirm Password" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="clear_staff_form_edit">Close</button>
                        <!--begin::Actions-->
                        <button id="update_staff_submit" type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Update Staff Account
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Actions-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>