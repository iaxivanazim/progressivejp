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
                                            <a href="{{ route('jackpot_winners.edit', $winner->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('jackpot_winners.destroy', $winner->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
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




</x-app-layout>
