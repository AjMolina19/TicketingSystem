@extends('layouts.adminnav')
@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <h3 class="text mb-3">Ticket Pool</h3>
    <table class="table table-bordered adminResolved_data-table" id="viewtable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Created By</th>
                <th>Importance</th>
                <th>Title</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Created At</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- Start View Ticket Modal -->
<div class="modal fade" id="ViewTicket" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Open Tickets</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="text" id="view_id" hidden>
                    <div class="form-group">
                        <label for="firstname" class="col-form-label">Created By</label>
                        <input type="text" class="form-control" id="created_by" readonly>
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="col-form-label">Importance</label>
                        <input class="form-control" id="importance" readonly>
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="col-form-label">Title</label>
                        <input type="text" class="form-control" id="title" readonly>
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="col-form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option>Open</option>
                            <option>Resolved</option>
                            <option>Archived</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="remarks" class="col-form-label">Remarks</label>
                        <textarea type="text" class="form-control" id="remarks" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-form-label">Created At</label>
                        <input type="text" class="form-control" id="created_at" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnUpdate" class="btn btn-primary">Update Ticket</button>
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
          <h5 class="modal-title" id="staticBackdropLabel">Move successfully</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h6>Your ticket has been move to Archived</h6>
        </div>
        <div class="modal-footer">
            <a href="{{ route('admin.adminArchived') }}" class="btn btn-success"> Go to Archived</a>
        </div>
      </div>
    </div>
  </div>
  <!-- End Validation Modal -->
@endsection

@section('script')

<script type="text/javascript">
  $(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    var table = $('.adminResolved_data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.adminResolved') }}",
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

    $('#viewtable').on ('click', '.view', (function (e) {
        e.preventDefault();
        var view_id = $(this).attr('id');
        $('#view_id').val(view_id);
        $('#ViewTicket').modal('show')

        $.ajax({
            type: "GET",
            url: "adminopen/"+view_id,
            dataType: "json",
            success: function (response) {
                $('#created_by').val(response.tickets.created_by);
                $('#importance').val(response.tickets.importance);
                $('#title').val(response.tickets.title);
                $('#status').val(response.tickets.status);
                $('#remarks').val(response.tickets.remarks);
                $('#created_at').val(response.tickets.created_at);
            }
        });
    }));

    $('#btnUpdate').click(function (e) {
        e.preventDefault();
        var update_id = $('#view_id').val();
        var data = {
            'created_by' : $('#created_by').val(),
            'importance' : $('#importance').val(),
            'title' : $('#title').val(),
            'status' : $('#status').val(),
            'remarks' : $('#remarks').val(),
            'created_at' : $('#created_at').val()
        }
            $.ajax({
                type: "POST",
                url: "update/"+update_id,
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