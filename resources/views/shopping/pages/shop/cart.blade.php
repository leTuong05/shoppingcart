@extends('shopping.index')

@push('title')
    Giỏ hàng | E-Shopper
@endpush

@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/">Trang</a></li>
                    <li class="active">Giỏ Hàng Của Bạn</li>
                </ol>
            </div>
            @if (session('cart'))
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                        <tr class="cart_menu">
                            <td class="image">Hình ảnh</td>
                            <td class="name">Tên sản phẩm</td>
                            <td class="price">Giá</td>
                            <td class="quantity">Số lượng</td>
                            <td class="total">Thành tiền</td>
                            <td></td>
                        </tr>
                    </thead>
                    @php
                        $total = 0;
                    @endphp
                    <tbody>
                            @foreach (session('cart') as $id => $details)
                                @php
                                    $total += $details['price'] * $details['quantity'];
                                @endphp
                                <tr data-id="{{ $id }}">
                                    <td class="cart_product">
                                        <a href=""><img width="100px" height="100px" src="{{ $details['image'] ? Storage::url($details['image']->image) : "https://vnpi-hcm.vn/wp-content/uploads/2018/01/no-image-800x600.png"}}" alt=""></a>
                                    </td>
                                    <td class="cart_description">
                                        <h4>{{ $details['name'] }}</h4>
                                        <p>Mã sản phẩm: {{ $details['id'] }}</p>
                                    </td>
                                    <td class="cart_price">
                                        <p>{{ number_format($details['price']) . ' đ'  }}</p>
                                    </td>
                                    <td class="cart_quantity">
                                        <div class="cart_quantity_button">
                                            <input style="width:30%" type="number" class="form-control quantity update-cart"
                                                name="quantity" value="{{ $details['quantity'] }}" autocomplete="off"
                                                min="1">
                                        </div>
                                    </td>
                                    <td class="cart_total">
                                        <p class="cart_total_price">
                                            {{ number_format($details['price'] * $details['quantity']) . ' đ' }}</p>
                                    </td>
                                    <td class="cart_delete">
                                        <button class="btn btn-danger btn-sm remove-from-cart">X</button>
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right"><h3><strong>Tổng tiền:  {{ number_format($total). " đ" }}  </strong></h3></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right">
                                <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Tiếp tục xem...</a>
                                <a  class="btn btn-success" href="{{ route('shopping.checkout') }}">Đặt hàng</a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
                <div style="display:flex; justify-content:center">
                    <img style="with:40px; height:40px; " src="{{ asset('images/shop/shrug-shoulder.png')}}" alt="">
                    <p style="padding: 8px; padding-bottom:0px">Giỏ hàng của bạn đang trống</p>
                    <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Tiếp tục xem...</a>
                </div>
            @endif
        </div>
    </section>

    
    <!--/#cart_items-->
@endsection
@push('js')
@if (session('success_add'))
    <script>
        swal({{ session('success_add') }})
    </script>
@endif
    <script>
        $(function() {
            $(".update-cart").change(function(e) {
                e.preventDefault();

                var ele = $(this);

                $.ajax({
                    url: '{{ route('shopping.update_cart') }}',
                    method: "patch",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents("tr").attr("data-id"),
                        quantity: ele.parents("tr").find(".quantity").val()
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            });
            $(".remove-from-cart").click(function(e) {
                e.preventDefault();

                var ele = $(this);

                if (confirm("Are you sure want to remove?")) {
                    $.ajax({
                        url: '{{ route('shopping.remove_from_cart') }}',
                        method: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: ele.parents("tr").attr("data-id")
                        },
                        success: function(response) {
                            window.location.reload();
                        }
                    });
                }
            });
        })
    </script>
@endpush
