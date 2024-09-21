
<div class="card">
    <div class="card-body">
        <div class="row gx-1">
            <div class="col-md-12">
                <form action="" id="filterForm">
                    <div class="row gutters-1">
                        <div class="col-md-3">
                            <x-form.select
                            label="Brand"
                            name="brand"
                            id="brand"
                            :items="$brands"
                            :value="request('brand')"
                            />
                        </div>
                        <div class="col-md-3">
                            <x-form.select
                            label="Vendor"
                            name="vendor"
                            id="vendor"
                            :items="$vendors"
                            :value="request('vendor')"
                            />
                        </div>

                        <div class="col-md-3">
                            <x-form.select
                            label="Unit"
                            name="unit"
                            id="unit"
                            :items="$units"
                            :value="request('unit')"
                            />
                        </div>



                        <div class="col-md-3">
                            <x-form.select
                            label="Bulk Options"
                            name="bulk_option"
                            id="bulk_option"
                            :items="[]"
                            :value="request('bulk_option')"
                            />
                        </div>
                        <div class="col-md-12">
                            @php
                                $button = '<i class="fa fa-search"></i> ' . " Search";
                            @endphp
                            <x-form.submit text="Search"/>
                            <div class="form-group d-inline">
                                <a href="{{ route('admin.products.index') }}" class="mx-1 btn btn-sm btn-secondary

                                "><i class="fas fa-redo mr-1"></i> Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $("#unit, #brand , #vendor,#bulk_option").on("change",function(){
            $("#filterForm").submit()
        });
    </script>
@endpush
