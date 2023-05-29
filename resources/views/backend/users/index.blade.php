@extends('backend.layouts.main')
@push('title')
    Khách Hàng | Eshop Admin
@endpush
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-lg-8">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1 class="text-danger"><strong>ADMIN - Quản lý khách hàng</strong></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-flex align-items-center justify-content-lg-end">
                <div class="form-inline">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="search-form">
                        <input class="form-control mr-sm-2" type="text" name="search" value="{{ $search }}" placeholder="Tìm khách hàng ..." aria-label="Search">
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
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <div>
                            <h3><strong class="card-title text-dark">Danh sách khách hàng</strong></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="small font-weight-bold text-center">#</th>
                                    <th class="small font-weight-bold text-center">Tên</th>
                                    <th class="small font-weight-bold text-center">Xác thực email</th>
                                    <th class="small font-weight-bold text-center">Các đơn hàng</th>
                                    <th class="small font-weight-bold text-center">Số điện thoại</th>
                                    <th class="small font-weight-bold text-center">Tạo lúc</th>
                                    <th class="small font-weight-bold text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($users)
                                @foreach ($users as $user)
                                <tr>
                                    <td class="small text-center">{{ $user->id }}</td>
                                    <td class="small">{{ $user->name }}</td>
                                    <td class="small text-center">{{ $user->confirmed ? 'Đã xác thực' : 'Chưa xác thực'}}</td>
                                    <td class="small text-center"><a class="text-primary" href="{{ route('admin.orders.index', ['customer_id' => $user->id]) }}"><i class="fas fa-eye"></i></a></td>
                                    <td class="small text-center">{{ $user->phone_number }}</td>
                                    <td class="small text-center">{{ $user->created_at }}</td>
                                    <td class="small text-center">
                                        <a href="#" class="deleteCategoryLink text-danger" data-id="{{ $user->id }}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endisset
                            </tbody>
                        </table>
                        @isset($users)
                        {{ $users->links() }}
                        @endisset
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="clearfix"></div>
@endsection

@push('js')
@if (session()->has('messages_success'))
<script>
    toastr.success("{{session()->get('messages_success')}}");
</script>
@endif
{{-- Delete --}}
<script>
    $(document).ready(function() {
        $(".deleteCategoryLink").click(function() {
            Swal.fire({
                title: 'Chắc không?',
                text: "Hãy xác nhận xóa khách hàng!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Hủy',
                confirmButtonText: 'Ok, xóa giúp tôi!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: { id: $(this).data('id') },
                        url: "{{ route('admin.users.delete') }}",
                        success: function(data) {
                            if (data.status) {
                                Swal.fire(
                                'Hooray!',
                                'Đã xóa thông tin khách hàng thành công',
                                'success'
                                )
                                setTimeout(function() {
                                    window.location.reload(true)
                                }, 2000);
                            } else {
                                toastr.error('Không thể xóa khách hàng này!')
                            }
                        }
                    });
                    
                }
                })
            
        })
    });
</script>
@endpush