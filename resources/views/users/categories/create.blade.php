@extends('users.layouts.app')
@section('content')
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{__('category.create-category')}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body px-5">
                        <div class="form-group">
                            <label> {{__('category.name')}} </label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label> {{__('category.parent-category') }}</label>
                            <select class="form-control  @error('name') is-invalid @enderror" name="parent_id">
                                <option value=""> {{__('category.none')}}</option>
                                @foreach ($categories as $category)
                                @if (optional($category->childrenId)->count() < 1)                                  
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
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
                        <button type="submit" class="btn btn-primary"> {{__('category.create-category')}}</button>
                    </div>
                </form>
            </div>
        @endsection
