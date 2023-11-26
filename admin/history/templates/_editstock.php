<div class="modal fade" tabindex="-1" id="edit_stock_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Stock</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" id="close_edit_modal_stock">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <form action="#" id="edit_stock_form" class="form" autocomplete="off">
                    <input type="number" name="stock_id_edit" hidden>
                    <input type="text" name="stock_category_edit" hidden>
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Delivery Today</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="delivery_today_edit"
                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Delivery Today" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <!--begin::Label-->
                    <label class="required fw-semibold fs-6 mb-2">Total Out</label>
                    <!--end::Label-->
                    <div class="fv-row">
                        <div class="input-group input-group-solid mb-7">
                            <!--begin::Input-->
                            <span class="input-group-text">
                                <i class="ki-duotone ki-price-tag fs-2"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                            </span>
                            <input type="text" class="form-control form-control-solid" name="total_out_edit"
                                placeholder="Total Out" />
                        </div>
                    </div>
                    <!--begin::Label-->
                    <label class="required fw-semibold fs-6 mb-2">Price</label>
                    <!--end::Label-->
                    <div class="fv-row">
                        <div class="input-group input-group-solid mb-7">
                            <!--begin::Input-->
                            <span class="input-group-text">
                                <i class="ki-duotone ki-price-tag fs-2"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                            </span>
                            <input type="text" class="form-control form-control-solid" name="price_edit"
                                placeholder="Price" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="clear_stock_form_edit">Close</button>
                        <!--begin::Actions-->
                        <button id="edit_stock_submit" type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Update Stock
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