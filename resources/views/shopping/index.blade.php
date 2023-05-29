<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@stack('title')</title>

    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/animate.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/main.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/responsive.css') }}" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="{{ asset('/css/toastr.css') }}" rel="stylesheet">  
	<link href="{{ asset('/css/sweetalert.css') }}" rel="stylesheet">  
    <link rel="shortcut icon" href="{{ asset('/images/ico/favicon.ico') }}">
    
    @stack('styles')
	
</head><!--/head-->

<body>
	@include('shopping.layouts.header')
    @yield('content')
    @include('shopping.layouts.wishlist')
    @include('shopping.layouts.footer')
    
    <script src="{{ asset('/js/jquery.js') }}"></script>
	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/js/jquery.scrollUp.min.js') }}"></script>
	<script src="{{ asset('/js/price-range.js') }}"></script>
    <script src="{{ asset('/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/toastr.js') }}"></script>
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    
    @stack('styles')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @if (session()->has('messages_error'))
    <script>
        toastr.error("{{session()->get('messages_error')}}");
    </script>
    @endif
    
    {{-- Search tool --}}
    <script>
        $(document).ready(function() {
            //setup before functions
            var typingTimer;                //timer identifier
            var doneTypingInterval = 1000;  //time in ms (5 seconds)
            $('.search-product input[name="search"]').on('keyup', function() { 
                clearTimeout(typingTimer);
                if ($('.search-product input[name="search"]').val()) {
                    typingTimer = setTimeout(doneTyping, doneTypingInterval);
                }
            })
            function doneTyping() {
                var val = $('.search-product input[name="search"]').val()
                $('.apply-filter input[name="search"]').val(val)
            }
        })
    </script>
    {{-- Wishlist --}}
    <script>
        $(document).ready(function() {
            $('.add-to-wishlist').click(function() {
                if ($(this).data('user-id') == '') {
                    Swal.fire({
                        text: 'Vui lòng đăng nhập để thực hiện chức năng này',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Đến trang đăng nhập',
                        cancelButtonText: 'Hủy thao tác'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('shopping.login') }}";
                        }
                    })
                } else {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{route('shopping.favorites.addToFavorite')}}",
                        data: {product_id : $(this).data('product-id')},
    
                        success: function(data) {
                            if (data.status) {
                                toastr.success('Đã thêm vào yêu thích của bạn!')
                                let countFavorite = $('#count-favorite').text();
                                if (countFavorite == 0) {
                                    countFavorite = '0';
                                    countFavorite = parseInt(countFavorite) + 1;
                                    $('#count-favorite').text(countFavorite);
                                    $('#count-favorite').removeClass('hidden');
                                    $('#display-favorite').empty();
                                    $('#display-favorite').prepend(`
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="small font-weight-bold text-center">Ảnh</th>
                                                <th class="small font-weight-bold text-center">Tên sản phẩm</th>
                                                <th class="small font-weight-bold text-center">Giá tiền</th>
                                                <th class="small font-weight-bold text-center">Số lượng</th>
                                                <th class="small font-weight-bold text-center">Thêm vào giỏ hàng</th>
                                                <th class="small font-weight-bold text-center">Xóa</th>
                                            </tr>
                                        </thead>
                                        <tbody class="favorite-table-body">
                                            <tr class="favorite-item">
                                                <td class="small text-center"><img src="{{asset('storage/`+data.product.product_images[0].image+`')}}" alt="favorite product" style="width:30px; height:30px"></td>
                                                <td class="small text-center">`+data.product['name']+`</td>
                                                <td class="small text-center">`+data.product['price']+`</td>
                                                <td class="small text-center">1</td>
                                                <td class="small text-center"><a href="/add-to-cart/`+data.product['id']+`"><i class="fas fa-cart-plus"></i></a></td>
                                                <td class="small text-center"><a href="javascript:;" class="remove-from-wishlist" data-product-id="`+data.product['id']+`"><i class="fas fa-trash-alt"></i></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    `);
                                    
                                } else {
                                    countFavorite = parseInt(countFavorite) + 1;
                                    $('#count-favorite').text(countFavorite);
                                    $('.favorite-table-body').append(`
                                    <tr class="favorite-item">
                                        <td class="small text-center"><img src="{{asset('storage/`+data.product.product_images[0].image+`')}}" alt="favorite product" style="width:30px; height:30px"></td>
                                        <td class="small text-center">`+data.product['name']+`</td>
                                        <td class="small text-center">`+data.product['price']+`</td>
                                        <td class="small text-center">1</td>
                                        <td class="small text-center"><a href="/add-to-cart/`+data.product['id']+`"><i class="fas fa-cart-plus"></i></a></td>
                                        <td class="small text-center"><a href="javascript:;" class="remove-from-wishlist" data-product-id="`+data.product['id']+`"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>
                                    `)
                                }
                            }
                            else {
                                toastr.info('Sản phẩm đã tồn tại trong wishlist')
                            }
                        },
                        error: function(xhr) {
                            toastr.warning('Opps! Đã xảy ra lỗi, hãy thử lại lần sau!')
                        }
                    })
                }
            })
        })
        // Remove from wishlist
        $(document).ready(function() {
            $(document).on('click', '.remove-from-wishlist', function() {
                $(this).closest('.favorite-item').remove()  
    
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('shopping.favorites.removeFromFavorite') }}",
                    data: {product_id:$(this).data('product-id')},
                    success: function(data) {
                        if (data.status) {
                            let countFavorite = $('#count-favorite').text();
                            countFavorite = parseInt(countFavorite) - 1
                            if (countFavorite == 0) {
                                $('#count-favorite').addClass('hidden');
                                $('#count-favorite').text(countFavorite);
                                $('#display-favorite').empty();
                                $('#display-favorite').prepend(`
                                    <div style="display:flex; justify-content:center">
                                    <img style="with:30px; height:30px" src="{{ asset('images/shop/shrug-shoulder.png')}}" alt="">
                                    <p style="padding: 10px">Không tìm thấy sản phẩm yêu thích nào</p>
                                </div>
                                `);

                            } else {
                                $('#count-favorite').text(countFavorite);
                                $(this).closest('.favorite-item').remove()  
                            }

                            toastr.success('Đã xóa sản phẩm!')
                        }
                        else {
                            toastr.error('Không thể xóa sản phẩm!')
                        }
                    },
                    error: function(xhr) {
                        
                    }
                })
            })
        })
    </script>
    @stack('js')
</body>
</html>