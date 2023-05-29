@extends('shopping.index')

@push('title')
    Tài khoản | E-Shopper
@endpush

@section('content')
    <section class="container">
        <form method="POST" action="{{ route('shopping.accounts.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-sm-4">
                <div class="left-sidebar text-center">
                    <h2>Ảnh đại diện</h2>
                    <div class="card-body text-center">
                        <img id="avatarImage" class="" style="height: 10rem; border-radius: 50% !important; margin-bottom:10px" src="{{ $user->avatar == '' ? asset('images/shop/no-avatar.png') : Storage::url($user->avatar) }}" alt="">
                        <div class="small font-italic text-muted" style="margin-bottom:10px">Ảnh đại diện có đuôi JPG or PNG và dung lượng dưới 5MB</div>
                        <input class="form-control" type="file" style="display:none" name="avatar" id="avatar" style="margin-bottom:10px"/>
                        <label for="avatar" class="btn btn-warning">Tải ảnh lên</label>
                        @error('avatar')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-sm-8 padding-right">
                <h2 class="title text-center">THÔNG TIN TÀI KHOẢN</h2>
                    <div style="margin-bottom:10px">
                        <label class="small mb-1" for="inputUsername">HỌ VÀ TÊN:</label>
                        <input class="form-control" id="inputUsername" style="margin-bottom:10px" name="name" type="text" placeholder="Nhập tên đầy đủ ở đây ..." value="{{ $user->name }}">
                        @error('name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="row gx-3">
                        <div class="col-md-6">
                            <label class="small mb-1" for="input_phone_number">SỐ ĐIỆN THOẠI:</label>
                            <input class="form-control" id="input_phone_number" style="margin-bottom:10px" name="phone_number" type="text" placeholder="Số điện thoại ..." value="{{ $user->phone_number }}">
                            @error('phone_number')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1" for="inputEmailAddress">ĐỊA CHỈ EMAIL:</label>
                            <input class="form-control" id="inputEmailAddress" style="margin-bottom:10px" name="email" type="email" placeholder="Nhập địa chỉ email của bạn ... " value="{{ $user->email }}" disabled>
                            @error('email')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Lưu lại thay đổi</button>
            </div>
        </form>
    </section>
@endsection

@push('js')
@if (session()->has('messages_success'))
<script>
    toastr.success("{{session()->get('messages_success')}}")
</script>
@endif
@if (session()->has('messages_error'))
<script>
    toastr.error("{{session()->get('messages_error')}}")
</script>
@endif
{{-- Load image --}}
<script type="text/javascript">
    avatar.onchange = evt => {
        const [file] = avatar.files
        if (file) {
            avatarImage.src = URL.createObjectURL(file)
        }
    }
</script>
@endpush
