<x-app-layout>
    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('sidenav.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('sidenav.navbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Jackpot Winners</h2>
                        <div>
                            <!-- Export Button -->
                            <a href="{{ route('jackpot_winners.index', array_merge(request()->all(), ['export' => 'excel'])) }}"
                                class="btn btn-success">Export to Excel</a>
                            <a href="{{ route('jackpot_winners.create') }}" class="btn btn-primary">Add Winner</a>
                        </div>
                    </div>

                    <!-- Search and Sort Form -->
                    <form method="GET" action="{{ route('jackpot_winners.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control" placeholder="Search by jackpot, table name, sensor number...">
                            </div>
                            {{-- <div class="col-md-3">
                                <select name="sort_by" class="form-control">
                                    <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Sort by ID
                                    </option>
                                    <option value="jackpot" {{ request('sort_by') == 'jackpot' ? 'selected' : '' }}>Sort
                                        by Jackpot</option>
                                    <option value="game_table"
                                        {{ request('sort_by') == 'game_table' ? 'selected' : '' }}>Sort by Game Table
                                    </option>
                                    <option value="win_amount"
                                        {{ request('sort_by') == 'win_amount' ? 'selected' : '' }}>Sort by Win Amount
                                    </option>
                                    <option value="is_settled"
                                        {{ request('sort_by') == 'is_settled' ? 'selected' : '' }}>Sort by Settled
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="sort_direction" class="form-control">
                                    <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>
                                        Ascending</option>
                                    <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>
                                        Descending</option>
                                </select>
                            </div> --}}
                            <div class="col-md-3">
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ request('start_date') }}" placeholder="Start Date">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ request('end_date') }}" placeholder="End Date">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Search & Sort</button>
                            </div>
                        </div>
                    </form>

                    @if ($winners->isEmpty())
                        <p>No jackpot winners recorded yet.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <a
                                            href="{{ route('jackpot_winners.index', array_merge(request()->all(), ['sort_by' => 'jackpot', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Jackpot
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="{{ route('jackpot_winners.index', array_merge(request()->all(), ['sort_by' => 'game_table', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Game Table
                                        </a>
                                    </th>
                                    {{-- <th>Table Name</th> --}}
                                    <th>Hand</th>
                                    <th>Last Current Amount</th>
                                    <th>Sensor Number</th>
                                    <th>
                                        <a
                                            href="{{ route('jackpot_winners.index', array_merge(request()->all(), ['sort_by' => 'win_amount', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Win Amount
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="{{ route('jackpot_winners.index', array_merge(request()->all(), ['sort_by' => 'is_settled', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Is Settled
                                        </a>
                                    </th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($winners as $winner)
                                    <tr>
                                        <td>{{ $winner->jackpot->name }}</td>
                                        <td>{{ $winner->gameTable->name }}</td>
                                        {{-- <td>{{ $winner->table_name }}</td> --}}
                                        <td>{{ $winner->hand ? $winner->hand->name : 'N/A' }}</td>
                                        <td>{{ $winner->current_jackpot_amount }}</td>
                                        <td>{{ $winner->sensor_number }}</td>
                                        <td>{{ $winner->win_amount }}</td>
                                        <td>{{ $winner->is_settled ? 'Yes' : 'No' }}</td>
                                        <td>{{ $winner->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td>
                                            <button
                                                class="btn btn-sm {{ $winner->is_settled ? 'btn-danger' : 'btn-success' }}"
                                                onclick="settleWinner({{ $winner->id }}, {{ !$winner->is_settled ? 'true' : 'false' }})">
                                                {{ $winner->is_settled ? 'Unsettle' : 'Settle' }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination with search and sort state persistence -->
                        <div class="d-flex justify-content-center">
                            {{ $winners->appends(request()->all())->links() }}
                        </div>
                    @endif
                </div>
                <!-- Modal for username and pin -->
                <div class="modal fade" id="settleModal" tabindex="-1" aria-labelledby="settleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="settleModalLabel">Settle Jackpot</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="settleForm">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pin">Pin</label>
                                        <input type="password" class="form-control" id="pin" name="pin"
                                            required>
                                    </div>
                                    <input type="hidden" id="settleId">
                                    <input type="hidden" id="isSettled">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="settleButton">Settle</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            @include('sidenav.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <script>
        function settleWinner(id, isSettled) {
            // Store the ID and settlement status

            

        // Handle the form submission inside the modal
        const username = prompt('Enter username:');
        const pin = prompt('Enter PIN:');

        if (!username || !pin) {
            alert('Username and PIN are required.');
            return;
        }

        $.ajax({
            url: '/jackpot_winners/settle/' + id,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                is_settled: isSettled ? 1 : 0, // Convert boolean to integer (1 or 0)
                username: username,
                pin: pin
            },
            success: function(response) {
                if (response.success) {
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('An error occurred while updating the settlement status.');
            }
        });
    }
    </script>


</x-app-layout>
