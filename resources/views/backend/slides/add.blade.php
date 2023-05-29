<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-success" id="exampleModalLabel"><strong>Thêm slides để trình chiếu</strong></h3>
            </div>
            <div class="modal-body">
            <form method="POST" id="createForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="confirmPasswordDelete" class="col-form-label"><h6>Tải ảnh lên</h6></label>
                    <input type="file" class="form-control" name="image[]" multiple>
                    <span class="text-danger small" id="error_image"></span>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại bảng</button>
                <button type="button" class="btn btn-success" id="buttonCreate">Nhấn để thêm</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>