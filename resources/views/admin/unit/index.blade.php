@extends("admin.layouts.master")

@section("title","Unit")

@push(
    "css"
)
<x-utility.datatable-css/>
@endpush

@section("master_content")

<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="card">
            <div class="card-body">
                <h3>Manage Unit</h3>
                <hr>
                <div class="table-responsive text-center">
                    <table class="table table-sm table-bordered data-table">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="col-sm-12 col-md-4">
        <div class="card">
            <div class="card-body">
                <h3>Create Unit</h3>
                <form action="{{ route('admin.units.store') }}" method="POST">
                    @csrf
                    <x-form.input label="En Name" type="text" name="en_name" placeholder="Enter en_name" id="en_name"/>
                    <x-form.input label="Bn Name" type="text" name="bn_name" placeholder="Enter bn_name" id="bn_name"/>

                    <x-form.submit/>
                </form>
            </div>
        </div>
    </div>
</div>
@stop


@push("script")

<x-utility.datatable-js/>

<script>

initalizeDatatable("{{ route('admin.units.index') }}",[
            { data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
            {data: 'name', name: 'name'},
            {data: 'actions', name: 'actions'},
        ]);
</script>
@endpush
