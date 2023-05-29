@extends('shopping.index')
@push('title')
Trang Chủ | E-Shop
@endpush


@section('content')
    <section id="slider">
        <!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($slides as $key => $value)
                                @if ($key == 0)
                                    <li data-target="#slider-carousel" data-slide-to="{{ $key }}"
                                        class="active"></li>
                                @else
                                    <li data-target="#slider-carousel" data-slide-to="{{ $key }}"
                                        class=""></li>
                                @endif
                            @endforeach
                        </ol>

                        <div class="carousel-inner">
                            @foreach ($slides as $key => $value)
                            @if ($key == 0)
                            <div class="item active">
                                <div class="col-sm-12" style="display: flex;
                                justify-content: center;
                                align-items: center;">
                                    <img src="{{Storage::url($value->image)}}" class="girl img-responsive" alt="" />
                                </div>
                            </div>
                            @else
                            <div class="item">
                                <div class="col-sm-12" style="display: flex;
                                justify-content: center;
                                align-items: center;">
                                    <img src="{{Storage::url($value->image)}}" class="girl img-responsive" alt="" />
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>

                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--/slider-->

    <section>
        <div class="container">
            <div class="row">
                @include('shopping.layouts.left-sidebar')
                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">
                            {{ $categoryName }}
                        </h2>
                        @isset($products)
                            <div class="text-center">{{ $products->appends(request()->input())->links() }}</div>
                        @endisset
                        @forelse ($products as $product)
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <form >
                                        @csrf
                                        <div class="productinfo text-center">
                                            @php
                                                $productImage = $product->productImages()->first();
                                                $imageDefault = 'https://vnpi-hcm.vn/wp-content/uploads/2018/01/no-image-800x600.png';
                                            @endphp
                                            <input type="hidden" class="product_id_{{ $product->id }}" value="{{ $product->id }}">
                                            <input type="hidden" class="product_name_{{ $product->id }}" value="{{ $product->name }}">
                                            <input type="hidden" class="product_description_{{ $product->id }}" value="{{ $product->description }}">
                                            <input type="hidden" class="product_quantity_{{ $product->id }}" value="{{ $product->quantity }}">
                                            <input type="hidden" class="product_image_{{ $product->id }}" value="{{ $productImage ? $productImage->image : "" }}">
                                            <input type="hidden" class="product_price_{{ $product->id }}" value="{{ $product->price }}">
                                            
                                            
                                            <img src="{{ $productImage ? Storage::url($productImage->image) : $imageDefault }}"
                                                alt="" />
                                            <h2>{{ number_format($product->price). ' đ' }}</h2>
                                            <p>{{ $product->name }}</p>
                                            <a href="#" class="btn btn-default add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                                        </div>
                                        <div class="product-overlay">
                                            <div class="overlay-content">
                                                <h2>{{ number_format($product->price). ' đ' }}</h2>
                                                <p>{{ $product->name }}</p>
                                                <a href="{{ route('shopping.add_to_cart', $product->id) }}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                                                
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                        <li><a href="javascript:;" class="add-to-wishlist" data-product-id="{{$product->id}}" data-user-id="{{ isset(auth()->user()->id) ? auth()->user()->id : ""  }}"><i class="fa fa-plus-square"></i>Thêm vào yêu thích</a></li>
                                        <li><a href="{{url('products/'.$product->slug)}}"><i class="fas fa-eye"></i>Xem chi tiết</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div><img style="width: 30px; height: 30px;" src="{{ asset('images/shop/think-face.png')}}" alt="think-face"></img> Hiện chưa có sản phẩm phù hợp với yêu cầu của bạn!</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
@endsection    
@push('js') 

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
@if (session()->get('success_add'))
    <script>
        toastr.success("{{ session()->get('success_add') }}")
    </script>
@endif
<script>
    $(function() {
        $(".add-to-cart").click(function() {
            console.log('hello')
            var id = $(this).data('id');
            var product_id = $('.product_id_' + id).val();
            var product_name = $('.product_name_' + id).val();
            var product_description = $('.product_description_' + id).val();
            var product_quantity = $('.product_quantity_' + id).val();
            var product_price = $('.product_price_' + id).val();
            var product_image = $('.product_image_'+ id).val()
            var _token = $('input[name="_token"]').val();
            
            $.ajax({
                url: '{{ url('/add-cart-ajax') }}',
                method: 'POST',
                data: {
                    id: product_id,
                    name: product_name,
                    description: product_description,
                    quantity: product_quantity,
                    price: product_price,
                    image: product_image,
                    _token: _token
                },
                success: function(data){
                    alert(data);
                },
                error: function(err){
                    console.error(err);
                } 
            })
        })
    })
</script>

@endpush
