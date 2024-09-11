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
                        <h1>Jackpots</h1>
                        <div>
                            <!-- Export Button -->
                            <a href="{{ route('jackpots.index', array_merge(request()->all(), ['export' => 'excel'])) }}"
                                class="btn btn-success">Export to Excel</a>
                            <a href="{{ route('jackpots.create') }}" class="btn btn-primary">Add New Jackpot</a>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('jackpots.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control" placeholder="Search by name or seed amount...">
                            </div>
                            <div class="col-md-3">
                                <select name="sort_by" class="form-control">
                                    <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Sort by ID
                                    </option>
                                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Sort by
                                        Name</option>
                                    <option value="seed_amount"
                                        {{ request('sort_by') == 'seed_amount' ? 'selected' : '' }}>Sort by Seed Amount
                                    </option>
                                    <option value="contribution_percentage"
                                        {{ request('sort_by') == 'contribution_percentage' ? 'selected' : '' }}>Sort by
                                        Contribution Percentage</option>
                                    <option value="is_global" {{ request('sort_by') == 'is_global' ? 'selected' : '' }}>
                                        Sort by Type</option>
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

                    @if ($jackpots->isEmpty())
                        <p>No jackpots available.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <a
                                            href="{{ route('jackpots.index', array_merge(request()->all(), ['sort_by' => 'id', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            ID
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="{{ route('jackpots.index', array_merge(request()->all(), ['sort_by' => 'name', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Name
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="{{ route('jackpots.index', array_merge(request()->all(), ['sort_by' => 'seed_amount', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Seed Amount
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="{{ route('jackpots.index', array_merge(request()->all(), ['sort_by' => 'current_amount', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Current Amount
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="{{ route('jackpots.index', array_merge(request()->all(), ['sort_by' => 'contribution_percentage', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Contribution Percentage
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="{{ route('jackpots.index', array_merge(request()->all(), ['sort_by' => 'is_global', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            Type
                                        </a>
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jackpots as $jackpot)
                                    <tr>
                                        <td>{{ $jackpot->id }}</td>
                                        <td>{{ $jackpot->name }}</td>
                                        <td>{{ $jackpot->seed_amount }}</td>
                                        <td>{{ $jackpot->current_amount }}</td>
                                        <td>{{ $jackpot->contribution_percentage }}%</td>
                                        <td>{{ $jackpot->is_global ? 'Global' : 'Table-specific' }}</td>
                                        <td>
                                            <a href="{{ route('jackpots.edit', $jackpot->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('jackpots.destroy', $jackpot->id) }}" method="POST"
                                                style="display:inline-block;">
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
                            {{ $jackpots->appends(request()->all())->links() }}
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
