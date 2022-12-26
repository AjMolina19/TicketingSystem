{{-- Start Tabele navigation var --}}
<div class="container mt-5">
    <div class="row justify-content-md-center">
        <div class="card col-md-10">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item ">
                  <a class="{{ Request::path() === 'users' ? 'nav-link active' : 'nav-link'}}" href="{{ route('users.dashboard') }}">Open Ticket</a>
                </li>
                <li class="nav-item">
                  <a class="{{ Request::path() === 'users/pendingticket' ? 'nav-link active' : 'nav-link'}}" href="{{ route('users.usersPending') }}">Pending Ticket</a>
                </li>
                <li class="nav-item">
                  <a class="{{ Request::path() === 'users/resolvedticket' ? 'nav-link active' : 'nav-link'}}" href="{{ route('users.usersResolved') }}">Resolved Ticket</a>
                </li>
                <li class="nav-item">
                  <a class="{{ Request::path() === 'users/archievedticket' ? 'nav-link active' : 'nav-link'}}" href="{{ route('users.usersArchieved') }}">Archieved Ticket</a>
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