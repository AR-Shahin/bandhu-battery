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
                        <div class="col-md-6">
                            <x-form.textarea rows="1" label="Remark" name="remark" placeholder="Remark" id="remark" />
                        </div>
                        <div class="col-md-3 align-self-center text-center">
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#customerModal">নতুন কাস্টমার যোগ করুন</button>
                        </div>
                    </div>
                    <div id="orderTable">
                        <div class="row no-gutterns my-1">
                            <div class="col-md-3">
                                <label for="">পণ্য</label>
                                <select name="products[]" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} - ({{ $product->stock }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="">পরিমাণ</label>
                                <input type="number" min="1" class="form-control" name="quantites[]">
                            </div>

                            <div class="col-md-2">
                                <label for="">তারিখ</label>
                                <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="dates[]">
                            </div>
                            <div class="col-md-4">
                                <label for="">কোড</label>
                                <textarea class="form-control" name="product_codes[]" id="" cols="30" rows="1"></textarea>
                            </div>
                            <div class="col-md-1 text-right ">
                                <button class="btn btn-sm btn-success mt-4 addNewRow"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    {{-- <table class="table table-sm" id="orderTable">
                        <tr>
                            <td width="20%">
                                <label for="">পণ্য</label>
                                <select name="products[]" class="form-control select2">
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
                                <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="dates[]">
                            </td>
                            <td width="50%">
                                <label for="">কোড</label>
                                <textarea class="form-control" name="product_codes[]" id="" cols="30" rows="1"></textarea>
                            </td>
                            <td width="20%" class="text-right">
                                <button class="btn btn-sm btn-success mt-4 addNewRow"><i class="fa fa-plus"></i></button>
                            </td>
                        </tr>
                    </table> --}}
                    <x-form.submit/>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- The Modal -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="customerModalLabel">Add New Customer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Modal Body with Form -->
        <form action="{{ route('admin.customers.store') }}" method="POST">
        <div class="modal-body">
            @csrf
            <x-form.input label="Name" type="text" name="name" placeholder="Enter name" id="name"/>
            <x-form.input label="Email" type="text" name="email" placeholder="Enter email" id="email"/>
            <x-form.input label="Phone" type="text" name="phone" placeholder="Enter phone" id="phone"/>
            <x-form.input label="Phone 2" type="text" name="phone_2" placeholder="Enter phone_2" id="phone_2"/>
            <x-form.textarea label="Address" type="text" placeholder="Address" name="address" id="address"/>

        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Customer</button>
        </div>
    </form>
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
                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="dates[]">
                </td>
            <td width="50%">
                <textarea class="form-control" name="product_codes[]" id="" cols="30" rows="1"></textarea>
            </td>
            <td width="20%" class="text-right">
                <button class="btn btn-sm btn-danger mt-4 removeRow"><i class="fa fa-minus"></i></button>
            </td>
        </tr>
    `;
    var row = `
           <div class="row no-gutterns mb-1">
                            <div class="col-md-3">
                                <select name="products[]" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} - ({{ $product->stock }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" min="1" class="form-control" name="quantites[]">
                            </div>

                            <div class="col-md-2">
                                <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="dates[]">
                            </div>
                            <div class="col-md-4">
                                <textarea class="form-control" name="product_codes[]" id="" cols="30" rows="1"></textarea>
                            </div>
                            <div class="col-md-1 text-right ">
                            <button class="btn btn-sm btn-danger mt-4 removeRow"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
    `;
    $('#orderTable').append(row); // Append the new row to the table
    updateProductOptions(); // Update the options when a new row is added
});

// Remove row
$(document).on('click', '.removeRow', function (e) {
    e.preventDefault();

    $(this).parent().parent().remove(); // Remove the closest tr (row)
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
