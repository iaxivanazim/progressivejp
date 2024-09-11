<x-app-layout>
    <div id="wrapper">
        @include('sidenav.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('sidenav.navbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1>House Commissions</h1>

                    <!-- Export and Create Buttons -->
                    <div class="row d-flex justify-content-between align-items-center mb-3">
                        <div class="col-md-10">
                            <form method="GET" action="{{ route('house_commissions.index') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class="form-control" placeholder="Search by Bet ID or Commission Amount...">
                                    </div>

                                    <!-- Date Range Filter -->
                                    <div class="col-md-2">
                                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                                            class="form-control" placeholder="Start Date">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                                            class="form-control" placeholder="End Date">
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Search & Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('house_commissions.index', array_merge(request()->all(), ['export' => 'excel'])) }}"
                                class="btn btn-success">Export to Excel</a>
                        </div>
                    </div>

                    <!-- Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <a
                                        href="{{ route('house_commissions.index', array_merge(request()->all(), ['sort_by' => 'id', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                        ID
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ route('house_commissions.index', array_merge(request()->all(), ['sort_by' => 'bet_id', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                        Bet ID
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ route('house_commissions.index', array_merge(request()->all(), ['sort_by' => 'commission_amount', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                        Commission Amount
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ route('house_commissions.index', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                        Created At
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commissions as $commission)
                                <tr>
                                    <td>{{ $commission->id }}</td>
                                    <td>{{ $commission->bet_id }}</td>
                                    <td>{{ $commission->commission_amount }}</td>
                                    <td>{{ $commission->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination with search and sort state persistence -->
                    <div class="d-flex justify-content-center">
                        {{ $commissions->appends(request()->all())->links() }}
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            @include('sidenav.footer')
        </div>
    </div>
</x-app-layout>
