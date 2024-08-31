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
                        <h1>Game Tables</h1>
                        <a href="{{ route('game_tables.create') }}" class="btn btn-primary">Add New Table</a>
                    </div>

                    @if ($gameTables->isEmpty())
                        <p>No game tables available.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Max Players</th>
                                    <th>Chip Value</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gameTables as $gameTable)
                                    <tr>
                                        <td>{{ $gameTable->id }}</td>
                                        <td>{{ $gameTable->name }}</td>
                                        <td>{{ $gameTable->max_players }}</td>
                                        <td>{{ $gameTable->chip_value }}</td>
                                        <td>
                                            {{-- <a href="{{ route('game_tables.show', $gameTable->id) }}"
                                                class="btn btn-info btn-sm">View</a> --}}
                                            <a href="{{ route('game_tables.edit', $gameTable->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('game_tables.destroy', $gameTable->id) }}"
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
                        <div class="d-flex justify-content-center">
                            {{ $gameTables->links() }}
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
