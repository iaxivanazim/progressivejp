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
                    <h2>{{ isset($jackpotWinner) ? 'Edit' : 'Create' }} Jackpot Winner</h2>

                    <form
                        action="{{ isset($jackpotWinner) ? route('jackpot_winners.update', $jackpotWinner->id) : route('jackpot_winners.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($jackpotWinner))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="jackpot_id">Jackpot</label>
                            <select name="jackpot_id" id="jackpot_id" class="form-control" required>
                                @foreach ($jackpots as $jackpot)
                                    <option value="{{ $jackpot->id }}"
                                        {{ isset($jackpotWinner) && $jackpotWinner->jackpot_id == $jackpot->id ? 'selected' : '' }}>
                                        {{ $jackpot->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="game_table_id">Game Table</label>
                            <select name="game_table_id" id="game_table_id" class="form-control" required>
                                @foreach ($gameTables as $gameTable)
                                    <option value="{{ $gameTable->id }}"
                                        {{ isset($jackpotWinner) && $jackpotWinner->game_table_id == $gameTable->id ? 'selected' : '' }}>
                                        {{ $gameTable->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="table_name">Table Name</label>
                            <input type="text" name="table_name" id="table_name" class="form-control"
                                value="{{ old('table_name', isset($jackpotWinner) ? $jackpotWinner->table_name : '') }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="sensor_number">Sensor Number</label>
                            <input type="number" name="sensor_number" id="sensor_number" class="form-control"
                                value="{{ old('sensor_number', isset($jackpotWinner) ? $jackpotWinner->sensor_number : '') }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="win_amount">Win Amount</label>
                            <input type="number" step="0.01" name="win_amount" id="win_amount" class="form-control"
                                value="{{ old('win_amount', isset($jackpotWinner) ? $jackpotWinner->win_amount : '') }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="is_settled">Is Settled</label>
                            <input type="checkbox" name="is_settled" id="is_settled"
                                {{ old('is_settled', isset($jackpotWinner) && $jackpotWinner->is_settled ? 'checked' : '') }}>
                        </div>

                        <button type="submit"
                            class="btn btn-success">{{ isset($jackpotWinner) ? 'Update' : 'Create' }}</button>
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
