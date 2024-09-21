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
        <x-filter.product-filter
         :brands="$brands"
         :units="$units"
         :vendors="$vendors"
         />
        <div class="card">
            <div class="card-body">
                @php
                $route = route("admin.products.create");
            @endphp

            <x-ui.card-top-add
            heading="Manage Products"
            permission="admin-create"
            :route="$route"
            :permissions="$permissions"
            />

                <hr>
                <div class="table-responsive text-center">
                    <table class="table table-sm table-bordered data-table">
                        <thead class="text-center">
                            <tr >
                                <th class="text-center">Name</th>
                                <th class="text-center">Code</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Brand</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Vendor</th>
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

initFilterDataTable("{{ route('admin.products.index') }}",[
            {data: 'name', name: 'name'},
            {data: 'code', name: 'code'},
            {data: 'stock', name: 'stock'},
            {data: 'category.bn_name.', name: 'category.bn_name'},
            {data: 'brand.bn_name.', name: 'brand.bn_name'},
            {data: 'unit.bn_name.', name: 'unit.bn_name'},
            {data: 'vendor.name.', name: 'vendor.name'},
            {data: 'actions', name: 'actions'},
        ],
        {
            vendor : $("#vendor").val(),
            unit : $("#unit").val(),
            brand : $("#brand").val(),
        }
        );
</script>
@endpush
