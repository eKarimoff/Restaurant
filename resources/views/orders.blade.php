@extends('layouts.app')
@section('content')
<h3 style="text-align:center; margin:15px;font-family: Arial">Orders</h3>

<div class="container" style="width:500px; text-align:center">
    <table class="table table-hover table table-bordered">
        <tr>
        <th>Food Name</th>
        <th>Order Amount</th>
    </tr>
        <tbody>
                @foreach ($orders as $order)
             <tr>
                   <td><a href="{{ route('orderDeatil',['id' => $order->food->id])}}" style="text-decoration: none; color:black">{{ $order->food->name }}<i class="bi bi-arrow-right ml-2"></i></a></td>
                   <td>{{ $order->total }}</td>
            </tr>
                @endforeach
              
        </tbody>
    </table>
    <div class="d-flex" style="justify-content:center">
        {{ $orders->links() }}
    </div>
</div>
@endsection