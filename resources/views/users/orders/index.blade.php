@extends('users.layouts.app')
@section('content')
    <div class="row" style="max-width: 100%">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-info">{{__('order.action') }}<i class="fa-solid fa-caret-down"></i></button>
                    <button class="btn btn-info">{{__('order.refresh') }}<i class="fa-solid fa-arrows-rotate"></i></button>
                    <button class="btn btn-info">{{__('order.search') }}<i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{__('order.customer')}}</th>
                                <th>{{__('order.quantity')}}</th>
                                <th>{{__('order.total')}}</th>
                                <th>{{__('order.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $value => $order)
                                <tr>
                                    <td>{{ $value + $orders->firstItem() }}</td>
                                    <td>{{ $order->customer->full_name }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>{{ number_format($order->total) }}&#8363;</td>
                                    <td>
                                        <a class="btn btn-info" href="{{route('orders.show',$order->id)}}">
                                            <i class="fa-solid fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            {{ $orders->links() }}
            <!-- /.card -->
        </div>
    </div>
@endsection
