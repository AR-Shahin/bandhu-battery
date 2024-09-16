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

initalizeDatatable("{{ route('admin.orders.index') }}",[
            {data: 'invoice_id', name: 'invoice_id'},
            {data: 'customer.name', name: 'customer'},
            {data: 'quantity', name: 'quantity'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'admin.name', name: 'admin'},
            {data: 'actions', name: 'actions'},
        ]);
</script>
@endpush
