<div class="modal fade" tabindex="-1" id="edit_voucher_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Discount</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" id="close_edit_modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <form action="#" id="edit_voucher_form" class="form" autocomplete="off">
                    <input type="number" name="voucher_id_edit" hidden />
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Discount Code</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="voucher_code_edit" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Discount Code" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Discount Percent</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="voucher_percent_edit"
                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Discount Percent" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="clear_voucher_form_edit">Close</button>
                        <!--begin::Actions-->
                        <button id="edit_voucher_submit" type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Update Discount
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