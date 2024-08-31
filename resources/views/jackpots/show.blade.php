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
                    <h1>Jackpot Details</h1>

                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <p>{{ $jackpot->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Seed Amount:</label>
                        <p>{{ $jackpot->seed_amount }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Amount:</label>
                        <p>{{ $jackpot->current_amount }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contribution Percentage:</label>
                        <p>{{ $jackpot->contribution_percentage }}%</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Winning Condition:</label>
                        <p>{{ $jackpot->winning_condition }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Is Global?</label>
                        <p>{{ $jackpot->is_global ? 'Yes' : 'No' }}</p>
                    </div>
                    <a href="{{ route('jackpots.edit', $jackpot->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('jackpots.index') }}" class="btn btn-secondary">Back to List</a>
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