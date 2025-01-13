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
                        <h1>Displays</h1>
                        <div>
                            {{-- <a href="{{ route('game_tables.index', array_merge(request()->all(), ['export' => 'excel'])) }}"
                                class="btn btn-success">Export to Excel</a> --}}
                            <a href="{{ route('displays.create') }}" class="btn btn-primary">Add New Display</a>
                        </div>
                    </div>

                    @if ($displays->isEmpty())
                        <p>No Media Displays defined</p>
                    @else
                        <div class="row of">
                            @foreach ($displays as $display)
                                <div class="col-md-6 holder">
                                    <div class="card custom-card card-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3>{{ $display->name }}</h3>
                                            <h3 class="badge bg-primary" style="font-size: 1.2rem;">{{ $display->id }}
                                            </h3>
                                        </div>
                                        <p><strong>Jackpots:</strong></p>

                                        @if ($display->jackpots()->isNotEmpty())
                                            <div class="row of">
                                                @foreach ($display->jackpots() as $jackpot)
                                                    <div class="col-md-12">
                                                        <div class="button-a mb-3">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center">
                                                                <p class="card-text">{{ $jackpot->name }}</p>
                                                                <p class="card-text">
                                                                    {{ $jackpot->current_amount }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p>No jackpots selected.</p>
                                        @endif

                                        <p><strong>Hands:</strong></p>
                                        @if ($display->hands()->isNotEmpty())
                                            <div class="row of">
                                                <div class="col-md-12">
                                                    <div class="button-a for-bg mb-3">
                                                        @foreach ($display->hands() as $hand)
                                                            <div
                                                                class="d-flex justify-content-between align-items-center">
                                                                <p class="card-text">{{ $hand->name }}</p>
                                                                <p class="card-text">
                                                                    {{ $hand->deduction_value }}{{ $hand->deduction_type == 'percentage' ? '%' : '' }}
                                                                </p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <p>No Hands selected.</p>
                                        @endif

                                        <h4>Last 5 Wins</h4>
                                        <table class="table for-height table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Player</th>
                                                    <th>Win Amount</th>
                                                    <th>Table</th>
                                                    <th>Jackpot</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($displayRecentWins[$display->id] as $win)
                                                    <tr>
                                                        <td>{{ $win->sensor_number }}</td>
                                                        <td>{{ $win->win_amount }}</td>
                                                        <td>{{ $win->table_name }}</td>
                                                        <td>{{ $win->jackpot->name }}</td>
                                                    </tr>
                                                @endforeach
                                                @if ($displayRecentWins[$display->id]->isEmpty())
                                                    <tr>
                                                        <td colspan="2">No recent wins.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <div class="row m-auto">
                                            <div class="col-md-6 mt-3 d-flex justify-content-center">
                                                <a href="{{ route('displays.edit', $display->id) }}"
                                                    class="btn btn-warning btn-sm">&nbsp;&nbsp;Edit&nbsp;&nbsp;</a>
                                            </div>
                                            <div class="col-md-6 mt-3 d-flex justify-content-center">
                                                <form action="{{ route('displays.destroy', $display->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="d-flex justify-content-center">
                        {{ $displays->appends(request()->all())->links() }}
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




</x-app-layout>
