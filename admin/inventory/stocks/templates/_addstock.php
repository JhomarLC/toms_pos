<div class="modal fade" tabindex="-1" id="add_stock_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add new Stock</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">

                </div>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" id="close_stock_modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <form action="#" id="add_stock_form" class="form" autocomplete="off">
                    <!--begin::Solid input group style-->
                    <label class="required fw-semibold fs-6 mb-2">Category</label>
                    <div class="fv-row mb-7">
                        <div class="input-group input-group-solid flex-nowrap">
                            <span class="input-group-text">
                                <i class="ki-duotone ki-notepad-bookmark fs-3"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                        class="path5"></span><span class="path6"></span></i>
                            </span>
                            <div class="overflow-hidden flex-grow-1">
                                <select class="form-select form-select-solid rounded-start-0 border-start"
                                    data-control="select2" name="stock_category" data-dropdown-parent="#add_stock_modal"
                                    data-placeholder="Select an option">
                                    <option></option>
                                    <option value="Chicken">Chicken</option>
                                    <option value="Isaw">Isaw</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Delivery Today</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="delivery_today" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Delivery Today" />
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
                            <input type="text" class="form-control form-control-solid" name="total_out"
                                placeholder="Total Out" />
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--end::Solid input group style-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="clear_stock_form">Close</button>
                        <!--begin::Actions-->
                        <button id="add_stock_submit" type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Add Stock
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