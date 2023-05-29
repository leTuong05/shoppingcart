<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print</title>
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/themify-icons.css') }}" />
</head>
<body>
    <header id="header" class="header">
        <div class="top-left">
            <div class="navbar-header">
                <a class="navbar-brand hidden" href="./"><img src="{{ asset('backend/images/logo.png') }}" alt="Logo"></a>
                <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
            </div>
        </div>
        
    </header>
    <center> <h3>Đơn hàng {{ $order->order_id }}</h3> </center>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h5>Đơn Hàng Từ</h5>
                <p style="font-size: 12px"> Lê Văn Tưởng <br>
                    SĐT: 0972630235 <br>
                    Email: vantuongno1@gmail.com <br>
                    Địa chỉ:: Mê Linh - Hà Nội <br>
                </p>
            </div>  
                
            <div class="col">
                <h5>Đến Người Nhận</h5>
                <p style="font-size: 12px">{{ $order->name }} <br>
                    SĐT: {{ $order->phone_number }} <br>
                    Địa chỉ: {{ $order->ward."-".$order->district."-".$order->city }} <br>
                    Địa chỉ cụ thể: {{ $order->details_address }}
                </p>
            </div>

            <div class="col">
                <h5>Mã đơn hàng: {{ $order->order_id }}</h5>
                <p style="font-size: 12px">
                    Tổng tiền: {{ number_format($order->subtotal)." đ" }} <br>
                    Phương thức thanh toán: {{ $order->payment_type }} <br>
                    Trạng thái thanh toán: Completed! <br>
                    Ghi chú của khách hàng: {{ $order->note_shipping }}
                </p>
            </div>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <thead>
                    <th>Mã đơn hàng</th>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </thead>
            </thead>
            <tbody>
                @foreach ($orderDetails as $orderDetail)
                    <tr>
                        <td>{{ $orderDetail->order_id }}</td>
                        <td>{{ $orderDetail->products_id }}</td>
                        <td>{{ $orderDetail->name }}</td>
                        <td>{{ $orderDetail->quantity }}</td>
                        <td>{{ number_format($orderDetail->total)." đ " }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="{{ asset('/backend/assets/js/bootstrap.min.js') }}"></script>
</body>
</html>