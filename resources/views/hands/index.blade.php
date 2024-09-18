<x-app-layout>
    <div id="wrapper">
        @include('sidenav.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('sidenav.navbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1>Hands</h1>
                        <div>
                            <!-- Export Button -->
                            <a href="{{ route('hands.index', array_merge(request()->all(), ['export' => 'excel'])) }}" class="btn btn-success">Export to Excel</a>
                            <a href="{{ route('hands.create') }}" class="btn btn-primary">Create Hand</a>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('hands.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name, deduction type, or value...">
                            </div>
                            <div class="col-md-3">
                                <select name="sort_by" class="form-control">
                                    <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Sort by ID</option>
                                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Sort by Name</option>
                                    <option value="deduction_type" {{ request('sort_by') == 'deduction_type' ? 'selected' : '' }}>Sort by Deduction Type</option>
                                    <option value="deduction_value" {{ request('sort_by') == 'deduction_value' ? 'selected' : '' }}>Sort by Deduction Value</option>
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

                    @if ($hands->isEmpty())
                        <p>No hands available.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="{{ route('hands.index', array_merge(request()->all(), ['sort_by' => 'id', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            ID
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('hands.index', array_merge(request()->all(), ['sort_by' => 'name', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Name
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('hands.index', array_merge(request()->all(), ['sort_by' => 'deduction_type', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Deduction Type
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('hands.index', array_merge(request()->all(), ['sort_by' => 'deduction_value', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Deduction Value
                                        </a>
                                    </th>
                                    <th>
                                        Deduction Source
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hands as $hand)
                                    <tr>
                                        <td>{{ $hand->id }}</td>
                                        <td>{{ $hand->name }}</td>
                                        <td>{{ $hand->deduction_type }}</td>
                                        <td>{{ $hand->deduction_value }}{{ $hand->deduction_type == "percentage" ? '%' : '' }}</td>
                                        <td>{{ $hand->float ? 'Float' : 'Meter' }}</td>
                                        <td>
                                            <a href="{{ route('hands.edit', $hand->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('hands.destroy', $hand->id) }}" method="POST" style="display:inline-block;">
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
                            {{ $hands->appends(request()->all())->links() }}
                        </div>
                    @endif
                </div>
                <!-- /.container-fluid -->

            </div>
            @include('sidenav.footer')
        </div>
    </div>
</x-app-layout>