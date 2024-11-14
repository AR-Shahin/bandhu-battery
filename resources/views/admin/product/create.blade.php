@extends("admin.layouts.master")

@section("title","Product Create")
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
                    <div><h3>Product Create</h3></div>
                    <div>
                        @if (in_array("admin-create",$permissions))
                        <a href="{{ route("admin.products.index") }}" class="btn btn-sm btn-success"><i class="fa fa-angle-left"></i> Back</a>
                        @endif
                    </div>
                </div>
                <hr>

                <form action="{{ route("admin.products.store") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <x-form.input label="Name" type="text" name="name" placeholder="Enter name" id="name"/>
                        </div>
                        <div class="col-md-3">
                            <x-form.input label="Stock" type="number" name="stock" placeholder="Enter stock" id="stock"/>
                        </div>
                        <div class="col-md-3">
                            <x-form.input label="Price" type="number" name="price" placeholder="Enter price" id="price"/>
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Code" type="text" name="code" placeholder="Enter Code" id="code"/>
                        </div>
                        <div class="col-md-3">
                            <x-form.select
                            label="Category"
                            name="category_id"
                            id="category_id"
                            :items="$categories"
                            />
                        </div>

                        <div class="col-md-3">
                            <x-form.select
                            label="Brand"
                            name="brand_id"
                            id="brand_id"
                            :items="$brands"
                            />
                        </div>
                        <div class="col-md-3">
                            <x-form.select
                            label="Unit"
                            name="unit_id"
                            id="unit_id"
                            :items="$units"
                            />
                        </div>
                        <div class="col-md-3">
                            <x-form.select
                            label="Vendor"
                            name="vendor_id"
                            id="vendor_id"
                            :items="$vendors"
                            />
                        </div>

                        <div class="col-md-12">
                            <x-form.textarea label="Description" name="des" placeholder="Description" id="des"  />
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
