@extends('backend.layouts.main')
@push('title')
    Đơn Hàng | Eshop Admin
@endpush
@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-6">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Đơn hàng</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-inline page-header float-right ">
                        <a href="{{ route('admin.baocao') }}">Báo cáo</a>
                        <form method="GET" action="{{ route('admin.orders.index') }}" class="search-form">
                            <input class="form-control mr-sm-2" type="text" name="search" value=""
                                placeholder="Tìm kiếm" aria-label="Search">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-left">
                                <strong class="card-title text-dark">Quản lý đơn hàng</strong>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <table id="productTable" class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th class="small font-weight-bold text-center">#</th>
                                        <th class="small font-weight-bold text-center"> Mã đơn </th>
                                        <th class="small font-weight-bold text-center">Mã tài khoản</th>
                                        <th class="small font-weight-bold text-center">Tên khách hàng</th>
                                        <th class="small font-weight-bold text-center">Số điện thoại</th>
                                        <th class="small font-weight-bold text-center">Địa chỉ giao hàng</th>
                                        <th class="small font-weight-bold text-center">Ghi chú</th>
                                        <th class="small font-weight-bold text-center">Tổng tiền</th>
                                        <th class="small font-weight-bold text-center">Tình trạng</th>
                                        
                                        
                                        <th class="small font-weight-bold text-center">Khởi tạo</th>
                                        <th class="small font-weight-bold text-center">Cập nhật</th>
                                        <th class="small font-weight-bold text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td class="small text-center">{{ $order->id }}</td>
                                        <td class="small text-center">{{ $order->order_id }}</td>
                                        <td class="small text-center">{{ $order->user_id }}</td>
                                        <td class="small text-center">{{ $order->name }}</td>
                                        <td class="small text-center">{{ $order->phone_number }}</td>
                                        <td class="small text-center">{{ $order->city."-".$order->district."-".$order->ward }} <br> {{ $order->details_address}}</td>
                                        <td class="small text-center">{{ $order->note_shipping }}</td>
                                        <td class="small text-center">{{ $order->subtotal }}</td>
                                        <td class="small text-center checkout-status">
                                            {{ $order->checkout_status == 0 ? 'Chưa xác nhận' : 'Đã xác nhận' }}
                                        </td>
                                        
                                        <td class="small text-center">{{ $order->created_at }}</td>
                                        <td class="small text-center">{{ $order->updated_at }}</td>
                                        <td class="small text-center">
                                            <div class="btn-group-vertical" role="group" aria-label="Basic outlined example">
                                                <a href="{{ route('admin.orders.cart_detail',$order->id) }}" class="btn btn-outline-primary">Xem</a>
                                                <a href="javascript:;" data-id="{{ $order->id }}" class="btn btn-outline-primary deletedOrder">Xóa</a>
                                                @if ($order->checkout_status == 0)
                                                    <a href="javascript:;" data-id="{{ $order->id }}"  class="btn btn-outline-primary confirm">Xác nhận</a>
                                                @endif
                                            </div>
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                            {{ $orders ->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>

@endsection

@push('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(function(){
            $(".deletedOrder").click(function(){
                let id = $(this).data("id");
                swal({
                        title: "Bạn có chắc chắn xóa?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "{{ route('admin.orders.delete') }}",
                                type: "POST",
                                dataType: "json",
                                data: {
                                    id: id,
                                },
                                success: function(data) {
                                    if(data.status){
                                        swal("Bạn đã xóa thành công !", {
                                            icon: "success",
                                        });
                                        window.location.reload();
                                    }
                                },
                            });
                        } else {
                            swal("Đơn hàng vẫn tồn tại !");
                        }
                    });
            
            })
            $(".confirm").click(function(e) {
                let id = $(this).data("id");
                let element = $(this);
                $.ajax({
                    url: "{{ route('admin.orders.confirm') }}",
                    type: "POST",
                    data: {
                        "id": id,
                    },
                    success: function(data) {
                        console.log(data.status)
                        if (data.status) {
                            element.closest('tr').find('.checkout-status').text('Đã xác nhận');
                            element.remove();
                            swal("Xác nhận thành công!"," ", "success");
                        }
                    }
                })
            })
        })
    </script>
@endpush