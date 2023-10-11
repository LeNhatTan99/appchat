@extends('users.layouts.app')
@section('content')
    <div class="row" style="max-width: 100%">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-info">{{ __('product.action') }}<i class="fa-solid fa-caret-down"></i></button>
                    <button class="btn btn-info">{{ __('product.refresh') }} <i
                            class="fa-solid fa-arrows-rotate"></i></button>
                    <button class="btn btn-info" id="btn-search" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('product.search') }} <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <div class="dropdown-menu  dropdown-menu-center" aria-labelledby="btn-search" style="width:40%">
                        <form action="{{ route('products.index') }}" method="GET" class="search-form">
                            @csrf
                            <div class="p-3">
                                <div class="form-group m2">
                                    <input value="{{ request()->input('search_word', old('search_word')) }}"
                                        name="search_word" type="search" class="form-control input-search"
                                        placeholder="{{ __('product.search-product') }}">
                                    <button type="submit" class="btn-search"><i class=" fas fa-search"></i></button>
                                </div>
                                <select name="filter_stock">
                                    <option> {{ __('product.filter-by-stock') }} <i class="fa-solid fa-chevron-down"></i>
                                    </option>
                                    <option value="1"> {{ __('product.less-than-10-products') }} </option>
                                    <option value="2"> {{ __('product.10-to-100-products') }} </option>
                                    <option value="3"> {{ __('product.100-to-200-products') }} </option>
                                    <option value="4"> {{ __('product.more-than-200-products') }} </option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="card-tools">
                        <a href="{{ route('products.create') }}" class="btn btn-success"><i
                                class="fa-solid fa-file-circle-plus"></i> {{ __('product.create-product') }}</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th> {{ __('product.sku') }}</th>
                                <th> {{ __('product.name') }}</th>
                                <th> {{ __('product.price') }}</th>
                                <th> {{ __('product.stock') }}</th>
                                <th> {{ __('product.avatar') }}</th>
                                <th> {{ __('product.expired-at') }}</th>
                                <th> {{ __('product.category') }}</th>
                                <th> {{ __('product.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $value => $product)
                                <tr id="delete{{ $product->id }}">
                                    <td>{{ $value + $products->firstItem() }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ number_format($product->price) }}.&#8363;</td>
                                    <td>{{ $product->stock }}</td>
                                    <td> <img class="show-avatar" src="{{ asset('upload/product_images/'.$product->avatar) }}"
                                            alt="avatar product"></td>
                                    <td>{{ $product->expired_at }}</td>
                                    @if (!empty($product->category->name))
                                    <td>
                                        {{ $product->category->name }}
                                    </td>
                                    @else <td></td>
                                    @endif
                                    <td>
                                        <button class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#preview{{ $product->id }}"><i
                                                class="fa-solid fa-eye"></i></button>
                                        <!-- Show preview product -->
                                        <div class="modal" id="preview{{ $product->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Preview content -->
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <img src="{{ asset('upload/product_images/'.$product->avatar) }}"
                                                                    alt="" style="max-width: 100%">
                                                            </div>
                                                            <div class="col-6">
                                                                <p><strong>{{ __('product.sku') }}:</strong>
                                                                    {{ $product->sku }}
                                                                </p>
                                                                <p><strong>{{ __('product.name') }}:</strong>
                                                                    {{ $product->name }}</p>
                                                                    <p><strong>{{ __('product.price') }}:</strong>
                                                                        {{ number_format($product->price) }}.&#8363;</p>
                                                                <p><strong>{{ __('product.stock') }}:</strong>
                                                                    {{ $product->stock }}</p>
                                                                <p><strong>{{ __('product.expired-at') }}:</strong>
                                                                    {{ date('d/m/Y', strtotime($product->expired_at)) }}
                                                                </p>
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
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#item{{ $product->id }}">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <div class="modal" id="item{{ $product->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">{{ __('product.delete-product') }}</h4>
                                                        <button type="button" class="btn " data-bs-dismiss="modal"><i
                                                                class="fa-solid fa-x"></i></button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        {{ __('product.warning-delete-product') }}<strong>
                                                            {{ $product->name }}</strong> ?
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <a href="" onclick="deleteRecord({{ $product->id }})"
                                                            class="btn btn-danger p-2">{{ __('product.delete') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Button to download file -->
                    <div class="my-3">
                        <a href="{{ route('products.exportPdf') }}" class="btn btn-success mb-2">
                            <i class="fa-solid fa-download nav-icon"></i> {{ __('product.export') }} PDF</a>

                        <a href="{{ route('products.exportCsv') }}" class="btn btn-primary mb-2">
                            <i class="fa-solid fa-download nav-icon"></i> {{ __('product.export') }} CSV</a>
                    </div>
                    <!-- /.card-body -->
                </div>
                {{ $products->links() }}
                <!-- /.card -->
            </div>
        </div>
    </div>
    @endsection

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
