<!DOCTYPE html>
<html>
    <head>
        <title>Order Confirmation</title>
    </head>
    <body>
        <h1>Order Confirmation</h1>
        <p>Customer Name: {{ $order->customer_name }}</p>
        <p>Order ID: {{ $order->id }}</p>
        <p>Order Date: {{ $order->created_at }}</p>
        <p>Total: {{ $order->total }}</p>
        
        <hr>
        <table style="color:red; justify-content:left; border:1px solid black; padding: 10px; width: 80%; text-align:center">
            <thead>
                <tr>
                
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderlines as $item)
                    <tr>
                        
                        <td>{{ $item->items->item_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->items->sellprice }}</td>
                        <td>{{ $item->items->sellprice * $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Total: {{$order->total}}</p>
    </body>
    <style>
        .table{
            width:7cm; height:15cm; border: 1px solid;
        page-break-after: always;
        margin: 6cm auto;
        }
        </style>
</html>