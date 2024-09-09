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
                    <h2>Jackpot Winners</h2>

                    <a href="{{ route('jackpot_winners.create') }}" class="btn btn-primary mb-3">Add Winner</a>

                    @if ($winners->isEmpty())
                        <p>No jackpot winners recorded yet.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Jackpot</th>
                                    <th>Game Table</th>
                                    <th>Table Name</th>
                                    <th>Sensor Number</th>
                                    <th>Win Amount</th>
                                    <th>Is Settled</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($winners as $winner)
                                    <tr>
                                        <td>{{ $winner->jackpot->name }}</td>
                                        <td>{{ $winner->gameTable->name }}</td>
                                        <td>{{ $winner->table_name }}</td>
                                        <td>{{ $winner->sensor_number }}</td>
                                        <td>{{ $winner->win_amount }}</td>
                                        <td>{{ $winner->is_settled ? 'Yes' : 'No' }}</td>
                                        <td>
                                            <button
                                                class="btn btn-sm {{ $winner->is_settled ? 'btn-danger' : 'btn-success' }}"
                                                onclick="settleWinner({{ $winner->id }}, {{ !$winner->is_settled ? 'true' : 'false' }})"
                                                class="btn btn-primary btn-sm">
                                                {{ $winner->is_settled ? 'Unsettle' : 'Settle' }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Display pagination links -->
                        <div class="d-flex justify-content-center">
                            {{ $winners->links() }}
                        </div>
                    @endif
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
            $.ajax({
                url: '/jackpot_winners/settle/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    is_settled: isSettled ? 1 : 0 // Convert boolean to integer (1 or 0)
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
