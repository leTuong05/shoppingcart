@extends('backend.layouts.main')
@push('title')
    Thông Tin Doanh Nghiệp | Eshop Admin
@endpush
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-6">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1 class="text-danger"><strong>ADMIN - Quản lý thông tin liên hệ</strong></h1>
                    </div>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h3><strong class="card-title text-dark">Thông tin doanh nghiệp</strong></h3>
                        </div>
                        <div>
                            <a href="#" data-bs-target="#createModal"
                            data-bs-toggle="modal"><button type="button" class="btn btn-success">Tạo thông tin liên hệ mới</button></a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="small font-weight-bold text-center">#</th>
                                    <th class="small font-weight-bold text-center">Name</th>
                                    <th class="small font-weight-bold text-center">Phonenumber</th>
                                    <th class="small font-weight-bold text-center">Fax</th>
                                    <th class="small font-weight-bold text-center">Address</th>
                                    <th class="small font-weight-bold text-center">Email</th>
                                    <th class="small font-weight-bold text-center">Created at</th>
                                    <th class="small font-weight-bold text-center">Updated at</th>
                                    <th class="small font-weight-bold text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @isset ($contacts)
                                @foreach ($contacts as $contact)
                                <tr>
                                    <td class="small text-center">{{ $contact->id }}</td>
                                    <td class="small text-center">{{ $contact->name }}</td>
                                    <td class="small text-center">{{ $contact->phonenumber }}</td>
                                    <td class="small text-center">{{ $contact->fax }}</td>
                                    <td class="small text-center">{{ $contact->address }}</td>   
                                    <td class="small text-center">{{ $contact->email }}</td>
                                    <td class="small text-center">{{ $contact->created_at }}</td>
                                    <td class="small text-center">{{ $contact->updated_at }}</td>
                                    
                                    <td class="small text-center">
                                        <a  class="text-primary"
                                            href="#" 
                                            data-id={{ $contact->id}} 
                                            data-name="{{ $contact->name }}" 
                                            data-phonenumber="{{ $contact->phonenumber }}" 
                                            data-fax="{{ $contact->fax }}" 
                                            data-email="{{ $contact->email }}"
                                            data-address="{{ $contact->address }}"
                                            data-bs-target="#updateContactModal"
                                            data-bs-toggle="modal"
                                        >
                                            <i class="menu-icon fa  fa-pencil-square-o"></i>
                                        </a>

                                        <a href="#" data-id="{{ $contact->id}}" class="deleteContactLink text-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endisset
                            </tbody>
                        </table>
                        
                        @isset($contacts)
                        {{ $contacts->links() }}
                        @endisset
                        @include('backend.contacts.add')
                        @include('backend.contacts.edit')
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->
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
            let formData = new FormData($('#createContactForm')[0]);
            
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('admin.contacts.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status) {
                        window.location.reload()
                    } else {
                        toastr.error('Khởi tạo thất bại, vui lòng thử lại');
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
    $('#updateContactModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) //Button that show the modal
        // Extract info from data-* attributes
        var name = button.data('name')
        var phonenumber = button.data('phonenumber')
        var fax = button.data('fax')
        var address = button.data('address')
        var email = button.data('email')
        var id = button.data('id')
        var modal = $(this)

        modal.find('input[name="name"]').val(name)
        modal.find('input[name="phonenumber"]').val(phonenumber)
        modal.find('input[name="fax"]').val(fax)
        modal.find('input[name="address"]').val(address)
        modal.find('input[name="email"]').val(email)
        modal.find('input[name="updateId"]').val(id)
    })
</script>

{{-- Update --}}
<script>
    $(document).ready(function() {
        $('#buttonUpdate').click(function() {
            let formData = new FormData($('#updateContactForm')[0])

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('admin.contacts.update') }}",
                data: formData,
                processData: false,
                contentType: false,

                success: function(data) {
                    if (data.status) {
                        window.location.reload()
                    } else {
                        toastr.error('Opps! Không thể xóa thông tin, mời thử lại')
                    }
                },
                error: function(xhr) {
                    console.log(xhr)
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
        $(".deleteContactLink").click(function() {
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
                        data: {id:$(this).data('id')},
                        url: "{{ route('admin.contacts.delete') }}",
                        success: function(data) {
                            if (data.status) {
                                Swal.fire(
                                'Xóa thành công!',
                                'Đã hủy một bản ghi',
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