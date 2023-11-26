<div class="modal fade" tabindex="-1" id="add_expense_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add new Expense</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">

                </div>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" id="close_expense_modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <form action="#" id="add_expense_form" class="form" autocomplete="off">
                    <!--begin::Solid input group style-->
                    <label class="required fw-semibold fs-6 mb-2">Select Expense Name</label>
                    <div class="fv-row mb-7">
                        <div class="input-group input-group-solid flex-nowrap">
                            <span class="input-group-text">
                                <i class="ki-duotone ki-notepad-bookmark fs-3"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                        class="path5"></span><span class="path6"></span></i>
                            </span>
                            <div class="overflow-hidden flex-grow-1">
                                <select class="form-select form-select-solid rounded-start-0 border-start"
                                    data-control="select2" name="expense_name_dd" id="expense_name_dd"
                                    data-dropdown-parent="#add_expense_modal" data-placeholder="Select an option"
                                    onchange="ChangeCategory()">
                                    <option></option>
                                    <?php 
                                    $query = "SELECT * FROM expense_category";
                                    $stmt = $connection->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if($result->num_rows > 0){
                                        while($expense = $result->fetch_assoc()){
                                            ?>
                                    <option value="<?= $expense['category_expense_name'] ?>">
                                        <?= $expense['category_expense_name']?>
                                    </option>
                                    <?php
                                        }
                                    } 
                                    $stmt->close();
                                    ?>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--begin::Input group-->
                    <div id="expense-name-group" class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Expense Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="expense_name" class="form-control form-control-solid mb-3 mb-lg-0"
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
                            <input type="text" class="form-control form-control-solid" name="amount"
                                placeholder="Amount" />
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--end::Solid input group style-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="clear_expense_form">Close</button>
                        <!--begin::Actions-->
                        <button id="add_expense_submit" type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Add Expense
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