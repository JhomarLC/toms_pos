<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add New Staff Account</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">

                </div>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" id="close_modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <form action="#" id="add_staff_form" class="form" autocomplete="off">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Full
                            Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="full_name" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Full name" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Username</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="username" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Username" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Email</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="example@domain.com" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Password</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password" name="password" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Password" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Confirm
                            Password</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password" name="cpassword" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Confirm Password" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="clear_staff_form">Close</button>
                        <!--begin::Actions-->
                        <button id="add_staff_submit" type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Add Staff
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