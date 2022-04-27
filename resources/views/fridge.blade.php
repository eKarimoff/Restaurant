@extends('layouts.app')
@section('content')

<div class="container" style="width:400px">
    <table class="table table-bordered" style="text-align:center">
        <thead>
            <tr>
                <th>Days | Product amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dailys as $daily)
            <tr>
                <td><a href="{{ route('makeFood',['day'=> $daily->date]) }}" style="color:black; text-decoration:none">{{ $daily->date }} <i class="bi bi-arrow-right"></i> </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection