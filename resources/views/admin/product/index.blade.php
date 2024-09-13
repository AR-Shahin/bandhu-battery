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
                <h3>Manage Product</h3>
                <hr>
                <div class="table-responsive text-center">
                    <table class="table table-sm table-bordered data-table">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Brand</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Actions</th>
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

initalizeDatatable("{{ route('admin.categories.index') }}",[
            { data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
            {data: 'name', name: 'name'},
            {data: 'parent.bn_name', name: 'parent', 'orderable': false, 'searchable': false},
            {data: 'status', name: 'status'},
            {data: 'actions', name: 'actions'},
        ]);
</script>
@endpush
