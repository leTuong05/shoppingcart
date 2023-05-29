<div class="modal fade" id="updateContactModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-info" id="exampleModalLabel"><strong>Thay đổi thông tin doanh nghiệp</strong></h3>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateContactForm">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" name="updateId">
                        <input type="text" class="form-control" name="name" placeholder="Tên công ty...">
                        <span class="text-danger small" id="error_update_name"></span>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="phonenumber" placeholder="Số điện thoại...">
                        <span class="text-danger small" id="error_update_phonenumber"></span>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="fax" placeholder="Số fax...">
                        <span class="text-danger small" id="error_update_fax"></span>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="address" placeholder="Địa chỉ doanh nghiệp...">
                        <span class="text-danger small" id="error_update_address"></span>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="email" placeholder="Email...">
                        <span class="text-danger small" id="error_update_email"></span>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại bảng</button>
                    <button type="button" class="btn btn-info" id="buttonUpdate">Lưu lại những thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>