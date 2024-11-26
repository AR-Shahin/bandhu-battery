@extends("admin.layouts.master")

@section("title","Order Edit")
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
                    <div><h3>Order Edit</h3></div>
                    <div>
                        @if (in_array("admin-create",$permissions))
                        <a href="{{ route("admin.orders.index") }}" class="btn btn-sm btn-success"><i class="fa fa-angle-left"></i> Back</a>
                        @endif
                    </div>
                </div>
                <hr>

                <form action="{{ route("admin.orders.update",$sell->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row gutters-1">
                        <div class="col-md-3">
                            <x-form.select
                            label="গ্রাহক"
                            name="customer_id"
                            id="customer_id"
                            :items="$customers"
                            :value="$sell->customer_id"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-form.textarea rows="1" label="মন্তব্য" name="remark" :value="$sell->remarks" id="remark" />
                        </div>
                        <div class="col-md-2 align-self-center">
                            <div class="form-group">
                                <label for="">ইনভয়েস নং</label>
                                <input type="text" class="form-control" readonly value="{{ $sell->invoice_id }}">
                            </div>
                        </div>
                        <div class="col-md-1 align-self-center">
                            <div class="form-group">
                                <label for="">পরিমাণ</label>
                                <input type="text" class="form-control" readonly value="{{ $sell->quantity }}">
                            </div>
                        </div>
                    </div>

                    <table class="table table-sm" id="orderTable">
                        <tr>
                            <td width="20%">
                                <label for="">পণ্য</label>
                                <select name="products[]" class="form-control select2 ">
                                    <option value="">Select</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} - ({{ $product->stock }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td width="20%">
                                <label for="">পরিমাণ</label>
                                <input type="number" min="1" class="form-control" name="quantites[]">
                            </td>
                            <td width="20%">
                                <label for="">তারিখ</label>
                                <input type="date" value="{{ date("Y-m-d") }}"   class="form-control" name="dates[]">
                            </td>
                            <td width="50%">
                                <label for="">কোড</label>
                                <textarea class="form-control" name="product_codes[]" id="" cols="30" rows="1"></textarea>
                            </td>
                            <td width="20%" class="text-right">
                                <button class="btn btn-sm btn-success mt-4 addNewRow"><i class="fa fa-plus"></i></button>
                            </td>
                        </tr>
                    </table>
                    <x-form.submit text="Update"/>
                </form>

                <hr>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>পণ্য</th>
                        <th>পরিমাণ</th>
                        <th>তারিখ</th>
                        <th>কোড</th>
                        <th>আপডেট/ ডিলিট  </th>
                    </tr>
                    @php
                    $total = 0
                     @endphp
                    @foreach ($sell->details as $item)

                    <form action="{{ route('admin.orders.update_quantity',$item->id) }}" class="d-inline" method="POST">
                        @csrf
                        @php
                            $total += $item->quantity
                        @endphp
                        <tr>
                            <td width="20%">
                               <input type="text" class="form-control form-control-sm" value="{{ $item->product->name }}" readonly>
                            </td>
                            <td width="20%">
                                <input type="number" min="1" class="form-control form-control-sm" name="quantity" value="{{ $item->quantity }}">
                            </td>
                            <td width="20%">
                                <input type="date"  class="form-control form-control-sm" name="date" value="{{ $item->date?->format('Y-m-d') }}">
                            </td>
                            <td width="50%">
                                <textarea class="form-control" name="product_codes" id="" cols="30" rows="1">{{ $item->product_codes }}</textarea>
                            </td>
                            <td width="20%" class="text-center">
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-success">আপডেট</button>
                                </form>
                                <form action="{{ route('admin.orders.delete_quantity',$item->id) }}" class="d-inline" method="POST">
                                    @csrf
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">ডিলিট</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="text-center">
                        <td>টোটাল</td>
                        <td><b>{{ $total }}</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@stop


@push("script")

<script>
    $(document).ready(function () {

// Function to update the product options in all rows
function updateProductOptions() {
    // Get all selected products
    var selectedProducts = [];
    $('select[name="products[]"]').each(function () {
        var selectedValue = $(this).val();
        if (selectedValue) {
            selectedProducts.push(selectedValue);
        }
    });

    // Update each product dropdown
    $('select[name="products[]"]').each(function () {
        var $select = $(this);
        $select.find('option').each(function () {
            var value = $(this).val();
            if (selectedProducts.includes(value) && value !== $select.val()) {
                $(this).prop('disabled', true); // Disable the option if it's already selected
            } else {
                $(this).prop('disabled', false); // Enable it otherwise
            }
        });
    });

    // Hide "Add New Row" button if all products are selected
    var totalProducts = $('select[name="products[]"] option').length - 1; // Exclude the "Select" option
    var selectedProductsCount = $('select[name="products[]"]').length;

    if (selectedProductsCount >= totalProducts) {
        $('.addNewRow').hide(); // Hide the button when all products are selected
    } else {
        $('.addNewRow').show(); // Show the button when there are products available
    }
}

// Add new row
$(document).on('click', '.addNewRow', function (e) {
    e.preventDefault();

    var newRow = `
        <tr>
            <td width="20%">
                <select name="products[]" class="form-control select2">
                    <option value="">Select</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} - ({{ $product->stock }})</option>
                    @endforeach
                </select>
            </td>
            <td width="20%">
                <input type="number" min="1" class="form-control" name="quantites[]">
            </td>
              <td width="20%">
                                <input type="date" value="{{ date("Y-m-d") }}"  class="form-control" name="dates[]">
                            </td>
                <td width="50%">
                <textarea class="form-control" name="product_codes[]" id="" cols="30" rows="1"></textarea>
            </td>
            <td width="20%" class="text-right">
                <button class="btn btn-sm btn-danger mt-4 removeRow"><i class="fa fa-minus"></i></button>
            </td>
        </tr>
    `;
    $('#orderTable').append(newRow); // Append the new row to the table
    updateProductOptions(); // Update the options when a new row is added
});

// Remove row
$(document).on('click', '.removeRow', function (e) {
    e.preventDefault();
    $(this).closest('tr').remove(); // Remove the closest tr (row)
    updateProductOptions(); // Update the options after removing a row
});

// Update the options when a product is selected
$(document).on('change', 'select[name="products[]"]', function () {
    updateProductOptions();
});

// Initial check on page load to ensure the button visibility is correct
updateProductOptions();
});

</script>
@endpush
