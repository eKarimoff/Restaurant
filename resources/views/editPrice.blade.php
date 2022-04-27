@extends('layouts.app')
@section('content')
<div class="container" style="text-align:center; width:500px">
    @if (Session::has('success'))
                <div class="alert alert-success" role="alert">{{ Session::get('success') }} </div>
                @endif
    <form  action="{{ url('updatePrice',['id'=>$price->id]) }}" method="POST" >
        @csrf
      <div class="form-group">
          <label for="">Food Name</label> 
          <input type="hidden" value="{{ $price->id }}">
          <input type="text" class="form-control" readonly value="{{ $price->name }}">
          <label for="">Food Price</label> 
          <input type="text" class="form-control" name="price" value="{{ $price->price }}">
        </div>
        <div class="d flex">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('menu') }}" class="btn btn-danger">Back</a>
        </div>
    </form>
</div>
@endsection