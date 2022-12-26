{{-- Start Tabele navigation var --}}
<div class="container mt-5">
    <div class="row">
        <div class="card col-12" style="width: 60%;">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item ">
                  <a class="nav-link " href="/users/dashboard">Open Ticket</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/users/pendingticket">Pending Ticket</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/users/resolvedticket">Resolved Ticket</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/users/archievedticket">Archieved Ticket</a>
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
