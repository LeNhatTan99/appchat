@extends('admin.layouts.app')
@section('content')
<div class="row" style="max-width: 100%">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
        <button  class="btn btn-info">Action<i class="fa-solid fa-caret-down"></i></button>
        <button class="btn btn-info">Refresh <i class="fa-solid fa-arrows-rotate"></i></button>
        <button class="btn btn-info"  id="btn-search" data-bs-toggle="dropdown" aria-expanded="false">
          Search <i class="fa-solid fa-magnifying-glass"></i>
      </button> 
      <div class="dropdown-menu  dropdown-menu-center" aria-labelledby="btn-search" style="width:40%">               
              <form action="{{route('users.index')}}" method="GET" class="search-form">
                  @csrf           
                  <div class="form-group m-2">
                      <input name="search_word" type="search" class="form-control input-search" placeholder="Tìm kiếm User">
                      <button type="submit" class="btn-search"><i class=" fas fa-search"></i></button>
                  </div>
                 
              </form>
        </div>
          <div class="card-tools">
           <a href="{{route('users.create')}}" class="btn btn-success"><i class="fa-solid fa-file-circle-plus"></i> Create</a>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Info User</th>
                <th>Avatar</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $value => $user)
              <tr>
                <td>{{$value + $users->firstItem() }}</td>
                <td>
                  <p><strong>User_name:</strong> {{$user->user_name}}</p>                
                  <p><strong>Email:</strong> {{$user->email}}</p>                
                  <p><strong>Name:</strong> {{$user->last_name.' '.$user->first_name}}</p>                
                  <p><strong>Birthday:</strong> {{$user->birthday}}</p>                      
                  <p><strong>Address:</strong>
                     {{-- {{$user->address.'-'.$user->commune->name.'-'.$user->district->name.'-'.$user->province->name}} --}}
                    </p>                               
                </td>
                <td>    
                   <img class="show-avatar" src="{{ asset('/upload/user_images/'.$user->avatar) }}" alt="avatar">
                </td>
                <td>{{$user->status}}</td>
                <td>
                    <a href="{{route('users.edit',$user->id)}}" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                    <form action="{{route('users.destroy',$user->id)}}" method="post" style="display: inline-block">
                      @csrf
                      @method('delete')
                      <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                    </form>
                </td>
               
              </tr>
              @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
{{ $users->links() }}
      <!-- /.card -->
    </div>
  </div>
@endsection