@extends('layouts.usersnav')
@extends('layouts.app')

@section('content')
<!-- Start Datatable -->
<div class="container mt-2">
    <h3 class="text">Resolved tickets</h3>
    <table id="resolvedtable" class="table table-bordered resolved-table">
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
<div class="modal fade" id="ViewTicket" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Resolved Tickets</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
                <input type="text" id="view_id" hidden>
                <form>
                    <div class="form-group">
                        <label for="status" class="col-form-label">Status</label>
                        <input type="text" class="form-control" id="mStatus" readonly>
                      </div>
                    <div class="form-group">
                      <label for="lastname" class="col-form-label">Status</label>
                      <textarea type="text" class="form-control" id="mRemarks" readonly></textarea>
                    </div>
                </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!-- End View Ticket Modal -->
<!-- End Datatable -->
@endsection

@section('script')
<script>
    $(document).ready(function() {
    
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      
      var table = $('.resolved-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.usersResolved') }}",
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
        $('#resolvedtable').on ('click', '.view', (function (e) {
        e.preventDefault();
        var view_id = $(this).attr('id');
        $('#ViewTicket').modal('show')

            $.ajax({
                type: "GET",
                url: "edit/"+view_id,
                dataType: "json",
                success: function (response) {
                    $('#mStatus').val(response.tickets.status),
                    $('#mRemarks').val(response.tickets.remarks)
                }
            });
        }));
    });
</script>
@endsection