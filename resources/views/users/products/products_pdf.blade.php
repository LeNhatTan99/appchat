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
    <div style="text-align: center">
        <h1>List Products</h1>
        <p>Export at: {{ date('d/m/Y') }}</p>
        <table style="margin: auto">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Expired</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->expired_at }}</td>
                        @if (!empty($product->category->name))
                        <td>
                            {{ $product->category->name }}
                        </td>
                        @else <td></td>
                        @endif
                        <td>{{ date('d m Y', strtotime($product->expired_at)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
