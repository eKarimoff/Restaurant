@extends('layouts.app')
@section('content')
<h3 style="text-align: center; margin-top:5px">Food Ingredients</h3>
<div class="container" style="width:500px">
    <div class="col-sm-12 my-auto">
    <table class="table table-striped table-hover mt-3" >
      
    @foreach ($details as $detail)
            
        <td style="text-align: center"> {{ $detail->product->name }} {{ $detail->portion }} {{ $detail->product->unit->name }}</td>
        <td>{{ $detail->portion * $detail->product->productPrice->price /1000 }}</td>
    </tr>

    @endforeach
    <td>{{ $total / 10 }}$</td>
 
</table>
<div style="text-align: center">
    <a href="{{ route('menu') }}" class="btn btn-outline-danger">Back</a>
</div>
</div>
@endsection