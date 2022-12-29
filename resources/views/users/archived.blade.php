@extends('layouts.usersnav')
@extends('layouts.app')

@section('content')
<!-- Start Datatable -->
<div class="container mt-2">
    <h3 class="text mb-5">Archived tickets</h3>
    <table id="archivedtable" class="table table-bordered archieved-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Created by</th>
                <th>Importance</th>
                <th>Title</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Submitted at</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<!-- End Datatable -->

<!-- Start View Ticket Modal -->
<div class="modal fade" id="ViewTicket" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Created Tickets</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
                <input type="text" id="view_id" hidden>
                <form>
                    <div class="form-group">
                      <label for="created_by" class="col-form-label">Created By</label>
                      <input type="text" class="form-control" id="mCreated_by" readonly>
                    </div>
                    <div class="form-group">
                      <label for="sel1">Importance:</label>
                      <select class="form-control" id="mImportance" name="importance" readonly>
                        <option>select one</option>
                        <option>Urgent</option>
                        <option>Mid</option>
                        <option>Low</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="lastname" class="col-form-label">Title</label>
                      <input type="text" class="form-control" id="mTitle" readonly>
                    </div>
                    <div class="form-group">
                      <label for="lastname" class="col-form-label">Status</label>
                      <input type="text" class="form-control" id="mStatus" readonly>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-form-label">Remarks</label>
                        <textarea type="text" class="form-control" id="mRemarks" readonly></textarea>
                      </div>
                    <div class="form-group">
                      <label for="lastname" class="col-form-label">Submitted at</label>
                      <input type="text" class="form-control" id="mCreated_at" readonly>
                    </div>
                  </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="btnReopen" class="btn btn-success">Reopen Ticket</button>
        </div>
      </div>
    </div>
  </div>
<!-- End View Ticket Modal -->

<!-- Start Validation Modal -->
<div class="modal fade" id="ValidationMessage" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Reopen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p>Your ticket has been reopen successfully!</p>
      </div>
      <div class="modal-footer">
          <a href="{{ route('users.dashboard') }}" class="btn btn-success">Go to Dashboard</a>
      </div>
    </div>
  </div>
</div>
<!-- End Validation Modal -->
@endsection

@section('script')
<script>
    $(document).ready(function() {
      
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      
      var table = $('.archieved-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.usersArchived') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'created_by', name: 'created_by'},
                {data: 'importance', name: 'importance'},
                {data: 'title', name: 'title'},
                {data: 'status', name: 'status'},
                {data: 'remarks', name: 'remarks'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        $('#archivedtable').on ('click', '.view', (function (e) {
        e.preventDefault();
        var view_id = $(this).attr('id');
        $('#view_id').val(view_id);
        $('#ViewTicket').modal('show')

            $.ajax({
                type: "GET",
                url: "editticket/"+view_id,
                dataType: "json",
                success: function (response) {
                    $('#mCreated_by').val(response.tickets.created_by),
                    $('#mImportance').val(response.tickets.importance),
                    $('#mTitle').val(response.tickets.title),
                    $('#mStatus').val(response.tickets.status),
                    $('#mRemarks').val(response.tickets.remarks),
                    $('#mCreated_at').val(response.tickets.created_at)
                }
            });
        }));

        $('#btnReopen').click(function (e) {
        e.preventDefault();
        var update_id = $('#view_id').val();
        var data = {
            'created_by' : $('#mCreated_by').val(),
            'importance' : $('#mImportance').val(),
            'title' : $('#mTitle').val(),
            'status' : 'Open',
            'created_at' : $('#mCreated_at').val()
        }
            $.ajax({
                type: "POST",
                url: "updateticket/"+update_id,
                data: data,
                dataType: "json",
                success: function (response) {
                    $('#ValidationMessage').modal('show')
                    $('#viewtable').DataTable().ajax.reload();
                }
            });
            $('#ViewTicket').modal('hide');
        });
    });
</script>
@endsection