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
                        <a href="{{ route('jackpots.create') }}" class="btn btn-primary">Add New Jackpot</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($jackpots->isEmpty())
                        <p>No jackpots available.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Seed Amount</th>
                                    <th>Current Amount</th>
                                    <th>Contribution Percentage</th>
                                    <th>Type</th>
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
                                            {{-- <a href="{{ route('jackpots.show', $jackpot->id) }}"
                                                class="btn btn-info btn-sm">View</a> --}}
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
                        <div class="d-flex justify-content-center">
                            {{ $jackpots->links() }}
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
