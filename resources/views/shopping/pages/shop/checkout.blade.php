@extends('shopping.index')

@push('title')
    Trang Thanh Toán | E-Shopper
@endpush

@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Trang</a></li>
                <li class="active">Thanh toán</li>
            </ol>
        </div><!--/breadcrums-->

        <div class="step-one">
            <h2 class="heading">Nhập địa chỉ nhận hàng</h2>
            <form id="form-order-info">
                @csrf
                <div class="row">
                    <input type="hidden" name="total_price"/>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label style="font-weight:bolder;color:black" >Họ và tên<span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" name="name" placeholder="Tên người nhận">
                            <div class="invalid-feedback text-danger" id="errorName">
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="font-weight:bolder;color:black" >Số điện thoại<span class="text-danger">*</span>  </label>
                            <input type="number" class="form-control" name="phone_number" placeholder="SĐT người nhận">
                            <div class="invalid-feedback text-danger" id="errorPhonenumber">
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="font-weight:bolder;color:black" >Email<span class="text-danger">*</span>  </label>
                            <input type="text" class="form-control" name="email" placeholder="Email của người nhận hàng">
                            <div class="invalid-feedback text-danger" id="errorEmail">
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="font-weight:bolder;color:black" >Ghi chú<span class="text-danger">*</span>  </label>
                            <textarea type="text" rows="4" class="form-control" name="note" placeholder="Bạn muốn giao hàng lúc nào?"></textarea>
                            <div class="invalid-feedback text-danger" id="errorNote">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label>Tỉnh / Thành phố<span class="text-danger">*</span></label>
                            <select class="form-control" name="province" id="provinces" required>
                                <option value="-1" selected="selected">Chọn ...</option>
                                @foreach ($provinces as  $province)
                                    <option value="{{$province->matp}}">{{$province->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback text-danger" id="errorProvince">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label>Quận / Huyện<span class="text-danger">*</span></label>
                            <select class="form-control" name="district" id="districts" required>
                                <option value="-1" selected="selected">Chọn ...</option>
                            </select>
                            <div class="invalid-feedback text-danger" id="errorDistrict">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label>Xã / Phường<span class="text-danger">*</span></label>
                            <select class="form-control" name="ward" id="wards" required>
                                <option value="-1" selected="selected">Chọn ...</option>
                            </select>
                            <div class="invalid-feedback text-danger" id="errorWard">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label>Cụ thể<span class="text-danger">*</span></label>
                            <textarea class="form-control" type="text" name="detailsAddress" rows="4" placeholder="Số nhà, tên đường, ..." required></textarea>
                            <div class="invalid-feedback text-danger" id="errorDetails">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        
        <div class="review-payment">
            <h2>Kiểm tra và Thanh toán</h2>
        </div>

        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Sản phẩm</td>
                        <td class="description"></td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng</td>
                        <td></td>
                    </tr>
                </thead>
                @php
                    $total = 0;
                @endphp
                <tbody>
                    @if (session('cart'))
                            @foreach (session('cart') as $id => $details)
                                @php
                                    $cart = [];
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
                                            <p>{{ $details['quantity'] }}</p>
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
                        @endif
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Tổng tiền</td>
                                    <td class="text-right">{{ number_format($total). " đ" }}</td>
                                </tr>
                                <tr>
                                    @php
                                        $vat = $total*10/100
                                    @endphp
                                    <td>VAT</td>
                                    <td class="text-right">{{ number_format($vat). " đ" }}</td>
                                </tr>
                                <tr class="shipping-cost">
                                    <td>Phí vận chuyển</td>
                                    <td class="text-right">Free</td>										
                                </tr>
                                <tr>
                                    <td><label>Thanh toán</label></td>
                                    <td class="text-right"><span>{{ number_format( $total + $vat ) . " đ"}}</span></td>
                                    <input type="hidden" id="total_price" value="{{ $total + $vat }}" />
                                </tr>
                                <tr>
                                    <td><label>Hình thức thanh toán</label></td>
                                </tr>
                                
                            </table>
                            <table>
                                <select class="form-control" name="payment" required>
                                    <option  value="cod" selected>
                                        Thanh toán khi nhận hàng (COD)
                                    </option>
                                    <option value="online">
                                        Thanh toán cổng thanh toán online
                                    </option>
                                </select>
                            </table>
                            <hr>
                            <table>
                                <div class="single-widget payement text-center">
                                    <div class="content">
                                        <img src="{{asset('images/shop/payment-method.png')}}" alt="#">
                                    </div>
                                </div>
                            </table>
                            <hr>
                            <table>
                                <div class="text-right">
                                    <a id="btn_order" class="btn btn-warning">Đặt hàng</a>
                                </div>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

@endsection

@push('js')
{{-- Flash messages --}}
@if (session()->has('success'))
    <script>
        toastr.success("{{session()->get('success')}}")
    </script>
@endif
@if (session()->has('error'))
    <script>
        toastr.error("{{session()->get('error')}}")
    </script>
@endif
{{-- Location 4 delivery --}}
<script>
    $(document).ready(function(){
        $(document).on('change', '#provinces', function() {
            $("#errorProvince").text("")

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('shopping.getDistricts') }}",
                data: { matp: $('#provinces').find(":selected").val() },
                success: function(data) {
                    $('#districts').empty()
                    $('#districts').prepend(`<option value="-1" selected="selected">Chọn ...</option>`)
                    $('#wards').empty()
                    $('#wards').prepend(`<option value="-1" selected="selected">Chọn ...</option>`)
                    
                    if (data.status) {
                        Object.keys(data.districts).forEach(key => {
                            $('#districts').append(`
                                <option value="`+data.districts[key]['maqh']+`">`+data.districts[key]['name']+`</option>
                            `)
                        })
                    }
                    else {
                        toastr.error('Không thể tải lên dữ liệu vị trí, hãy thử lại')
                    }
                },
                error: function(xhr) {

                }
            })
        })
    })
    $(document).ready(function() {
        $(document).on('change', '#districts', function() {
            $("#errorDistrict").text("")

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('shopping.getWards') }}",
                data: { maqh: $('#districts').find(":selected").val() },
                success: function(data) {
                    $('#wards').empty()
                    $('#wards').prepend(`<option value="-1" selected="selected">Chọn ...</option>`)
                    
                    if (data.status) {
                        Object.keys(data.wards).forEach(key => {
                            $('#wards').append(`
                                <option value="`+data.wards[key]['xaid']+`">`+data.wards[key]['name']+`</option>
                            `)
                        })
                    }
                    else {
                        toastr.error('Không thể tải lên dữ liệu vị trí, hãy thửu lại')
                    }
                },
                error: function(xhr) {

                }
            })
        })
    })

    $(document).ready(function() {
        $(document).on('change','#wards', function() {
            $("#errorWard").text("")
        })
        $(document).on('keydown', '[name="detailsAddress"]',function() {
            $("#errorDetails").text("")
        })
        $(document).on('keydown', '[name="name"]',function() {
            $("#errorName").text("")
        })
        $(document).on('keydown', '[name="email"]',function() {
            $("#errorEmail").text("")
        })
        $(document).on('keydown', '[name="phone_number"]',function() {
            $("#errorPhonenumber").text("")
        })
        $(document).on('keydown', '[name="note"]',function() {
            $("#errorNote").text("")
        })
    })
