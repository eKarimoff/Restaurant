@extends('layouts.app')
@section('content')
<h3 style="text-align:center">Ready Foods</h3>
<div class="container" style="width:500px">
    <table class="table table-striped">
        <tr>
            <th>Name </th>
            <th>Portion </th>
        </tr>
        @foreach ($getFoods as $getFood)
        <tr>
            <td>{{ $getFood->food->name }}</td>
            <td>{{ $getFood->amount }}</td>
        </tr>
        @endforeach
    </table>
    <div class="d-flex" style="justify-content: center">
    {{ $getFoods->links() }}
    </div>
</div>
@endsection