 
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <!-- <b>Version</b> 2.4.18 -->
    </div>
    <strong>Copyright &copy; 2021 <a href="https://mplussoft.com/" target="_blank">Mplussoft</a>.</strong> All rights
    reserved.

    <div class="modal fade" id="imageFileManagerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg modal-file-manager" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Images</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="file-manager">
                        <div class="file-manager-left">
                            <div class="dm-uploader-container">
                                <div id="drag-and-drop-zone-file-manager" class="dm-uploader text-center">
                                    <p class="file-manager-file-types">
                                        <span>JPG</span>
                                        <span>JPEG</span>
                                        <span>PNG</span>
                                    </p>
                                    <p class="dm-upload-icon">
                                        <i class="fa fa-cloud-upload"></i>
                                    </p>
                                    <p class="dm-upload-text">Drag and drop images here or</p>
                                    <p class="text-center">
                                        <button class="btn btn-default btn-browse-files">Browse Files</button>
                                    </p>
                                    <a class="btn btn-md dm-btn-select-files">
                                        <input type="file" name="file" size="40" multiple="">
                                    </a>
                                    <ul class="dm-uploaded-files" id="files-file-manager"></ul>
                                    <button type="button" id="btn_reset_upload_image" class="btn btn-reset-upload">Reset</button>
                                </div>
                            </div>
                        </div>
                        <div class="file-manager-right">
                            <div class="file-manager-content">
                                <div id="image_file_manager_upload_response">

                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="selected_file_manager_img_id" value="">
                        <input type="hidden" id="selected_file_manager_img_path" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="file-manager-footer">
                        <button type="button" id="btn_file_manager_delete" class="btn btn-sm btn-danger color-white pull-left btn-file-delete" style="display: none;"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</button>
                        <button type="button" id="btn_file_manager_select" class="btn btn-sm btn-success color-white btn-file-select" style="display: none;"><i class="fa fa-check"></i>&nbsp;&nbsp;Select Image</button>
                        <button type="button" class="btn btn-sm btn-default color-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
