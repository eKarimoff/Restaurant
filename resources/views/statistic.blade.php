@extends('layouts.app')
@section('content')
<h3 style="text-align:center; margin-top:15px;font-family: Arial">Statistic</h3>
<div class="container " style="width:800px" >
    <div>
        <canvas id="myChart" ></canvas>
       </div>
</div>
  <script>
     const ctx = document.getElementById('myChart').getContext('2d');
     const selection = document.getElementById('selection');
     const status  = {!! json_encode($statistic->toArray()) !!};
     var sts = []
     var total = []
     var date = []
     console.log(status)
     
     for(var i =0; i< status.length; i++) {
          sts.push(status[i].food.name)
          total.push(status[i].total)
          console.log(status[i].food.name)
          var option = document.createElement('option');
     }
     const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: sts,
        datasets: [{
            label: '# of Orders',
            data: total,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

  
@endsection