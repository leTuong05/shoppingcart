<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập admin eshoper</title>
   <!--Made with love by Mutiullah Samim -->
   
    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href=" {{ asset('backend/assets/css/login-form-style.css') }} ">
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <h3>Nhập Email và Mật Khẩu Để Đăng Nhập</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.post_login') }}">
                    @csrf
                    @if ($errors->has('login_fail'))
                        <div style="color:red" class="error">{{ $errors->first('login_fail') }}</div>
                    @endif

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                            <input type="text" class="form-control" name="email" placeholder="Email">

                            @if($errors->has('email'))
                                <div style="color:red" class="error">{{ $errors->first('email') }}</div>
                            @endif

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <div>
                            <input type="password" class="form-control" name="password" placeholder="Mật Khẩu">
                        </div>

                        @if($errors->has('password'))
                            <div style="color: red" class="error">{{ $errors->first('password') }}</div>
                        @endif
                        
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn float-right login_btn">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>