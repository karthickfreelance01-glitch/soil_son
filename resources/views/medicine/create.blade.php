@extends('layout.admin')
@section('content')

<style>
/* 🔥 Table Scroll + Width Fix */
.table-responsive {
    overflow-x: auto;
}

#medicineTable {
    min-width: 1300px;
}

#medicineTable th,
#medicineTable td {
    white-space: nowrap;
    vertical-align: middle;
}

/* Column widths */
.col-drug { min-width: 220px; }
.col-category { min-width: 180px; }
.col-date { min-width: 140px; }
.col-small { min-width: 110px; }
.col-action { min-width: 80px; }

/* Smooth scrollbar */
.table-responsive::-webkit-scrollbar {
    height: 8px;
}
.table-responsive::-webkit-scrollbar-thumb {
    background: #999;
    border-radius: 10px;
}
</style>

<div class="main-wrapper">
@include('include.header')
@include('include.sidebar')

<div class="page-wrapper">
<div class="content pb-0">
<div class="container-fluid">

<h3 class="text-primary fw-bold mb-4">Add Medicine</h3>

<div class="card shadow-lg rounded-4 p-4">
<form action="{{ route('medicine.store') }}" method="POST">
@csrf

<!-- Vendor -->
<div class="mb-3">
<label class="form-label fw-bold">Select Vendor</label>
<select name="vendor_id" class="form-select select2" required>
<option value="">-- Select Vendor --</option>
@foreach($vendors as $id => $name)
<option value="{{ $id }}">{{ $name }}</option>
@endforeach
</select>
</div>

<!-- TABLE -->
<div class="table-responsive">
<table class="table table-bordered text-center" id="medicineTable">

<thead class="table-primary">
<tr>
<th class="col-drug">Drug Name</th>
<th class="col-category">Category</th>
<th class="col-date">Mfg</th>
<th class="col-date">Expiry</th>
<th class="col-small">Price</th>
<th class="col-small">Selling</th>
<th class="col-small">Stock</th>
<th class="col-small">Total</th>
<th class="col-action">Action</th>
</tr>
</thead>

<tbody id="medicineRows">
<tr>

<td><input type="text" name="drug_name[]" class="form-control" required></td>

<td>
<select name="category_id[]" class="form-select select2" required>
<option value="">-- Select --</option>
@foreach($categories as $id => $name)
<option value="{{ $id }}">{{ $name }}</option>
@endforeach
</select>
</td>

<td><input type="date" name="manufactured_date[]" class="form-control" required></td>
<td><input type="date" name="expiry_date[]" class="form-control" required></td>

<td><input type="number" step="0.01" name="price[]" class="form-control price" required></td>

<td><input type="number" step="0.01" name="selling_price[]" class="form-control selling_price" ></td>

<td><input type="number" name="stock[]" class="form-control stock" required></td>

<td><input type="text" name="total_value[]" class="form-control total_value" readonly></td>

<td>
<button type="button" class="btn btn-danger btn-sm removeRow">-</button>
</td>

</tr>
</tbody>
</table>
</div>

<!-- Add Row -->
<div class="text-end mt-3">
<button type="button" class="btn btn-success btn-sm" id="addRow">+ Add Row</button>
</div>

<!-- Overall Total -->
<div class="text-end mt-3">
<label class="fw-bold">Overall Total :</label>
<input type="text" id="overall_total" class="form-control w-25 d-inline-block" readonly>
</div>

<!-- Buttons -->
<div class="text-end mt-3">
<button type="submit" class="btn btn-success">Submit</button>
<a href="{{ route('medicine.index') }}" class="btn btn-secondary">Cancel</a>
</div>

</form>
</div>

</div>
</div>
</div>
</div>

@endsection


@section('scripts')
<script>
$(document).ready(function () {

$('.select2').select2({ width: '100%' });

/* 🔥 Calculate Row */
function recalcRow(row) {
    let price = parseFloat(row.find('.price').val()) || 0;
    let stock = parseFloat(row.find('.stock').val()) || 0;

    // Selling price (20% margin)
    row.find('.selling_price').val((price * 1.20).toFixed(2));

    // Total
    let total = price * stock;
    row.find('.total_value').val(total.toFixed(2));

    recalcOverall();
}

/* 🔥 Overall Total */
function recalcOverall() {
    let total = 0;

    $('.total_value').each(function () {
        total += parseFloat($(this).val()) || 0;
    });

    $('#overall_total').val(total.toFixed(2));
}

/* Bind Events */
function bindEvents(row) {
    row.find('.price, .stock').on('input', function () {
        recalcRow(row);
    });
}

/* Initial row */
bindEvents($('#medicineRows tr'));

/* Add Row */
$('#addRow').click(function () {
    let row = $(`
    <tr>
        <td><input type="text" name="drug_name[]" class="form-control" required></td>

        <td>
            <select name="category_id[]" class="form-select select2" required>
                <option value="">-- Select --</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </td>

        <td><input type="date" name="manufactured_date[]" class="form-control" required></td>
        <td><input type="date" name="expiry_date[]" class="form-control" required></td>

        <td><input type="number" step="0.01" name="price[]" class="form-control price" required></td>

        <td><input type="number" step="0.01" name="selling_price[]" class="form-control selling_price" ></td>

        <td><input type="number" name="stock[]" class="form-control stock" required></td>

        <td><input type="text" name="total_value[]" class="form-control total_value" readonly></td>

        <td>
            <button type="button" class="btn btn-danger btn-sm removeRow">-</button>
        </td>
    </tr>
    `);

    $('#medicineRows').append(row);

    row.find('.select2').select2({ width: '100%' });

    bindEvents(row);
});

/* Remove Row */
$(document).on('click', '.removeRow', function () {
    $(this).closest('tr').remove();
    recalcOverall();
});

});
</script>
@endsection