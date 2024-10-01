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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                House Commission <br>(This Month)
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ number_format($totalCommission, 2) }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Win Amount <br>(This Month)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ number_format($totalWinAmount, 2) }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Bets
                                                Placed <br>(This Month)
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        {{ $totalBets }}</div>
                                                </div>
                                                {{-- <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hot Table Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Hot Table<br>(This Month)
                                            </div>
                                            @if ($hotTable)
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $hotTable->name }}</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $hotTable->total_bets }} Bets</div>
                                            @else
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">No data available
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow py-2" style="height: 350px;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Recent Wins
                                            </div>
                                            <table class="table table-sm table-striped" style="font-size: 68%">
                                                <thead>
                                                    <tr>
                                                        <th>Sensor ID</th>
                                                        <th>Table Name</th>
                                                        <th>Jackpot Name</th>
                                                        <th>Win Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($recentWins as $win)
                                                        <tr>
                                                            <td>{{ $win->sensor_number }}</td>
                                                            <td>{{ $win->gameTable->name ?? 'N/A' }}</td>
                                                            <td>{{ $win->jackpot->name ?? 'N/A' }}</td>
                                                            <td>{{ number_format($win->win_amount, 2) }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4">No recent mystery wins found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-success shadow py-2" style="height: 350px;">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        All Jackpots
                                    </div>
                                    @if ($jackpots->isNotEmpty())
                                            <div class="row of d-flex justify-content-center align-items-center" style="max-height: 300px; overflow-y: auto;">
                                                @foreach ($jackpots as $jackpot)
                                                    <div class="col-md-6">
                                                        <div class="button-a mb-3">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center" style="padding: 4%;">
                                                                <p class="card-text" style="margin-bottom:0px">{{ $jackpot->name }}</p>
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
                                </div>
                            </div>
                        </div>

                        <!-- Hot Table Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow py-2" style="height: 350px;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Recent Mystery Wins
                                            </div>
                                            <table class="table table-sm table-striped" style="font-size: 68%">
                                                <thead>
                                                    <tr>
                                                        <th>Sensor ID</th>
                                                        <th>Table Name</th>
                                                        <th>Jackpot Name</th>
                                                        <th>Win Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($recentMysteryWins as $win)
                                                        <tr>
                                                            <td>{{ $win->sensor_number }}</td>
                                                            <td>{{ $win->gameTable->name ?? 'N/A' }}</td>
                                                            <td>{{ $win->jackpot->name ?? 'N/A' }}</td>
                                                            <td>{{ number_format($win->win_amount, 2) }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4">No recent mystery wins found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">House Commission Overview</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
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
    var monthlyCommissions = {!! json_encode(array_values($monthlyCommissions)) !!};
</script>


</x-app-layout>
