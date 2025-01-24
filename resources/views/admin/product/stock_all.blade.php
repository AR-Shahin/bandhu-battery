@extends("admin.layouts.master")

@section("title","Product")

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
                $route = route("admin.products.create");
            @endphp

            <x-ui.card-top-add
            heading="Stock"
            permission="admin-create"
            :route="$route"
            :permissions="$permissions"
            />

                <hr>
                <div class="table-responsive text-center">
                    <table class="table table-sm table-bordered data-table">
                        <thead class="text-center">
                            <tr >
                                <th class="text-center">Date</th>
                                <th class="text-center">Product</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Flag</th>
                                <th class="text-center">Single Price</th>
                                <th class="text-center">Total Price</th>
                                <th class="text-center">Remark</th>
                                <th class="text-center">Admin</th>
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

initFilterDataTable("{{ route('admin.products.stock_all') }}",[
            {data: 'created_at', name: 'created_at'},
            {data: 'product.name', name: 'product.name'},
            {data: 'stock', name: 'stock'},
            {data: 'flag', name: 'flag'},
            {data: 'single_price', name: 'single_price'},
            {data: 'price', name: 'price'},
            {data: 'remarks', name: 'remarks'},
            {data: 'admin.name', name: 'admin.name'}

        ],

        );
</script>
@endpush
