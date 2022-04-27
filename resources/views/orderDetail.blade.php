@extends('layouts.app')
@section('content')
<div class="container" style="width:500px; text-align:center; margin-top:20px">
    <table class="table table-hover table table-bordered">
        <tr>
        <th>Times</th>
        <th>Order Time</th>
    </tr>
            <tbody>
                @foreach ($orderDetail as $detail)
                <tr>
                <td>{{ $detail->count }}</td>
                <td>{{ $detail->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
            
        </table>
        <div class="d-flex" style="justify-content: center">
            {{ $orderDetail->links() }}
        </div>
</div>
@endsection