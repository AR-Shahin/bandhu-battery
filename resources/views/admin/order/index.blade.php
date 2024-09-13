@extends("admin.layouts.master")

@section("title","Order")

@push(
    "css"
)
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
            heading="Manage Orders"
            permission="admin-create"
            :route="$route"
            :permissions="$permissions"
            />

                <hr>
                <div class="table-responsive text-center">
                    <table class="table table-sm table-bordered data-table">
                        <thead class="text-center">
                            <tr >
                                <th class="text-center">Invoice No</th>
                                <th class="text-center">Customer</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Placed By</th>
                                <th class="text-center">Actions</th>
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
