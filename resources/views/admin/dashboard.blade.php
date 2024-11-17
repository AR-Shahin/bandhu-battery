@extends("admin.layouts.master")
@section("title","Dashboard")
@push('css')
<style>
   .chart_container {
   display: flex;
   justify-content: center;
   align-items: center;
   }
</style>
@endpush
@section("master_content")
<div style="overflow: hidden">
    <div class="row">
        <div class="col-lg-3 col-6" bis_skin_checked="1">
            <div class="small-box bg-dark" bis_skin_checked="1">
               <div class="inner" bis_skin_checked="1">
                  <h4>{{ convert_eng_to_bn_number($products['totalAmountOfMoney']) }} TK</h4>
                  <p>{{ bn_to_en($products['totalAmountOfMoney'])}} টাকা</p>
               </div>
               <div class="icon" bis_skin_checked="1">
                  <i class="ion ion-bag"></i>
               </div>
               <a href="{{ route('admin.products.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>

    </div>
<div class="card">
   <div class="card-body text-center">
      <a href="{{ route('admin.orders.create') }}" class="btn btn-sm btn-primary">অর্ডার করুন </a>
      <form action="{{ route("admin.backup") }}" method="POST" class="d-inline-block mx-2 mb-2">
      @csrf
      <button class="btn btn-sm btn-success"><i class="fas fa-trash-restore-alt mr-1"></i> Backup Site Data</button>
      </form>
      <form action="{{ route("admin.backup_db") }}" method="POST" class="d-inline ">
      @csrf
      <button class="btn btn-sm btn-info"><i class="fas fa-trash-restore-alt mr-1"></i> Database Backup Only</button>
      </form>
   </div>
</div>
<div class="row" bis_skin_checked="1">
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-md-6 border p-3">
               <div class="d-flex">
                  <h4>আজকের দিনের বিক্রি </h4>
               </div>
               <table class="table table-sm table-bordered text-center">
                  <tr>
                     <th>ক্রমিক</th>
                     <th>ইনভয়েস নং</th>
                     <th>স্টক</th>
                     <th>ইনভয়েস</th>
                  </tr>
                  @foreach ($today_sells as $sell)
                  <tr>
                     <td>{{ $loop->index + 1 }}</td>
                     <td>{{ $sell->invoice_id }}</td>
                     <td>{{ $sell->quantity }}</td>
                     <td><a href="{{ route('admin.orders.view',$sell->id) }}" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a></td>
                  </tr>
                  @endforeach
               </table>
               {{ $today_sells->links() }}
            </div>
            <div class="col-md-6 border p-3">
               <h4>সীমিত স্টক পণ্য</h4>
               <table class="table table-sm table-bordered text-center">
                  <tr>
                     <th>ক্রমিক</th>
                     <th>পণ্যের নাম</th>
                     <th>স্টক</th>
                  </tr>
                  @foreach ($warning_products as $product)
                  <tr>
                     <td>{{ $loop->index + 1 }}</td>
                     <td>{{ $product->name }}</td>
                     <td>{{ $product->stock }}</td>
                  </tr>
                  @endforeach
               </table>
            </div>
            <div class="col-md-6 border p-3">
               <h4>বেশি বিক্রিত পণ্য </h4>
               <table class="table table-sm table-bordered text-center">
                  <tr>
                     <th>ক্রমিক</th>
                     <th>পণ্যের নাম</th>
                     <th>বর্তমান স্টক</th>
                     <th>টোটাল ইনভয়েস</th>
                  </tr>
                  @foreach ($top_products as $product)
                  <tr>
                     <td>{{ $loop->index + 1 }}</td>
                     <td>{{ $product->name }}</td>
                     <td>{{ $product->stock }}</td>
                     <td>{{ $product->sells_count }}</td>
                  </tr>
                  @endforeach
               </table>
            </div>
            <div class="col-md-6 border p-3">
               <h4>টপ গ্রাহক  </h4>
               <table class="table table-sm table-bordered text-center">
                  <tr>
                     <th>ক্রমিক</th>
                     <th>গ্রাহকের নাম</th>
                     <th>টোটাল ইনভয়েস  </th>
                  </tr>
                  @foreach ($top_customers as $customer)
                  <tr>
                     <td>{{ $loop->index + 1 }}</td>
                     <td>{{ $customer->name }}</td>
                     <td>{{ $customer->sells_count }}</td>
                  </tr>
                  @endforeach
               </table>
            </div>
            <div class="col-md-6 text-center align-self-center border p-3 chart_container">
               <div id="chart"></div>
            </div>
            <div class="col-md-6 border p-3 ">
               <div id="bar"></div>
            </div>
         </div>
      </div>
   </div>
</div>
@stop
@push("script")
<script>
   var options = {
     series: @json($products["stocks"]),
     chart: {
     width: 380,
     type: 'pie',
   },
   title: {
   text: 'পণ্যের স্টকের বন্টন',  // Add your chart title here
   align: 'center',                     // Alignment of the title
   style: {
   fontSize: '16px',                  // Style for the title (size, color, etc.)
   fontWeight: 'bold'
   }
   },
   legend: {
   show: false // This disables the legend
   },
   labels: @json($products["names"]),
   responsive: [{
     breakpoint: 480,
     options: {
       legend: {
         position: 'bottom'
       }
     }
   }]
   };

   var chart = new ApexCharts(document.querySelector("#chart"), options);
   chart.render();


   var barOp = {
     series: [{
       name: "Desktops",
       data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
   }],
     chart: {
     height: 350,
     type: 'line',
     zoom: {
       enabled: false
     }
   },
   dataLabels: {
     enabled: false
   },
   stroke: {
     curve: 'straight'
   },
   title: {
     text: 'Product Trends by Month',
     align: 'left'
   },
   grid: {
     row: {
       colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
       opacity: 0.5
     },
   },
   xaxis: {
     categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
   }
   };

   var bar = new ApexCharts(document.querySelector("#bar"), barOp);
   bar.render();
</script>
@endpush
