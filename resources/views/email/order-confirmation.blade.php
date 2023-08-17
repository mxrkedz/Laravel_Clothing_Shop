<!DOCTYPE html>
<html>

<head>
    <title>Order Successful!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <h1>Thank you for your order!</h1>
    <h2>Here are the details:</h2>
    <p>Order ID: {{ $order->id }}</p>
    <p>Date: {{ $order->created_at }}</p>
    @php $total = 0 @endphp
    @foreach ($order->items as $orderItems)
        @php $total +=  $orderItems->sellprice * $orderItems->pivot->quantity @endphp
    @endforeach
    <h2>Total : ₱ {{ number_format($total, 2) }}</h2>
    <br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
