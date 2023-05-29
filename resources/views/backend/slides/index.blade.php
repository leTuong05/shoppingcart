@extends('backend.layouts.main')
@push('title')
    Slides | Eshop Admin
@endpush
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-lg-8">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1 class="text-danger"><strong>ADMIN - Quản lý trình chiếu</strong></h1>
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
                            <h3><strong class="card-title text-dark">Danh sách slides</strong></h3>
                        </div>
                        <div>
                            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Thêm 1 slide mới</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="small font-weight-bold text-center">#</th>
                                    <th class="small font-weight-bold text-center">Ảnh</th>
                                    <th class="small font-weight-bold text-center">Khởi tạo</th>
                                    <th class="small font-weight-bold text-center">Cập nhật</th>
                                    <th class="small font-weight-bold text-center">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($slides)
                                @foreach ($slides as $slide)
                                <tr>
                                    <td class="small text-center">{{ $slide->id }}</td>
                                    <td class="small text-center"><img style="max-height: 30px; max-width: 30px" src="{{ Storage::url($slide->image)}}" alt=""></td>
                                    <td class="small text-center">{{ $slide->created_at }}</td>
                                    <td class="small text-center">{{ $slide->updated_at }}</td>
                                    <td class="small text-center">
                                        <a href="#" class="deleteLink text-danger" data-id="{{ $slide->id }}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endisset
                            </tbody>
                        </table>
                        @isset($slides)
                        {{ $slides->links() }}
                        @endisset
                        @include('backend.slides.add')
                        @include('backend.slides.edit')
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
    $(document).ready(function() {
        $("#buttonCreate").click(function() {
            let formData = new FormData($('#createForm')[0]);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('admin.slides.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data) {
                        window.location.reload()
                    } else {
                        toastr.error('Không thể khởi tạo, xin thử lại!');
                    }
                },
                error: function(xhr) {
                    // console.log(xhr)
                    Object.keys(xhr.responseJSON.errors).forEach(key => {
                        $('#error_' + key).text(xhr.responseJSON.errors[key][0]);
                    });
                }
            })
        })
    })
</script>

{{-- Delete --}}
<script>
    $(document).ready(function() {
        $(".deleteLink").click(function() {
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
                        data: { id:$(this).data('id') },
                        url: "{{ route('admin.slides.delete') }}",
                        success: function(data) {
                            if (data.status) {
                                Swal.fire(
                                'Hooray!',
                                'Đã xóa slide thành công',
                                'success'
                                )
                                setTimeout(function() {
                                    window.location.reload(true)
                                }, 2000);
                            } else {
                                toastr.error('Không xóa được slide này, vui lòng thử lại!')
                            }
                        }
                    });
                    
                }
                })
            
        })
    });
</script>
@endpush