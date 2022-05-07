@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @foreach ($tables as $table)
        <div class="col-md-3" >
                <a href="#" class="btn btn-outline-info m-3" style="border: 2px solid black; border-radius:50%; padding:35px; ">No_{{ $table->number }}</a>
                <div class="d-flex ml-4">
                      Order Your Table 
                </div> 
        </div>
        @endforeach
    </div>
</div>
@endsection