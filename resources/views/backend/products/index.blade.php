@extends('backend.layouts.main')
@push('title')
    Sản Phẩm | Eshop Admin
@endpush
@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-lg-8">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1 class="text-danger"><strong>Quản lý sản phẩm</strong></h1>
                        </div>
                    </div>
                </div>

                @isset($search)
                    <div class="col-lg-4 d-flex align-items-center justify-content-lg-end">
                        <div class="form-inline">
                            <form method="GET" action="{{ route('admin.product') }}" class="search-form">
                                <input class="form-control mr-sm-2" type="text" name="search" value="{{ $search }}"
                                    placeholder="Tìm kiếm ..." aria-label="Search">
                            </form>
                        </div>
                    </div>
                @endisset
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
                                <h3><strong class="card-title text-dark">Danh sách sản phẩm</strong></h3>
                            </div>
                            <div>
                                <a href="{{ route('admin.create_form_product') }}" class="btn btn-success">Thêm sản phẩm
                                    mới</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Số lượng</th>
                                        <th>Slug</th>
                                        <th>Giá Bán</th>
                                        <th>Danh mục</th>
                                        <th>Ảnh</th>
                                        <th>Khởi tạo</th>
                                        <th>Cập nhật</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($products->isNotEmpty())
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>{{ $product->slug }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ data_get($product, 'category.name') }}</td>
                                                <td>
                                                    @if ($product->productImages->first() != null)
                                                        <img src="{{ Storage::url($product->productImages->first()->image) }} "
                                                            alt="No image">
                                                    @endif
                                                </td>
                                                <td>{{ $product->created_at }}</td>
                                                <td>{{ $product->updated_at }}</td>
                                                <td>
                                                    <a href="{{ route('admin.edit_product', $product->id) }}">
                                                        <i class="menu-icon fa  fa-pencil-square-o"></i>
                                                    </a>
                                                    <button type="button" data-id="{{ $product->id }}"
                                                        class="deleteProduct"><i class="fas fa-trash"></i></button>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            @isset($products)
                                {{ $products->links() }}
                            @endisset
                            @include('backend.categories.add')
                            @include('backend.categories.edit')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="clearfix"></div>
@endsection

@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(function() {
            $(".deleteProduct").click(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var id = $(this).data("id");
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this imaginary file!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "/admin/delete-product/" + id,
                                type: "GET",
                                dataType: "json",
                                data: {
                                    "id": id,
                                },
                                success: function(response) {

                                    window.location.reload();
                                    swal("Poof! Your imaginary file has been deleted!", {
                                        icon: "success",
                                    });
                                },
                            });
                        } else {
                            swal("Your imaginary file is safe!");
                        }
                    });
            })
        })
    </script>
@endpush
