<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-success" id="exampleModalLabel"><strong>Thêm danh mục sản phẩm</strong></h3>
            </div>
            <div class="modal-body">
            <form method="POST" id="createForm">
                @csrf
                <div class="mb-3">
                    <label for="confirmPasswordDelete" class="col-form-label"><h6>Tên danh mục:</h6></label>
                    <input type="text" class="form-control" name="name">
                    <span class="text-danger small" id="error_name"></span>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại bảng</button>
                <button type="button" class="btn btn-success" id="buttonCreate">Nhấn để tạo</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>