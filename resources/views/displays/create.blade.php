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
                    <h1>Create Display Data</h1>

                    <form action="{{ route('displays.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Display Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="jackpot_ids" class="form-label">Select Jackpots</label>
                                @foreach ($jackpots as $jackpot)
                                    <div class="checkbox form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="jackpot_ids[]"
                                                value="{{ $jackpot->id }}">
                                            {{ $jackpot->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="hand_ids" class="form-label">Select Hands</label>
                                @foreach ($hands as $hand)
                                    <div class="checkbox form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="hand_ids[]"
                                                value="{{ $hand->id }}">
                                            {{ $hand->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Display</button>
                    </form>
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
