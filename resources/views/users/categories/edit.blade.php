@extends('users.layouts.app')
@section('content')
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> {{__('category.update-category')}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body px-5">


                        <div class="form-group">
                            <label> {{__('category.name') }}</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name', $category->name) }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label> {{__('category.parent-category') }}</label>
                            <select class="form-control  @error('name') is-invalid @enderror" name="parent_id">
                                    <option value=" {{ old('parent_id', $category->parent_id) }}">
                                        {{ optional($category->parentId)->name }}</option>
                                    <option value=""> {{__('category.none') }}</option>
                                @foreach ($categories as $categoryItem)
                                    @if ( optional($category->childrenId)->count() < 1 && $categoryItem->id != $category->id)                                                                   
                                    <option value="{{ $categoryItem->id }}">
                                        {{ $categoryItem->name , old('parent_id', $categoryItem->parent_id) }}
                                    </option>
                                    @endif
                                @endforeach                             
                            </select>
                            @error('parent_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"> {{__('category.update-category')}}</button>
                    </div>
                </form>
            </div>
        @endsection
