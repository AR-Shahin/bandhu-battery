@extends("admin.layouts.master")

@section("title","Order Create")
@push(
    "css"
)

@endpush
@section("master_content")
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <div><h3>Order Create</h3></div>
                    <div>
                        @if (in_array("admin-create",$permissions))
                        <a href="{{ route("admin.orders.index") }}" class="btn btn-sm btn-success"><i class="fa fa-angle-left"></i> Back</a>
                        @endif
                    </div>
                </div>
                <hr>

                <form action="{{ route("admin.orders.store") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-3">
                            <x-form.select
                            label="Customer"
                            name="customer_id"
                            id="customer_id"
                            :items="$customers"
                            />
                        </div>



                    </div>
                    <x-form.submit/>

                </form>
            </div>
        </div>
    </div>
</div>

@stop


@push("script")


@endpush
