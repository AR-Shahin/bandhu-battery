@extends("admin.layouts.master")

@section("title","Product Stock")

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
                @php
                $route = route("admin.products.index");
            @endphp

            <x-ui.card-top-back
            heading="Product Stock History"
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
                                <th class="text-center">Stock</th>
                                <th class="text-center">Flag</th>
                                <th class="text-center">Remark</th>
                                <th class="text-center">Added By</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <hr>
                <h6>বর্তমান স্টক : <b>{{ $product->stock }}</b></h6>
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h3>Stock Adjust</h3>
                <hr>
                <form action="{{ route("admin.products.stock_adjust",$product->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Stock</label>
                        <input type="number" class="form-control" name="stock" min="0" placeholder="Stock">
                    </div>
                    <div class="form-group">
                        <label for="">Flag</label>
                        <select name="flag" id="" class="form-control">
                            <option value="">Select Option</option>
                            <option value="add">যোগ করুন</option>
                            <option value="remove">বিয়োগ করুন</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Remark</label>
                        <textarea name="remarks" id="" cols="30" rows="2" class="form-control"></textarea>
                    </div>
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

initalizeDatatable("{{ route('admin.products.stock',$product->id) }}",[
            {data: 'created_at', name: 'created_at'},
            {data: 'stock', name: 'stock'},
            {data: 'flag', name: 'flag'},
            {data: 'remarks', name: 'remarks'},
            {data: 'admin.name', name: 'admin'},
        ]);
</script>
@endpush
