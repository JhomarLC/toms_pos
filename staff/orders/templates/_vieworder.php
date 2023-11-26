<div class="modal fade" tabindex="-1" id="view_order_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header my-auto">
                <div class="d-flex align-items-center flex-column">
                    <h3 class="modal-title mt-4" id="order_id_code"></h3>
                    <p class="badge badge-light-primary fw-bold" id="order_date_time"></p>
                </div>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" id="close_order_modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <form action="#" id="edit_item_form" class="form" autocomplete="off">
                    <div class="container">
                        <div id="order_items"></div>
                        <div id="total_summary"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" id="clear_order_form_view">Close</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>