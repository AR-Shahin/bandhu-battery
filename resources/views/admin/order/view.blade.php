@extends("admin.layouts.master")

@section("title","Order View")

@push("css")
<style>
    /* Hide additional content on the web */
    .print-only {
        display: none;
    }

    /* Show additional content only when printing */
    @media print {
        .print-only {
            display: block;
        }

        /* Optionally, hide web-only content during print */
        .no-print {
            display: none;
        }
    }
</style>
@endpush

@section("master_content")

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-body p-3">
                @php
                $route = route("admin.orders.index");
                $heading = "অর্ডার ডিটেলস  : #$sell->invoice_id"
                @endphp

                <x-ui.card-top-back
                    :heading="$heading"
                    permission="admin-create"
                    :route="$route"
                    :permissions="$permissions"
                />
                <hr>
                <a href="javascript:void(0);" class="btn btn-sm btn-success mb-2" onclick="printDiv()"><i class="fa fa-print"></i> প্রিন্ট</a>
                <a href="{{ route('admin.orders.edit',$sell->id) }}" class="btn btn-sm btn-info mb-2" ><i class="fa fa-edit"></i> আপডেট</a>

                <!-- Wrap the section you want to print in a div -->
                <div id="printableArea">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <th>ক্রেতার নাম</th>
                                    <td class="text-center">{{ $sell->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>ইমেইল</th>
                                    <td class="text-center">{{ $sell->customer->email }}</td>
                                </tr>
                                <tr>
                                    <th>ফোন</th>
                                    <td class="text-center">{{ $sell->customer->phone }}</td>
                                </tr>
                                <tr>
                                    <th>ফোন ২</th>
                                    <td class="text-center">{{ $sell->customer->phone_2 }}</td>
                                </tr>
                                <tr>
                                    <th>ঠিকানা</th>
                                    <td class="text-center">{{ $sell->customer->address }}</td>
                                </tr>
                                <tr>
                                    <th>ক্রেতার তারিখ</th>
                                    <td class="text-center">{{ $sell->customer->created_at?->format("D-M-Y") }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <th>ইনভয়েস আইডি</th>
                                    <td class="text-center">{{ $sell->invoice_id }}</td>
                                </tr>
                                <tr>
                                    <th>অবস্থা</th>
                                    <td class="text-center">{{ $sell->status }}</td>
                                </tr>
                                <tr>
                                    <th>অর্ডারের তারিখ</th>
                                    <td class="text-center">{{ $sell->created_at->format("d-M-Y H:i:s") }}</td>
                                </tr>
                                <tr>
                                    <th>পরিমাণ</th>
                                    <td class="text-center">{{ $sell->quantity }}</td>
                                </tr>
                                <tr>
                                    <th>মন্তব্য</th>
                                    <td class="text-center">{{ $sell->remarks }}</td>
                                </tr>
                                <tr>
                                    <th>অর্ডার করেছেন</th>
                                    <td class="text-center">{{ $sell->admin->name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body p-3">
                            <table class="table table-sm table-bordered text-center">
                                <tr>
                                    <th>ক্রমিক</th>
                                    <th>পণ্যের নাম</th>
                                    <th>পরিমাণ</th>
                                </tr>

                                @foreach ($sell->details as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End of printable area -->
            </div>
        </div>


    </div>
</div>

@stop

@push("script")

<script>
    function printDiv() {
        var printContents = document.getElementById("printableArea").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

@endpush
