@extends("admin.layouts.master")

@section("title","Dashboard")

@section("master_content")
<div style="overflow: hidden">
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
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 border p-3">
                    <h4>আজকের দিনের বিক্রি   </h4>
                    <table class="table table-sm table-bordered text-center">
                        <tr>
                            <th>ক্রমিক</th>
                            <th>পণ্যের নাম</th>
                            <th>স্টক</th>
                        </tr>
                        @foreach ($waring_products as $product)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->stock }}</td>
                            </tr>
                        @endforeach
                    </table>

                </div>
                <div class="col-md-6 border p-3">
                    <h4>সীমিত স্টক পণ্য</h4>
                    <table class="table table-sm table-bordered text-center">
                        <tr>
                            <th>ক্রমিক</th>
                            <th>পণ্যের নাম</th>
                            <th>স্টক</th>
                        </tr>
                        @foreach ($waring_products as $product)
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
                            <th>স্টক</th>
                        </tr>
                        @foreach ($waring_products as $product)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->stock }}</td>
                            </tr>
                        @endforeach
                    </table>

                </div>
                <div class="col-md-6 border p-3">
                    <h4>টপ ক্রেতা  </h4>
                    <table class="table table-sm table-bordered text-center">
                        <tr>
                            <th>ক্রমিক</th>
                            <th>পণ্যের নাম</th>
                            <th>স্টক</th>
                        </tr>
                        @foreach ($waring_products as $product)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->stock }}</td>
                            </tr>
                        @endforeach
                    </table>

                </div>
                <div class="col-md-6 align-self-center border p-3">
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
          series: [44, 55, 13, 43, 22],
          chart: {
          width: 380,
          type: 'pie',
        },
        legend: {
    show: false // This disables the legend
  },
        labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
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
