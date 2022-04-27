@extends('layouts.app')
@section('content')
<h3 style="text-align: center; margin:15px;font-family: Arial">Warehouse</h3>
<div class="container" style="width: 500px; " >
    @if (Session::has('success'))
      <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('danger'))
                    <div class="alert alert-danger" role="alert">{{ Session::get('danger') }} </div>
    @endif
     @if (Session::has('warning'))
                    <div class="alert alert-warning" role="alert">{{ Session::get('warning') }} </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
         
        </ul>
    </div>
@endif

    <a href="" class="btn btn-outline-success mb-2" style="float: right" data-toggle="modal" data-target="#exampleModal">Add Product</a>
    <form action="storeToFridge" method="POST">
      @csrf
      @if (Session::has('message'))
      <div class="alert alert-success" role="alert">{{ Session::get('message') }} </div>
  @endif
  @if (Session::has('danger'))
      <div class="alert alert-danger" role="alert">{{ Session::get('danger') }} </div>
  @endif
    @if (Session::has('error'))
    <div class="alert alert-danger" role="alert">{{ Session::get('error') }} </div>
    @endif
    <table class="table table-hover table table-bordered">
      <thead>
        <tr>
        <th>Name</th>
        <th>Price</th>
        
        <th>Products</th>
        </tr>
      </thead>
            @foreach ($products as $product)
            <tr>
            <td><a href="{{ route('editWare',['id' => $product->id]) }}"><i class="bi bi-plus-circle-fill"></i></a> {{ $product->name }} </td>
            <td>{{ $product->productPrice->price * $product->warehouse->amount / 100 }} $</td>
            <td>{{ $product->warehouse->amount }} <input type="number" id="{{ $product->id }}" disabled value="amount" name="name[{{ $product->id }}]" style="float: right; width:60px; height:20px;">
              <input type="checkbox" value="{{ $product->id}}"
              style="float: right; margin-right:5px; width:20px; height:20px;" id="{{ $product->id }}" onchange="show(event)">
              @switch($product->unit->name)
              @case('gr')
              kg
              @break
              @case('ml')
              L
              @break
              @default
              ta
              @endswitch</td>
            @endforeach
        </tr>
      </table>
      <div style="text-align:center">
        <button class="btn btn-outline-success mb-2" >Submit</button>
      </div>
    </form>
    <div class="d-flex" style="justify-content: center;">
        {{ $products->links() }}
    </div>
</div>
  
  <!-- Modal -->
  
  <form action="insertProduct" method="POST">
    @method("POST")
    @csrf

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="text"  class="form-control" placeholder="Product name" name="name" required>
            <input type="text"  class="form-control" placeholder="Product amount" name="amount" required>
            <input type="text"  class="form-control" placeholder="Product Price" name="price" required>
            <select name="unit_id" class="form-control">
                <option>Select a unit</option>
                @foreach ($units as $unit)
                    <option  value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success">Insert</button>
        </div>
      </div>
    </div>
  </div>
</form>
    
  </div>
@endsection

<script>
   function show(event) {
        var inputId = document.getElementById(event.target.id)
        inputId.disabled = !event.target.checked
    }
</script>