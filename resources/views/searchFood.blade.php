@extends('layouts.app')
@section('content')
<div class="container" style="width:500px">
    <table class="table table-bordered">

        <tr>
            <th>Name</th>
            <th>Amount</th>
        </tr>
        <tr>
            @foreach ($search as $food)
                
            <td>{{ $food->name }}</td>
            @endforeach
        </tr>



    </table>
</div>

@endsection