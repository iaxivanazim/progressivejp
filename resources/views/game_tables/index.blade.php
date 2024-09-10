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
                        <div>
                            <!-- Export Button -->
                            <a href="{{ route('game_tables.index', array_merge(request()->all(), ['export' => 'excel'])) }}" class="btn btn-success">Export to Excel</a>
                            <a href="{{ route('game_tables.create') }}" class="btn btn-primary">Add New Table</a>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('game_tables.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name, max players, or chip value...">
                            </div>
                            <div class="col-md-3">
                                <select name="sort_by" class="form-control">
                                    <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Sort by ID</option>
                                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Sort by Name</option>
                                    <option value="max_players" {{ request('sort_by') == 'max_players' ? 'selected' : '' }}>Sort by Max Players</option>
                                    <option value="chip_value" {{ request('sort_by') == 'chip_value' ? 'selected' : '' }}>Sort by Chip Value</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="sort_direction" class="form-control">
                                    <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                    <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Search & Sort</button>
                            </div>
                        </div>
                    </form>

                    @if ($gameTables->isEmpty())
                        <p>No game tables available.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="{{ route('game_tables.index', array_merge(request()->all(), ['sort_by' => 'id', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            ID
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('game_tables.index', array_merge(request()->all(), ['sort_by' => 'name', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Name
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('game_tables.index', array_merge(request()->all(), ['sort_by' => 'max_players', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Max Players
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('game_tables.index', array_merge(request()->all(), ['sort_by' => 'chip_value', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Chip Value
                                        </a>
                                    </th>
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
                                            <a href="{{ route('game_tables.edit', $gameTable->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('game_tables.destroy', $gameTable->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination with search and sort state persistence -->
                        <div class="d-flex justify-content-center">
                            {{ $gameTables->appends(request()->all())->links() }}
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