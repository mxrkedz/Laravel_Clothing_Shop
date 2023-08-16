<!DOCTYPE html>
<html>

<head>
    <title>Order Confirmation</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        h1, h2 {
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid black;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tfoot th {
            text-align: right;
            
        }
    </style>
</head>

<body>
    <h1>Thank you for your order!</h1>
    <h2>Here are the details:</h2>
    <p>Order ID: {{ $order->id }}</p>
    <p>Order Date: {{ $order->created_at }}</p>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($order->items as $orderItem)
            <tr>
                <td>{{ $orderItem->item_name }}</td>
                <td>{{ $orderItem->pivot->quantity }}</td>
                <td>PHP {{ $orderItem->sellprice }}</td>
                <td>PHP {{ $orderItem->pivot->quantity * $orderItem->sellprice }}</td>
                @php $total += $orderItem->pivot->quantity * $orderItem->sellprice; @endphp
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total:</th>
                <td>PHP {{ $total }}</td>
            </tr>
        </tfoot>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
