@extends('admin.layouts.app')
@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create user</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body px-5">
                <div class="form-group">
                    <label>User name </label>
                    <input type="text" class="form-control  @error('user_name') is-invalid @enderror" name="user_name"
                        value="{{ old('user_name') }}">
                    @error('user_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Email </label>
                    <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Birthday </label>
                    <input type="date" class="form-control  @error('birthday') is-invalid @enderror" name="birthday"
                        value="{{ old('birthday') }}">
                    @error('birthday')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First name </label>
                            <input type="text" class="form-control  @error('first_name') is-invalid @enderror"
                                name="first_name" value="{{ old('first_name') }}">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last name </label>
                            <input type="text" class="form-control  @error('last_name') is-invalid @enderror"
                                name="last_name" value="{{ old('last_name') }}">
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label>Address </label>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control  @error('address') is-invalid @enderror"
                                name="address" value="{{ old('address') }}">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select id="province" class="form-control  @error('province_id') is-invalid @enderror"
                                name="province_id">
                                <option value="">Select province </option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                                @error('province_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select onchange="selectDistrict()" id="district"
                                class="form-control  @error('district_id') is-invalid @enderror" name="district_id">
                                <option value="">Select district </option>
                            </select>
                            @error('district_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select id="commune" class="form-control  @error('commune_id') is-invalid @enderror"
                                name="commune_id">
                                <option value="">Select commune</option>
                            </select>
                            @error('commune_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input onclick="myfunction()" type="file" id="inputImg"
                        class="inputImg form-control  @error('avatar') is-invalid @enderror" name="avatar"
                        value="{{ old('avatar') }}">
                    <label for="">Avatar</label>
                    <div> <label for="inputImg">
                            <span class="btn btn-success">
                                <i class="fa-solid fa-image nav-icon"></i> Chọn hình ảnh
                            </span>
                        </label></div>
                    <div class="img-preview " id="imgPreview">
                        <img src="" alt="Image Preview" class="img-preview-img">
                        <span class="img-preview-text">Image preview</span>
                    </div>
                    @error('avatar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Status </label>
                    <input type="text" class="form-control  @error('status') is-invalid @enderror" name="status"
                        value="{{ old('status') }}">
                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Password </label>
                    <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password"
                        value="{{ old('password') }}">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    @endsection
