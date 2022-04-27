@extends('layouts.app')
@section('content')


<div class="container" style="width:400px">
    <form action="{{ url('cookFood') }}" method="POST">
    @csrf
    <select class="mb-2" style="height:28px" name="food_id" required>
        <option value="0">Choose a food</option>
    @foreach ($foods as $food)
    <option value="{{ $food->id }}">{{ $food->name }}</option>
    @endforeach
    </select>
    <input type="hidden" value{{ $food->id }}>
    <input type="number" min="0" max="10" style="height:28px; margin-left:20px; width:30%" name="amount" /> 
    <button class="btn btn-outline-info btn-sm ml-3" type="submit">Make Food</button>
    </form>


    <form action="{{ route('returnProduct') }}" method="POST">
    @csrf
        @if (Session::has('success'))
        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('warning'))
    <div class="alert alert-warning" role="alert">{{ Session::get('warning') }}</div>
@endif
    @if (Session::has('danger'))
    <div class="alert alert-danger" role="alert">{{ Session::get('danger') }} </div>
    @endif
  @if($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
       
      </ul>
  </div>
  @endif

        <table class="table table-bordered" style="text-align:center">
            <tr>
                <th>Name</th>
                <th>Amount</th>
            </tr>
    
                @foreach ($kitchens as $kitchen)
                <tr>
                    <td>{{ $kitchen->product->name }}</td> 
                   
                    <td><input type="text" style="height:20px; width:100px"  value="{{ $kitchen->total }}" name="name[{{ $kitchen->product_id }}]">  {{ $kitchen->product->unit->name  }}
                  
                    </td>
                </tr>
                @endforeach
            </table>
            <div style="text-align: center">
            <button class="btn btn-outline-primary" type="submit">Return Products</button>
            <a href="{{ route('fridge') }}" class="btn btn-outline-danger">Back</a>
        </div>
    </form>
 
    </div>
</div>
@endsection

