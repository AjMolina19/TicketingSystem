{{-- Start Tabele navigation var --}}
<div class="container mt-5">
    <div class="row justify-content-md-center">
        <div class="card col-md-10">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item ">
                  <a class="{{ Request::path() === 'admin/adminopen' ? 'nav-link active' : 'nav-link'}}" href="{{ route('admin.adminOpen') }}">Open Ticket</a>
                </li>
                <li class="nav-item">
                  <a class="{{ Request::path() === 'admin/adminassigned' ? 'nav-link active' : 'nav-link'}}" href="{{ route('admin.adminAssigned') }}">Assigned Ticket</a>
                </li>
                <li class="nav-item">
                  <a class="{{ Request::path() === 'admin/adminresolved' ? 'nav-link active' : 'nav-link'}}" href="{{ route('admin.adminResolved') }}">Resolved Ticket</a>
                </li>
                <li class="nav-item">
                  <a class="{{ Request::path() === 'admin/adminarchieved' ? 'nav-link active' : 'nav-link'}}" href="{{ route('admin.adminArchieved') }}">Archieved Ticket</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
                @yield('content')
            </div>
        </div>
    </div>
</div>
{{-- Start Tabele navigation var --}}
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>