<x-app-layout>
    <div id="wrapper">
        @include('sidenav.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('sidenav.navbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center my-4">
                        <h2>All Bets</h2>
                        <div>
                            <!-- Export Button -->
                            <a href="{{ route('bets.showAll', array_merge(request()->all(), ['export' => 'excel'])) }}"
                                class="btn btn-success">Export to Excel</a>
                        </div>
                    </div>

                    <!-- Search and Sort Form -->
                    <form method="GET" action="{{ route('bets.showAll') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control" placeholder="Search by sensor data or game table">
                            </div>
                            <div class="col-md-3">
                                <select name="sort_by" class="form-control">
                                    <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Sort by ID
                                    </option>
                                    <option value="game_table_id"
                                        {{ request('sort_by') == 'game_table_id' ? 'selected' : '' }}>Sort by Game Table
                                    </option>
                                    <option value="total_bet_amount"
                                        {{ request('sort_by') == 'total_bet_amount' ? 'selected' : '' }}>Sort by Bet
                                        Amount</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="sort_direction" class="form-control">
                                    <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>
                                        Ascending</option>
                                    <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>
                                        Descending</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Search & Sort</button>
                            </div>
                        </div>
                    </form>

                    <!-- Bets Table -->
                    @if ($bets->isEmpty())
                        <p>No bets found.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <a
                                            href="{{ route('bets.showAll', array_merge(request()->all(), ['sort_by' => 'id', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            ID
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="{{ route('bets.showAll', array_merge(request()->all(), ['sort_by' => 'game_table_id', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Game Table
                                        </a>
                                    </th>
                                    <th>Sensor Data</th>
                                    <th>
                                        <a
                                            href="{{ route('bets.showAll', array_merge(request()->all(), ['sort_by' => 'total_bet_amount', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Total Bet Amount
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bets as $bet)
                                    <tr>
                                        <td>{{ $bet->id }}</td>
                                        <td>{{ $bet->gameTable->name ?? 'N/A' }}</td>
                                        <td>{{ $bet->sensor_data }}</td>
                                        <td>{{ $bet->total_bet_amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination with search and sort state persistence -->
                        <div class="d-flex justify-content-center">
                            {{ $bets->appends(request()->all())->links() }}
                        </div>
                    @endif
                </div>
                <!-- /.container-fluid -->

            </div>
            @include('sidenav.footer')
        </div>
    </div>
</x-app-layout>
