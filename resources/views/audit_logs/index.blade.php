<x-app-layout>
    <div id="wrapper">
        @include('sidenav.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('sidenav.navbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center my-4">
                        <h2>All Logs</h2>
                        <div>
                            <!-- Export Button -->
                            <a href="{{ route('audit_logs.index', array_merge(request()->all(), ['export' => 'excel'])) }}" class="btn btn-success">Export to Excel</a>
                        </div>
                    </div>

                    <!-- Search and Sort Form -->
                    <form method="GET" action="{{ route('audit_logs.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by user, event, or details">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" placeholder="Start Date">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" placeholder="End Date">
                            </div>
                            <div class="col-md-2">
                                <select name="sort_by" class="form-control">
                                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Sort by Date</option>
                                    <option value="user_id" {{ request('sort_by') == 'user_id' ? 'selected' : '' }}>Sort by User</option>
                                </select>
                            </div>
                            {{-- <div class="col-md-2">
                                <select name="sort_direction" class="form-control">
                                    <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                    <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                                </select>
                            </div> --}}
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Search & Sort</button>
                            </div>
                        </div>
                    </form>

                    <!-- Logs Table -->
                    @if ($logs->isEmpty())
                        <p>No Logs found.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Event</th>
                                    <th>Details</th>
                                    <th>IP Address</th>
                                    <th>
                                        <a href="{{ route('audit_logs.index', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Date
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <td>{{ $log->user ? $log->user->name : 'Guest' }}</td>
                                        <td>{{ $log->event_type }}</td>
                                        <td>{{ $log->details }}</td>
                                        <td>{{ $log->ip_address }}</td>
                                        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination with search and sort state persistence -->
                        <div class="d-flex justify-content-center">
                            {{ $logs->appends(request()->all())->links() }}
                        </div>
                    @endif
                </div>
                <!-- /.container-fluid -->

            </div>
            @include('sidenav.footer')
        </div>
    </div>
</x-app-layout>
