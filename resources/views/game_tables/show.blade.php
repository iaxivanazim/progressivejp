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
                    <h1>Game Table Details</h1>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $gameTable->name }}</h5>
                            <p class="card-text">Max Players: {{ $gameTable->max_players }}</p>
                            <p class="card-text">Chip Value: {{ $gameTable->chip_value }}</p>
                            <a href="{{ route('game_tables.index') }}" class="btn btn-primary">Back to List</a>
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




</x-app-layout>
