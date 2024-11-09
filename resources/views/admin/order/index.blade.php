@extends("admin.layouts.master")

@section("title","অর্ডার")

@push("css")
<x-utility.datatable-css/>
@endpush

@section("master_content")

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.orders.index') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Customer</label>
                            <select name="customer" id="customer" class="form-control select2">
                                <option value="">Select an Item</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected($customer->id == request("customer"))>{{ $customer->name }} ({{ $customer->phone }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Product Code</label>
                            <select name="product" id="code" class="form-control select2">
                                <option value="">Select an Item</option>
                                @foreach ($codes as $code)
                                    <option value="{{ $code->id }}" @selected($code->id == request("product"))>({{ $code->code ?? '-' }}) - {{ $code->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Date Range : </label> <br>
                                <input type="hidden" name="from_date" id="from_date" value="{{ request("from_date") }}">
                                <input type="hidden" name="to_date" id="to_date"  value="{{ request("to_date") }}">
                                <input type="text" class="form-control w-100" name="daterange" value="{{ request('daterange') }}" />
                            </div>
                        </div>
                        <div class="col-md-3 align-self-center">
                            <button class="btn btn-sm btn-success mt-4">Search</button>
                            <a class="btn btn-sm btn-info mt-4" href="{{ route('admin.orders.index') }}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @php
                $route = route("admin.orders.create");
            @endphp

            <x-ui.card-top-add
            heading="অর্ডার ম্যানেজ করুন"
            permission="admin-create"
            :route="$route"
            :permissions="$permissions"
            />

                <hr>
                <div class="table-responsive text-center">
                    <table class="table table-sm table-bordered data-table">
                        <thead class="text-center">
                            <tr >
                                <th class="text-center">ইনভয়েস নং</th>
                                <th class="text-center">গ্রাহক</th>
                                <th class="text-center">পরিমাণ</th>
                                <th class="text-center">অবস্থা</th>
                                <th class="text-center">তারিখ</th>
                                <th class="text-center">অর্ডার নিয়েছে</th>
                                <th class="text-center">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@stop

@push("script")

<x-utility.datatable-js/>

<script>

initFilterDataTable("{{ route('admin.orders.index') }}",[
            {data: 'invoice_id', name: 'invoice_id'},
            {data: 'customer.name', name: 'customer.name'},
            {data: 'quantity', name: 'quantity'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'admin.name', name: 'admin.name'},
            {data: 'actions', name: 'actions'},
        ],
        {
            customer : $("#customer").val(),
            from_date : $("#from_date").val(),
            to_date : $("#to_date").val(),
            product : $("#code").val(),
        }
        );
</script>

@push('script')
    <script>
        $("#customer,#code").on("change",function(){
            $("#filterForm").submit()
        });
    </script>
@endpush
@endpush
