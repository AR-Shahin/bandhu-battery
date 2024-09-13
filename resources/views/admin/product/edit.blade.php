@extends("admin.layouts.master")

@section("title","Product Edit")
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
                    <div><h3>Product Edit</h3></div>
                    <div>
                        @if (in_array("admin-create",$permissions))
                        <a href="{{ route("admin.products.index") }}" class="btn btn-sm btn-success"><i class="fa fa-angle-left"></i> Back</a>
                        @endif
                    </div>
                </div>
                <hr>

                <form action="{{ route("admin.products.update",$product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <div class="col-md-9">
                            <x-form.input label="Name" type="text" name="name" :value="$product->name" id="name"/>
                        </div>

                        <div class="col-md-3">
                            <x-form.select
                            label="Category"
                            name="category_id"
                            id="category_id"
                            :items="$categories"
                            :value="$product->category_id"
                            />
                        </div>

                        <div class="col-md-3">
                            <x-form.select
                            label="Brand"
                            name="brand_id"
                            id="brand_id"
                            :items="$brands"
                             :value="$product->brand_id"
                            />
                        </div>
                        <div class="col-md-3">
                            <x-form.select
                            label="Unit"
                            name="unit_id"
                            id="unit_id"
                            :items="$units"
                             :value="$product->unit_id"
                            />
                        </div>
                        <div class="col-md-3">
                            <x-form.select
                            label="Vendor"
                            name="vendor_id"
                            id="vendor_id"
                            :items="$vendors"
                             :value="$product->vendor_id"
                            />
                        </div>

                        <div class="col-md-12">
                            <x-form.textarea label="Description" name="des" placeholder="-" :value="$product->description" id="des"  />
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
