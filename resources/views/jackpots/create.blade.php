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
                    <h1>Create Jackpot</h1>

                    <form action="{{ route('jackpots.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Jackpot Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="seed_amount" class="form-label">Seed Amount</label>
                            <input type="number" step="0.01" name="seed_amount" id="seed_amount"
                                class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="contribution_percentage" class="form-label">Contribution Percentage</label>
                            <input type="number" step="0.01" name="contribution_percentage"
                                id="contribution_percentage" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="trigger_type">Trigger Type:</label>
                            <select class="form-select" name="trigger_type" id="trigger_type">
                                <option value="hand">Hand</option>
                                <option value="mystery">Mystery</option>
                            </select>
                        </div>

                        <div class="mb-3" id="max_trigger_amount_div" style="display:none;">
                            <label class="form-label" for="max_trigger_amount">Max Trigger Amount (for Mystery):</label>
                            <input type="number" name="max_trigger_amount" id="max_trigger_amount" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="is_global" class="form-label">Is Global?</label>
                            <select name="is_global" id="is_global" class="form-select" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Create Jackpot</button>
                    </form>
                    <script>
                        document.getElementById('trigger_type').addEventListener('change', function() {
                            if (this.value === 'mystery') {
                                document.getElementById('max_trigger_amount_div').style.display = 'block';
                            } else {
                                document.getElementById('max_trigger_amount_div').style.display = 'none';
                            }
                        });
                    </script>
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
