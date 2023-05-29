<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-info" id="exampleModalLabel"><strong>Thay đổi thông tin danh mục</strong></h3>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateCategoryForm">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="col-form-label"><h6>Tên danh mục: </h6></label>
                        <input type="hidden" name="updateId">
                        <input type="text" class="form-control" name="name">
                        <span class="text-danger small" id="error_update_name"></span>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại bảng</button>
                    <button type="button" class="btn btn-info" id="buttonUpdate">Lưu những thay đổi?</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>