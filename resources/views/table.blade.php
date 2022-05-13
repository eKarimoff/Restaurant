@extends('layouts.app')
@section('content')
<div class="container">
    <form action="{{ route('menu') }}" method="POST">
        @csrf
    <div class="row">
        @foreach ($tables as $table)
        <div class="col-md-3" >
                <a href="{{ route('menu', $table->id) }}" class="btn btn-outline-info m-3" style="border: 2px solid black; border-radius:50%; padding:35px; ">No_{{ $table->number }}</a>
                <input type="hidden" value="{{ $table->id }}" name="id">
                <div class="d-flex ml-4">
                Order Your Table 
                </div>
     
        </div>
        @endforeach
    </div>
</form>
</div>
@endsection