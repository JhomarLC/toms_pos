<div class="modal fade" tabindex="-1" id="edit_category_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Category</h3>
                <!--begin::Close-->
                <div class="btn edit btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                </div>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" id="close_edit_modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <form action="#" id="edit_category_form" class="form" autocomplete="off">
                    <input type="number" name="category_id_edit" hidden />
                    <input type="text" name="image_old_edit" hidden>
                    <!--begin::Input group-->
                    <div class=" mb-7">
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
                            <div class="image-input-wrapper w-125px h-125px edit-image">
                            </div>
                            <!--end::Preview existing avatar-->
                            <!--begin::Label-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change Image">
                                <i class="ki-duotone ki-pencil fs-7">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <!--begin::Inputs-->
                                <input type="file" name="category_image_edit" id="category_image_edit"
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
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Category Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="category_name_edit"
                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Category Name" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="clear_category_form_edit">Close</button>
                        <!--begin::Actions-->
                        <button id="edit_category_submit" type="submit" class="btn btn-primary">
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