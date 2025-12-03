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
                    <h1>Edit Game Table</h1>

                    <form action="{{ route('game_tables.update', $gameTable->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Table Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $gameTable->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="5CP" {{ $gameTable->type == '5CP' ? 'selected' : '' }}>5CP</option>
                                <option value="3CP" {{ $gameTable->type == '3CP' ? 'selected' : '' }}>3CP</option>
                                <option value="HDM" {{ $gameTable->type == 'HDM' ? 'selected' : '' }}>HDM</option>
                                <option value="AB" {{ $gameTable->type == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="BJ" {{ $gameTable->type == 'BJ' ? 'selected' : '' }}>BJ</option>
                                <option value="CTM" {{ $gameTable->type == 'CTM' ? 'selected' : '' }}>CTM</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="max_players" class="form-label">Max Players</label>
                            <input type="number" name="max_players" id="max_players" class="form-control"
                                value="{{ $gameTable->max_players }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="chip_value" class="form-label">Chip Value</label>
                            <input type="number" step="0.01" name="chip_value" id="chip_value" class="form-control"
                                value="{{ $gameTable->chip_value }}" required>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="jackpots">Select Applicable Jackpots</label>
                                @foreach ($jackpots as $jackpot)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jackpots[]"
                                            value="{{ $jackpot->id }}" id="jackpot-{{ $jackpot->id }}"
                                            @if (in_array($jackpot->id, $selectedJackpots)) checked @endif>
                                        <label class="form-check-label" for="jackpot-{{ $jackpot->id }}">
                                            {{ $jackpot->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group col-md-3">
                                <label for="hands">Configure Hands</label>
                                <div class="checkbox-group">
                                    @foreach ($hands as $hand)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="hand-{{ $hand->id }}" name="hands[]" value="{{ $hand->id }}"
                                                @if (isset($gameTable) && $gameTable->hands->contains($hand->id)) checked @endif>
                                            <label class="form-check-label"
                                                for="hand-{{ $hand->id }}">{{ $hand->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Update Table</button>
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