</script>
{{-- Click order --}}
<script>
    $(document).ready(function() {
        $('#btn_order').click(function() {
            let total = $('#total_price').val()
            $('[name="total_price"]').val(total)
            let formData = new FormData($('#form-order-info')[0]) 
            let count = 0;

            let $name = $('[name="name"]')
            let $phone_number = $('[name="phone_number"]')
            let $email = $('[name="email"]')
            let $note = $('[name="note"]')
            let $detailAddress = $('[name="detailsAddress"]')
            let $province = $('#provinces')
            let $district = $('#districts')
            let $ward = $('#wards')
            let $phonenumber = $('#phonenumber').text();

            if ($province.val() == '-1'){
                $("#errorProvince").text("Trường này không được để trống") 
            } else {
                $("#errorProvince").text("")
                count +=1
            }

            if ($district.val() == '-1'){
                $("#errorDistrict").text("Trường này không được để trống") 
            } else {
                $("#errorDistrict").text("")
                count +=1
            }

            if ($ward.val() == '-1'){
                $("#errorWard").text("Trường này không được để trống") 
            } else {
                $("#errorWard").text("")
                count +=1
            }

            if ($detailAddress.val().trim().length){
                $("#errorDetails").text("")
                count +=1
            } else {
                $("#errorDetails").text("Trường này không được để trống")
            }

            if ($.isNumeric($phone_number.val())){
                $("#errorPhonenumber").text("")
                count+=1
            } else {
                $("#errorPhonenumber").text("Vui lòng kiểm tra lại SĐT trường này!")
            }

            if ($name.val().trim().length) {
                $("#errorName").text("")
                count +=1
            } else {
                $("#errorName").text("Trường này không được để trống")
            }
            
            if ($email.val().trim().length) {
                $("#errorEmail").text("")
                count +=1
            } else {
                $("#errorEmail").text("Trường này không được để trống")
            }
            
            if ($note.val().trim().length) {
                $("#errorNote").text("")
                count +=1
            } else {
                $("#errorNote").text("Trường này không được để trống")
            }
            
            if (count == 8) {
                if ($('[name="payment"]').find(":selected").val() == "cod") {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{route('shopping.payments.cod')}}",
                        data: formData,
                        processData: false,
                        contentType: false, 
                        success: function(data) {
                            if (data.status) {
                                toastr.success('Đơn hàng đã được gửi và đang được xử lý!')
                                setTimeout(function() {
                                    window.location.assign("{{url('/')}}")
                                }, 2000);
                            }
                            else {
                                toastr.error('Đã có lỗi xảy ra với đơn hàng của bạn, hãy thử lại!')
                            }
                        },
                        error: function(xhr) {

                        }
                    })
                } else {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{route('shopping.payments.vnpaycreate')}}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            window.location.assign(data.link)
                        },
                        error: function(xhr) {
                            
                        }
                    })
                }
            } else {
                toastr.error('Đã xảy ra lỗi, vui lòng kiểm tra các trường ở trên!')
            }
        })
    })
</script>
@endpush