@extends('layouts.app')
@section('content')

<h3 style="text-align: center; margin:15px;font-family: Arial">Menu</h3>
    <div class="container" style="width:700px">
        @hasrole('chef|waiter')
        <form action="menu" method="GET" >
       <div class="d-flex justify-content-between">
        <div class="input-group mb-2" style="width:570px; border:1px solid;" >
            <input type="text" class="form-control border-0 rounded" required name="search" id="search" placeholder="Search foods..." aria-label="Username" aria-describedby="basic-addon1" style="border-radius:10px" >
            <div>
              <button type="submit" style="border:none;" ><span class="input-group-text border-0" id="basic-addon1" ><i class="bi bi-search" style="font-size:21px; "></i></button></span>
            </div>
        </div>
        </form>
        <div>
            <a href="#" class="btn btn-outline-success mb-2" style="float: right" data-toggle="modal"
                data-target="#exampleModal">Add Food</a>
            </div>
       </div>
            @endhasrole
        <form action="orderStore" method="POST">
            <table class="table table-bordered " >
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
                @if (Session::has('danger'))
                <div class="alert alert-danger" role="alert">{{ Session::get('danger') }} </div>
                @endif
                @if (Session::has('warning'))
                <div class="alert alert-warning" role="alert">{{ Session::get('warning') }} </div>
                @endif
                <tr>
                    <th style="text-align: center">Name</th>
                    
                    <th style="text-align: center">Made Price</th>
                    <th style="text-align: center">Selling Price</th>
                    <th style="text-align: center">Benefit</th>
                    <th style="text-align: center">Available</th>
                    <th style="text-align: center">Count</th>
                </tr>
                <tbody>
                    @foreach ($foods as $food)
                    <tr>
                        <td><a style="color:black;text-decoration:none" href="{{ route('ingredient', ['id' => $food->id]) }}">{{ $food->name }} <i class="bi bi-arrow-right ml-2"></i></a></td>
                        <td style="text-align: center">{{ $food->made_price /10 }}$</td>
                        
                        <td style="text-align: center"><a href="{{ route('editPrice',['id'=>$food->id]) }}"><i class="bi bi-pencil"></i></a> {{ $food->price }}$</td>
                        <td style="text-align: center;{{ $food->price - $food->made_price /10 <0 ? 'color:red' : 'color:green'}}">
                        {{ $food->price - $food->made_price /10 <0 ? $food->price - $food->made_price /10 : $food->price - $food->made_price /10}}$</td>

                            <td style=" text-align: center;{{ $food->preparedFood && $food->preparedFood->amount ? 'color:green' : 'color:red' }}">
                                {{$food->preparedFood && $food->preparedFood->amount ? $food->preparedFood->amount : 'Not Available'}}</td>
                            <td>
                                <input type="number" min="1" max="10" style="float: right; width:40px; height:20px;" id="{{ $food->name }}"
                                disabled value="amount" name="name[{{ $food->id }}]" required>
                                <input type="checkbox" style="float: right; margin-right:5px; width:20px; height:20px;"
                                id="{{ $food->name }}" onchange="show(event)" value="{{ $food->id }}">
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div style="text-align: center">
                <button class="btn btn-outline-success mb-2" >Order</button>
                <a href="{{ route('menu') }}" class="btn btn-outline-danger mb-2">back</a>
            </div>
           
        </form>

        <div class="d-flex" style="justify-content:center">
            {{ $foods->links() }}
        </div>
    </div>

    <form method="POST" action="addFood">
        @csrf
        @method('POST')
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Food</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="d-flex justiy-content-between">
                            <input type="text" class="form-control" placeholder="Food name" name="name" style="width:90%">
                            <button type="button" class="btn btn-dark ml-2" onclick="myFunction()">+</button>
                        </div>
                        <div id="add"></div>
                    </div>
                    <div class="modal-footer">
                        <div id="total"> </div>
                        <button class="btn btn-primary">Insert</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
@endsection

<script>
  

    function show(event) {
        var inputName = document.getElementById(event.target.id)
        inputName.disabled = !event.target.checked
    }
    var index = 0;
    var array = {!! json_encode($products->toArray()) !!};


    
   var found = '';
    function removeId(value) {
        var result = array.findIndex(item => item.name == value)
     found = array.filter(item => item.id == result+1);
        
        array.splice(result, 1)
        console.log(event.target,found[0])
    }
    var acc = 0;
    function total(value) {
        var price = document.getElementById("total");
        var res = value / found[0].product_price.price;
        acc = res + acc;

         price.innerText = 'Total: '+ acc.toFixed(2) + ' $'
    console.log(found[0].product_price.price)
 }

    function myFunction() {
       
        if (array.length > 1) {
            var add = document.getElementById('add')
            var form = []

            var selectList = document.createElement("select");
            selectList.id = "mySelect";
            selectList.setAttribute("name", `form[${index}][product_id]`);
            selectList.setAttribute("class", "form-control");
            selectList.setAttribute("onchange", "removeId(value)");
            add.appendChild(selectList);

            for (var i = 0; i < array.length; i++) {
                var option = document.createElement("option");
                
                option.value = array[i]['name'];
                option.text = array[i]['name'];
                selectList.appendChild(option);

            }

            var x = document.createElement("INPUT");

            x.setAttribute("type", "text");
            x.setAttribute("class", "form-control");
            x.setAttribute("placeholder", "Food ingredient");
            x.setAttribute("onchange", "total(value)");
            x.setAttribute("name", `form[${index}][portion]`);

            add.appendChild(x);
            index++;
            console.log(form)
        }
    }

   

</script>

