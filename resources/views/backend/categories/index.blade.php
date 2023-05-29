@extends('backend.layouts.main')
@push('title')
    Danh Mục Sản Phẩm | Eshop Admin
@endpush
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-lg-8">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1 class="text-danger"><strong>ADMIN - Quản lý danh mục</strong></h1>
                    </div>
                </div>
            </div>

            @isset($search)
            <div class="col-lg-4 d-flex align-items-center justify-content-lg-end">
                <div class="form-inline">
                    <form method="GET" action="{{ route('admin.categories.index') }}" class="search-form">
                        <input class="form-control mr-sm-2" type="text" name="search" value="{{ $search }}" placeholder="Search ..." aria-label="Search">
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
                            <h3><strong class="card-title text-dark">Danh mục sản phẩm</strong></h3>
                        </div>
                        <div>
                            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Tạo danh mục mới</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="small font-weight-bold text-center">#</th>
                                    <th class="small font-weight-bold text-center">Tên</th>
                                    <th class="small font-weight-bold text-center">Slug</th>
                                    <th class="small font-weight-bold text-center">Khởi tạo</th>
                                    <th class="small font-weight-bold text-center">Cập nhật</th>
                                    <th class="small font-weight-bold text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($categories)
                                @foreach ($categories as $category)
                                <tr>
                                    <td class="small text-center">{{ $category->id }}</td>
                                    <td class="small">{{ $category->name }}</td>
                                    <td class="small">{{ $category->slug}}</td>
                                    <td class="small text-center">{{ $category->created_at }}</td>
                                    <td class="small text-center">{{ $category->updated_at }}</td>
                                    <td class="small text-center">
                                        <a class="text-primary" href="#" data-bs-target="#updateModal" data-bs-toggle="modal" data-name="{{ $category->name }}" data-id="{{ $category->id }}">
                                            <i class="menu-icon fa  fa-pencil-square-o"></i>
                                        </a>
                                        <a href="#" class="deleteCategoryLink text-danger" data-id="{{ $category->id }}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endisset
                            </tbody>
                        </table>
                        @isset($categories)
                        {{ $categories->links() }}
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
@if (session()->has('messages_success'))
<script>
    toastr.success("{{session()->get('messages_success')}}");
</script>
@endif

{{-- Create --}}
<script>
    $("#createModal input").on('keypress', function(e){
        if (e.which === 13) {
            $("#buttonCreate").click()
        }
    })
    $(document).ready(function() {
        $("#buttonCreate").click(function() {
            let formData = new FormData($('#createForm')[0]);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('admin.categories.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status) {
                        window.location.reload()
                    } else {
                        toastr.error('Không thể khởi tạo, xin thử lại!');
                    }
                },
                error: function(xhr) {
                    Object.keys(xhr.responseJSON.errors).forEach(key => {
                        $('#error_' + key).text(xhr.responseJSON.errors[key][0]);
                    });
                }
            })
        })
    })
</script>

{{-- Data for update --}}
<script>
    $('#updateModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) //Button that show the modal
        // Extract info from data-* attributes
        var name = button.data('name')
        var id = button.data('id')
        var modal = $(this)

        modal.find('input[name="name"]').val(name)
        modal.find('input[name="updateId"]').val(id)
    })
</script>

{{-- Update --}}
<script>
    $(document).ready(function() {
        $('#buttonUpdate').click(function() {

            let formData = new FormData($('#updateCategoryForm')[0])

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('admin.categories.update') }}",
                data: formData,
                processData: false,
                contentType: false,

                success: function(data) {
                    if (data.status) {
                        window.location.reload()
                    } else {
                        toastr.error('Cannot update this category!')
                    }
                },
                error: function(xhr) {
                    Object.keys(xhr.responseJSON.errors).forEach(key => {
                        $('#error_update_' + key).text(xhr.responseJSON.errors[key][0]);
                    });
                }
            })
        })
    })
</script>

{{-- Delete --}}
<script>
    $(document).ready(function() {
        $(".deleteCategoryLink").click(function() {
            Swal.fire({
                title: 'Chắc không?',
                text: "Xóa rồi là mất đó!",
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
                        url: "{{ route('admin.categories.delete') }}",
                        success: function(data) {
                            if (data.status) {
                                Swal.fire(
                                'Hooray!',
                                'Đã xóa danh mục thành công',
                                'success'
                                )
                                setTimeout(function() {
                                    window.location.reload(true)
                                }, 2000);
                            } else {
                                toastr.error('Cannot delete the category!')
                            }
                        }
                    });
                    
                }
                })
            
        })
    });
</script>
@endpush