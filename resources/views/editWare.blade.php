@extends('layouts.app')
@section('content')
<div class="container" style="width: 700px">
        <form action="{{ route('updateWare', ['id' =>$edit->id]) }}" method="POST">
@csrf
@method("POST")
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (Session::has('message'))
  <div class="alert alert-success" role="alert">{{ Session::get('message') }} </div>
@endif

<input type="hidden" name="id" value="{{ $edit->id }}">
        <div class="form-group">
    <label for="name" class="mt-4">Name</label>
     <input type="text" readonly class="form-control" name="name" value="{{ $edit->name }}">
     <label for="">Amount</label>
     <input type="number" class="form-control" name="amount" value="" placeholder="Amount">
     <label for="">Price</label>
     <input type="number" class="form-control" name="price" value="" placeholder="Price">
     <label for="">Unit</label>
     <input type="text" class="form-control" name="unit_id" readonly value="{{ $edit->unit->name }}">
     <div style="text-align: center" class="mt-3">
     <button class="btn btn-primary" type="submit">Update</button>
     <a class="btn btn-danger"href="{{ route('warehouse') }}">Back</a>
    </div>
    </form>

</div>
@endsection