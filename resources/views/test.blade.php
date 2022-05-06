<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container" style="width:500px; text-align:center">
    
    <h3>Thank you order with us!</h3>
    <h4>Dear Mrs/Mr.{{ auth()->user()->name }}    {{ auth()->user()->email }}</h4>
    <table class="table table-bordered">
    <tr>
        <th>Name:</th>
        <th>Count:</th>
        <th>Total:</th>
    </tr>
    @foreach ($orders as $order )
     <tr>
        <td>{{ $order['food_name'] }}</td>
        <td>{{ $order['count']}} ta</td>
        <td>{{ $order['food_price'] }}</td>
    </tr>
    @endforeach
    <h3>Total:{{ $order['count'] * $order['food_price'] }}$</h3>
    </table>
    </div>
</body>
</html>



