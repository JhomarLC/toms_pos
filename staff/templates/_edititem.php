<div class="modal fade" tabindex="-1" id="edit_item_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Item</h3>
                <!--begin::Close-->
                <div class="btn edit btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                </div>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" id="close_edit_modal_item">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <form action="#" id="edit_item_form" class="form" autocomplete="off">
                    <!--begin::Input group-->
                    <div class="mb-7">
                        <!--begin::Image placeholder-->
                        <label class="d-flex align-items-center fw-semibold fs-6 mb-2">
                            <span>Image</span>
                            <span class="ms-1" data-bs-toggle="tooltip"
                                title="You can leave this empty to set the image into default one">
                                <i class="ki-duotone ki-information-5 text-gray-500 fs-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                        </label>
                        <style>
                        .image-input-placeholder {
                            background-image: url("assets/media/svg/files/blank-image.svg");
                        }

                        [data-bs-theme="dark"] .image-input-placeholder {
                            background-image: url("assets/media/svg/files/blank-image-dark.svg");
                        }
                        </style>
                        <!--end::Image placeholder-->
                        <!--begin::Image input-->
                        <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                            <!--begin::Preview existing avatar-->
                            <div class="image-input-wrapper edit-image w-125px h-125px"></div>
                            <!--end::Preview existing avatar-->
                            <!--begin::Label-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change">
                                <i class="ki-duotone ki-pencil fs-7">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <!--begin::Inputs-->
                                <input type="file" name="item_image_edit" id="item_image_edit"
                                    accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Label-->
                            <!--begin::Cancel-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel Image">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <!--end::Cancel-->
                            <!--begin::Remove-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove Image">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <!--end::Remove-->
                        </div>
                        <!--end::Image input-->
                        <!--begin::Hint-->
                        <div class="form-text">
                            Allowed
                            file
                            types:
                            png,
                            jpg,
                            jpeg.
                        </div>
                        <!--end::Hint-->
                    </div>
                    <!--end::Input group-->
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
                                    data-control="select2" name="category_id_edit" id="category_id_edit"
                                    data-dropdown-parent="#edit_item_modal" data-placeholder="Select an option">
                                    <option></option>
                                    <?php 
                                $query = "SELECT * FROM category";
                                $stmt = $connection->prepare($query);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if($result->num_rows > 0){
                                    while($category = $result->fetch_assoc()){
                                        ?>
                                    <option id="opt<?= $category['category_id'] ?>"
                                        value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?>
                                    </option>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <option value="" disabled>No Category to Show</option>
                                    <?php
                                }
                                $stmt->close();
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Item Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number" name="item_id_edit" hidden>
                        <input type="text" name="image_old_edit" hidden>
                        <input type="text" name="item_name_edit" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Category Name" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
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

                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Description</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea class="form-control form-control-solid mb-3 mb-lg-0" name="description_edit"
                            data-kt-autosize="true" placeholder="Description"></textarea>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="clear_item_form_edit">Close</button>
                        <!--begin::Actions-->
                        <button id="edit_item_submit" type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Update Category
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