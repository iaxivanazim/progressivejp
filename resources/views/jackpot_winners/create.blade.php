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
                    <h2>Create Jackpot Winner</h2>

                    <form action="{{ route('jackpot_winners.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="jackpot_id">Jackpot</label>
                            <select name="jackpot_id" id="jackpot_id" class="form-control" required>
                                @foreach ($jackpots as $jackpot)
                                    <option value="{{ $jackpot->id }}">{{ $jackpot->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="game_table_id">Game Table</label>
                            <select name="game_table_id" id="game_table_id" class="form-control" required>
                                @foreach ($gameTables as $gameTable)
                                    <option value="{{ $gameTable->id }}" data-name="{{ $gameTable->name }}">
                                        {{ $gameTable->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="table_name" id="table_name" value="">

                        <div class="form-group">
                            <label for="sensor_number">Sensor Number</label>
                            <input type="number" name="sensor_number" id="sensor_number" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="win_amount">Win Amount</label>
                            <input type="number" step="0.01" name="win_amount" id="win_amount" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="is_settled">Is Settled</label>
                            <input type="checkbox" name="is_settled" id="is_settled">
                        </div>

                        <button type="submit" class="btn btn-success">Create</button>
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

    <script>
        document.getElementById('game_table_id').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const tableName = selectedOption.getAttribute('data-name');
            document.getElementById('table_name').value = tableName;
        });

        // Trigger change event on page load to set the initial value
        document.getElementById('game_table_id').dispatchEvent(new Event('change'));
    </script>
</x-app-layout>