@extends('users.layouts.app')
@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('product.update-product') }}</h3>
    </div>
</div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="card-body px-5">
            <div class="form-group">
                <label> {{ __('product.sku') }} </label>
                <input type="text" class="value-sku form-control  @error('sku') is-invalid @enderror" name="sku"
                    value="{{ old('sku', $product->sku) }}">
                @error('sku')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label> {{ __('product.name') }} </label>
                <input type="text" class="value-name form-control  @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name', $product->name) }}">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label> {{ __('product.stock') }} </label>
                <input type="text" class="value-stock form-control  @error('stock') is-invalid @enderror" name="stock"
                    value="{{ old('stock', $product->stock) }}">
                @error('stock')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label> {{ __('product.price') }} </label>
                <input type="text" class="value-price form-control  @error('price') is-invalid @enderror" name="price"
                    value="{{ old('price', $product->price) }}">
                @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input onclick="myfunction()" type="file" id="inputImg"
                    class="inputImg form-control  @error('avatar') is-invalid @enderror" name="avatar"
                    value="{{ old('avatar', $product->avatar) }}">
                <label for="">{{ __('product.avatar') }}</label>
                <div> <label for="inputImg">
                        <span class="btn btn-success">
                            <i class="fa-solid fa-image nav-icon"></i> {{ __('product.choose-image') }}
                        </span>
                    </label>
                </div>
                <div class="img-preview " id="imgPreview">
                    <img src="" alt="Image Preview" class="img-preview-img">
                    <img class="img-preview-text img-preview-edit" src="{{ asset('upload/product_images/'.$product->avatar) }}"
                        alt="">
                </div>
                @error('avatar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label> {{ __('product.expired-at') }} </label>
                <input type="date" class="value-exp form-control  @error('expired_at') is-invalid @enderror"
                    name="expired_at" value="{{ old('expired_at', $product->expired_at) }}">
                @error('expired_at')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label> {{ __('product.category') }} </label>
                <select class="form-control  @error('name') is-invalid @enderror" name="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ __('product.update-product') }}</button>
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#preview"
                onclick="getInput()">
                {{ __('product.preview-product') }}
            </button>
            <!-- Show preview product -->
            <div class="modal" id="preview">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Preview title -->
                        <div class="modal-header ">
                            <h4 class="modal-title">{{ __('product.preview-product') }}</h4>
                        </div>
                        <!-- Preview content -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <img class="show-img" src="{{ asset('upload/product_images/'.$product->avatar) }}" alt=""
                                        style="max-width: 100%">
                                </div>
                                <div class="col-6">
                                    <div>
                                        <strong>{{ __('product.sku') }}:</strong>
                                        <span id="show-sku"></span>
                                    </div>
                                    <div>
                                        <strong>{{ __('product.name') }}:</strong>
                                        <span id="show-name"></span>
                                    </div>
                                    <div>
                                        <strong>{{ __('product.price') }}:</strong>
                                        <span id="show-price"></span> &#8363;
                                    </div>
                                    <div>
                                        <strong>{{ __('product.stock') }}:</strong>
                                        <span id="show-stock"></span>
                                    </div>
                                    <div>
                                        <strong>{{ __('product.expired-at') }}:</strong>
                                        <span id="show-exp"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Close preview -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">{{ __('product.close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
