@extends('layout.admin')

@section('content')
<div class="main-wrapper">
@include('include.header')
@include('include.sidebar')

<div class="page-wrapper">
<div class="content">

<h3 class="mb-3">Patient Follow Up Card</h3>

<div class="card">
<div class="card-header d-flex justify-content-between">
<h5>Follow Up List</h5>
<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
+ Add Follow Up
</button>
</div>

<div class="card-body">
<table class="table table-bordered table-hover">
<thead class="table-light">
<tr>
<th>S.no</th>
<th>IP No</th>
<th>OP No</th>
<th>Name</th>
<th>Address</th>
<th>Status</th>
<th>Feedback</th>
<th width="120">Action</th>
</tr>
</thead>
<tbody>
@foreach($followups as $i=>$f)
<tr>
<td>{{ $i+1 }}</td>
<td>{{ $f->ip_number }}</td>
<td>{{ $f->op_number }}</td>
<td>{{ $f->name }}</td>
<td>{{ $f->address }}</td>
<td>{{ $f->status }}</td>
<td>{{ $f->feedback }}</td>
<td class="text-center">

<button class="btn btn-sm btn-success editBtn" data-id="{{ $f->id }}">
Edit
</button>

<button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $f->id }}">
Delete
</button>

</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>

</div>
</div>
</div>

<!-- ================= ADD MODAL ================= -->

<div class="modal fade" id="addModal">
<div class="modal-dialog">
<div class="modal-content">

<form id="addForm">@csrf

<div class="modal-header">
<h5>Add Follow Up</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<select class="form-control patient-search" name="patient_id" id="patient_id" required>
<option value="">Search Patient IP...</option>
@foreach($patients as $p)
<option value="{{ $p->id }}">
{{ $p->ip_number }} - {{ $p->name }}
</option>
@endforeach
</select>

<input class="form-control mt-2" id="name" readonly placeholder="Name">

<textarea class="form-control mt-2" id="address" readonly placeholder="Address"></textarea>
<input class="form-control mt-2" 
       id="op_no" 
       name="op_no" 
       placeholder="OP No">

<input class="form-control mt-2" name="status" placeholder="Status" required>
<textarea class="form-control mt-2" name="feedback" placeholder="Feedback" required></textarea>

</div>

<div class="modal-footer">
<button class="btn btn-success">Save</button>
</div>

</form>
</div>
</div>
</div>

<!-- ================= EDIT MODAL ================= -->

<div class="modal fade" id="editModal">
<div class="modal-dialog">
<div class="modal-content">

<form id="editForm">@csrf
<input type="hidden" id="edit_id">

<div class="modal-header">
<h5>Edit Follow Up</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<select class="form-control patient-search-edit" id="edit_patient_id">
<option value="">Search Patient IP...</option>
@foreach($patients as $p)
<option value="{{ $p->id }}">
{{ $p->ip_number }} - {{ $p->name }}
</option>
@endforeach
</select>

<input class="form-control mt-2" id="edit_name" readonly>



<textarea class="form-control mt-2" id="edit_address" readonly></textarea>
<input class="form-control mt-2" 
       id="edit_op_no" 
       name="op_no">

<input class="form-control mt-2" id="edit_status">
<textarea class="form-control mt-2" id="edit_feedback"></textarea>

</div>

<div class="modal-footer">
<button class="btn btn-primary">Update</button>
</div>

</form>
</div>
</div>
</div>

<!-- ================= SCRIPTS ================= -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function(){

$('.patient-search').select2({ width:'100%', dropdownParent: $('#addModal') });
$('.patient-search-edit').select2({ width:'100%', dropdownParent: $('#editModal') });

$('#patient_id').change(function(){
 $.get("{{ url('get-patient') }}/"+this.value,r=>{
   $('#name').val(r.name);
   $('#address').val(r.present_address);
   $('#op_no').val(r.op_number);
 });
});

$('#edit_patient_id').change(function(){
 $.get("{{ url('get-patient') }}/"+this.value,r=>{
   $('#edit_name').val(r.name);
   $('#edit_address').val(r.present_address);
   $('#edit_op_no').val(r.op_number);
 });
});

/* ADD */
$('#addForm').submit(function(e){
e.preventDefault();
$.post("{{ url('followups/store') }}",$(this).serialize(),()=>{
 Swal.fire('Saved!','Follow up added','success').then(()=>location.reload());
});
});

/* EDIT OPEN */
$('.editBtn').click(function(){
 $.get("{{ url('followups/edit') }}/"+$(this).data('id'),r=>{
   $('#edit_id').val(r.id);
   $('#edit_patient_id').val(r.patient_id).trigger('change');
   $('#edit_op_no').val(r.op_number);
   $('#edit_status').val(r.status);
   $('#edit_feedback').val(r.feedback);
   new bootstrap.Modal('#editModal').show();
 });
});


/* UPDATE */
$('#editForm').submit(function(e){
e.preventDefault();
$.post("{{ url('followups/update') }}/"+$('#edit_id').val(),{
 _token:"{{ csrf_token() }}",
 patient_id: $('#edit_patient_id').val(),
 op_no: $('#edit_op_no').val(),
 status: $('#edit_status').val(),
 feedback: $('#edit_feedback').val()
},()=>{

 Swal.fire('Updated!','Follow up updated','success').then(()=>location.reload());
});
});

/* DELETE */
$('.deleteBtn').click(function(){
let id=$(this).data('id');

Swal.fire({
 title:'Delete?',
 text:'This follow up will be removed',
 icon:'warning',
 showCancelButton:true,
 confirmButtonText:'Yes Delete'
}).then((r)=>{
 if(r.isConfirmed){
   window.location="{{ url('followups/delete') }}/"+id;
 }
});
});

});
</script>

@endsection
