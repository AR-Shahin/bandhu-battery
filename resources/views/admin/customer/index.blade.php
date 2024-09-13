@extends("admin.layouts.master")

@section("title","Customer")

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
                <h3>Manage Customer</h3>
                <hr>
                <div class="table-responsive text-center">
                    <table class="table table-sm table-bordered data-table">
                        <thead class="text-center">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Phone 2</th>
                                <th>Address</th>
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
                <h3>Create Customer</h3>
                <form action="{{ route('admin.customers.store') }}" method="POST">
                    @csrf
                    <x-form.input label="Name" type="text" name="name" placeholder="Enter name" id="name"/>
                    <x-form.input label="Email" type="text" name="email" placeholder="Enter email" id="email"/>
                    <x-form.input label="Phone" type="text" name="phone" placeholder="Enter phone" id="phone"/>
                    <x-form.input label="Phone 2" type="text" name="phone_2" placeholder="Enter phone_2" id="phone_2"/>
                    <x-form.textarea label="Address" type="text" placeholder="Address" name="address" id="address"/>

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

initalizeDatatable("{{ route('admin.customers.index') }}",[
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'phone_2', name: 'phone_2'},
            {data: 'address', name: 'address'},
            {data: 'actions', name: 'actions'},
        ]);
</script>
@endpush
