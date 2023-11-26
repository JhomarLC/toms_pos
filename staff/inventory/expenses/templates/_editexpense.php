<div class="modal fade" tabindex="-1" id="edit_expense_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Expense</h3>
                <!--begin::Close-->
                <div class="btn edit btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                </div>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" id="close_edit_modal_expense">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <form action="#" id="edit_expense_form" class="form" autocomplete="off">
                    <input type="number" name="expense_id" hidden>
                    <div id="expense-name-group-edit" class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Expense Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="expense_name_edit" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Expense Name" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <!--begin::Label-->
                    <label class="required fw-semibold fs-6 mb-2">Amount</label>
                    <!--end::Label-->
                    <div class="fv-row">
                        <div class="input-group input-group-solid mb-7">
                            <!--begin::Input-->
                            <span class="input-group-text">
                                <i class="ki-duotone ki-price-tag fs-2"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                            </span>
                            <input type="text" class="form-control form-control-solid" name="amount_edit"
                                placeholder="Amount" />
                        </div>
                    </div>
                    <!--end::Input group-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="clear_expense_form_edit">Close</button>
                        <!--begin::Actions-->
                        <button id="edit_expense_submit" type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Update Expense
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