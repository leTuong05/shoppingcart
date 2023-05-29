@extends('shopping.index')

@push('title')
    Đăng Nhập/Đăng Ký | E-Shopper
@endpush

@section('content')
    <section id="form">
        <!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form">
                        <!--login form-->
                        <h2>Đăng Nhập Vào Tài Khoản Của Bạn</h2>
                        @if (session('error_login'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error_login') }}
                            </div>
                        @endif

                        @if (session()->get('result_verify'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('result_verify') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('shopping.login_post') }}">
                            @csrf
                            <input type="email" name="email" placeholder="Email ..." />
                            @error('email_login')
                                {{ $message }}
                            @enderror
                            <input type="password" name="password" placeholder="Mật Khẩu ..." />
                            @error('password_login')
                                {{ $message }}
                            @enderror
                            {{-- <span>
                            <input type="checkbox" class="checkbox"> 
                            Keep me signed in
                        </span> --}}
                            <button style="width:100%" type="submit" class="btn btn-default">Đăng Nhập</button>
                        </form>
                        
                    </div>
                    <a href="{{ route('shopping.login_fb') }}" class="btn btn-block">
                        <i class="fab fa-facebook-f fa-fw"></i>
                        Login with Facebook
                     </a>
                    <!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">HAY</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form">
                        <!--sign up form-->
                        <h2>Đăng Ký Tài Khoản Mới</h2>
                        <form method="POST" action="{{ route('shopping.register') }}">
                            @csrf
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <input type="text" name="name" placeholder="Họ Và Tên ..." />
                            @error('name')
                                {{ $message }}
                            @enderror
                            <input type="email" name="email" placeholder="Địa Chỉ Email ..." />
                            @error('email')
                                {{ $message }}
                            @enderror
                            <input type="password" name="password" placeholder="Mật Khẩu ..." />
                            @error('password')
                                {{ $message }}
                            @enderror


                            <button style="width:100%" type="submit" name="submit" class="btn btn-default">Đăng Ký Tài Khoản</button>
                        </form>
                    </div>
                    <!--/sign up form-->
                </div>
            </div>
        </div>


    </section>
    <!--/form-->
@endsection

@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@endpush
