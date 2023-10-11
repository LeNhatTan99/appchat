@extends('users.layouts.app')
@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('order.order-detail') }}</h3>
        </div>
    </div>
  
<div class="px-5">
    <div class="row">
        <div class="col-2">
            <strong class="pr-2"> {{ __('order.code-orders') }}:</strong>
        </div>
        <div class="col-10">
            <p>{{ $order->id }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <strong class="pr-2"> {{ __('order.customer') }}:</strong>
        </div>
        <div class="col-10">
            <p>{{__('order.name')}}: {{ $order->customer->full_name }}</p>
            <p>{{__('order.address')}}: {{ $order->customer->commune->name.'-'.$order->customer->district->name.'-'.$order->customer->province->name  }}</p>
            <p>{{__('order.email')}}: {{$order->customer->email}}</p>
            <p>{{__('order.phone')}}: {{$order->customer->phone}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <p><strong> {{ __('order.product') }}:</strong> </p>
        </div>
        <div class="col-2">
            @foreach ($order->orderDetails as $orderDetail)
            {{ $orderDetail->product->name }}  <span class="px-4"><br>
            @endforeach
        </div>
        <div class="col-2">
            @foreach ($order->orderDetails as $orderDetail)
            {{ __('order.quantity') }} : {{ $orderDetail->quantity }}</span> <br>
            @endforeach
        </div>
        <div class="col-2">
            @foreach ($order->orderDetails as $orderDetail)
            {{ __('order.price') }} : {{ number_format($orderDetail->price) }}&#8363;</span> <br>
            @endforeach
        </div>
        <div class="col-2">
            @foreach ($order->orderDetails as $orderDetail)
            {{ __('order.status') }} : {{ $orderDetail->status }}</span> <br>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <strong class="pr-2"> {{ __('order.total') }}:</strong>
        </div>
        <div class="col-10">
            <p>{{ number_format($order->total) }}&#8363;</p>
        </div>
    </div>
     <a href="{{ route('orderDetail.exportPdf',$order->id) }}" class="btn btn-success my-4">
        <i class="fa-solid fa-download nav-icon"></i> {{ __('order.export') }} PDF</a>
</div>
            
                    
                                     
@endsection
