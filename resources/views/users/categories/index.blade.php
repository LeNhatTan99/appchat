@extends('users.layouts.app')
@section('content')
    <div class="row" style="max-width: 100%">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-info">{{__('category.action') }}<i class="fa-solid fa-caret-down"></i></button>
                    <button class="btn btn-info">{{__('category.refresh') }}<i class="fa-solid fa-arrows-rotate"></i></button>
                    <button class="btn btn-info">{{__('category.search') }}<i class="fa-solid fa-magnifying-glass"></i></button>
                    <div class="card-tools">
                        <a href="{{ route('categories.create') }}" class="btn btn-success"><i
                                class="fa-solid fa-file-circle-plus"></i> {{__('category.create-category')}}</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{__('category.name')}}</th>
                                <th>{{__('category.parent-category')}}</th>
                                <th>{{__('category.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $value => $category)
                                <tr id="delete{{ $category->id }}">
                                    <td>{{ $value + $categories->firstItem() }} </td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ optional($category->parentId)->name }}</td>                              
                                    <td>
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="post"
                                            style="display: inline-block">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#item{{ $category->id }}">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                            <div class="modal" id="item{{ $category->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">{{__('category.delete-category')}}</h4>
                                                            <button type="button" class="btn " data-bs-dismiss="modal"><i
                                                                    class="fa-solid fa-x"></i></button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            {{__('category.warning-delete-category') }}<strong>{{ $category->name }}</strong> ?
                                                        </div>
                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">

                                                            <button type="submit"
                                                                class="btn btn-danger p-2">{{__('category.delete')}}</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            {{ $categories->links() }}
            <!-- /.card -->
        </div>
    </div>
@endsection
