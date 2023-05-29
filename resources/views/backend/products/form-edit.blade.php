@extends('backend.layouts.main')
@push('title')
    Chỉnh Sửa Mặt Hàng | Eshop Admin
@endpush
@section('content')
    <div class="container">
        <form method="POST" action="/admin/update-product/{{ $product->id }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Tên Sản Phẩm</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}"
                    id="exampleInputEmail1" aria-describedby="emailHelp">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Mô Tả Sản Phẩm</label>
                <textarea name="description" id="mytextarea" cols="30"
                    rows="10">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $product->slug) }}"
                    id="exampleInputPassword1">

            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Giá Bán</label>
                <input type="number" min="1" value="{{ old('price', $product->price) }}" name="price"
                    class="form-control" id="exampleInputPassword1">
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Số lượng</label>
                <input type="number" name="quantity" class="form-control"
                    value="{{ old('quantity', $product->quantity) }}" id="exampleInputPassword1">
                @error('quantity')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Thuộc danh mục</label>
                <select name="category_id" class="form-control" id="cars">
                    <option value="#">---Chọn danh mục---</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Tải ảnh sản phẩm</label>
                <input type="file" name="image[]" class="form-control" id="exampleInputPassword1" multiple>
                <div>
                    @foreach ($product->productImages as $item)
                        <img src="{{ Storage::url($item->image) }}" style="width: 200px; height: 200px">
                    @endforeach
                </div>  

            </div>
            <button type="submit" name="submit" class="btn btn-primary">Cập Nhật</button>

        </form>
    </div>
@endsection
@push('js')
    <script>
        tinymce.init({
            selector: "#mytextarea"
        });
    </script>
@endpush
