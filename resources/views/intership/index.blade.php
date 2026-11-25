@extends('layout.admin')

@section('content')
<div class="main-wrapper">
@include('include.header')
@include('include.sidebar')

<div class="page-wrapper">
<div class="content">

<h3 class="mb-3">Letter Type  </h3>

<div class="card shadow-sm">
<div class="card-header d-flex justify-content-between align-items-center">
<h5 class="mb-0">Letter List</h5>
<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
+ Add LetterHead
</button>
</div>

<div class="card-body">
<table class="table table-bordered">
<thead>
<tr>
<th>#</th>
<th>Paitent Name</th>
<th>Time Period</th>
<th>Pronoun</th>
<th width="150">Action</th>
</tr>
</thead>
<tbody>
@foreach($internships as $i=>$in)
<tr>
<td>{{ $i+1 }}</td>
<td>{{ $in->student_details }}</td>
<td>{{ $in->training_period }}</td>
<td>{{ $in->pronoun }}</td>
<td>
<a href="{{ url('internships/view/'.$in->id) }}" class="btn btn-info btn-sm" target="_blank">View</a>
<button class="btn btn-success btn-sm editBtn" data-id="{{ $in->id }}">Edit</button>
<button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $in->id }}">Delete</button>
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

 ADD MODAL 
<div class="modal fade" id="addModal">
<div class="modal-dialog">
<div class="modal-content">
<form id="addForm">@csrf

<div class="modal-header">
<h5>Add letterHead</h5>
</div>

<div class="modal-body">

<div class="mb-2">
<label>Paitent Name</label>
<textarea class="form-control" name="student_details" required></textarea>
</div>

<div class="mb-2">
<label>Time Period</label>
<input type="text" class="form-control" name="training_period" placeholder="01-08-2025 to 21-08-2025" required>
</div>

<div class="mb-2">
<label>Pronoun</label>
<select class="form-control" name="pronoun">
<option>She</option>
<option>He</option>
</select>
</div>

</div>

<div class="modal-footer">
<button class="btn btn-success">Save</button>
</div>

</form>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

$('#addForm').submit(function(e){
e.preventDefault();

$.post("{{ url('internships/store') }}", $(this).serialize(), function(){
 Swal.fire('Saved','Added successfully','success').then(()=>location.reload());
});
});

$('.editBtn').click(function(){
 let id=$(this).data('id');

 $.get("{{ url('internships/edit') }}/"+id,function(r){
   $('#edit_id').val(r.id);
   $('#edit_student_details').val(r.student_details);
   $('#edit_training_period').val(r.training_period);
   $('#edit_pronoun').val(r.pronoun);

   $('#editModal').modal('show');
 });
});

$('.deleteBtn').click(function(){
 let id=$(this).data('id');

 if(confirm('Delete this record?')){
   window.location="{{ url('internships/delete') }}/"+id;
 }
});

</script>
@endsection
