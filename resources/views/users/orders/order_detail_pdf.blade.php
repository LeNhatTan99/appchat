
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: "dejavu sans", serif;
        }
    </style>
</head>

<body>
    
    <h2 style="margin: auto">{{__('order.order-detail')}}</h2>
    <p><strong class="pr-2"> {{ __('order.code-orders') }}:</strong>  {{ $order->id }}</p>
        <div class="col-2">
            <strong class="pr-2"> {{ __('order.customer') }}:</strong>
        </div>  
            <p>{{__('order.name')}}: {{ $order->customer->full_name }}</p>
            <p>{{__('order.address')}}: {{ $order->customer->commune->name.'-'.$order->customer->district->name.'-'.$order->customer->province->name  }}</p>
            <p>{{__('order.email')}}: {{$order->customer->email}}</p>
            <p>{{__('order.phone')}}: {{$order->customer->phone}}</p>  
        <div class="col-2">
            <p><strong> {{ __('order.product') }}:</strong> </p>
        </div>
        <div class="col-2">
            @foreach ($order->orderDetails as $orderDetail)
            {{ $orderDetail->product->name }}  <span class="px-4">
                {{ __('order.quantity') }} : {{ $orderDetail->quantity }}
                {{ __('order.price') }} : {{ $orderDetail->price }}đ;
                {{ __('order.status') }} : {{ $orderDetail->status }} <br>
            @endforeach
        </div>
        <p><strong class="pr-2"> {{ __('order.total') }}:</strong>
            {{ $order->total }}đ</p>
 
</body>

</html>

