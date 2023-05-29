@extends('backend.layouts.main')
@push('title')
    Báo cáo | Eshop Admin
@endpush
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-6">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Doanh thu theo ngày</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-inline page-header float-right ">
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<table  class="table table-striped table-bordered ">
    <tr>
        <th class="small font-weight-bold text-center">Ngày</th>
        <th class="small font-weight-bold text-center">Doanh thu</th>
    </tr>
    @foreach ($orders as $order)
        <tr>
            <td class="small text-center">{{ $order->date }}</td>
            <td class="small text-center">{{ number_format($order->total). ' đ' }}</td>
        </tr>
    @endforeach
</table>
@endsection
