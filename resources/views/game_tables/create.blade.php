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
                    <h1>Create Game Table</h1>

                    <form action="{{ route('game_tables.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Table Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="5CP">5CP</option>
                                <option value="3CP">3CP</option>
                                <option value="HDM">HDM</option>
                                <option value="AB">AB</option>
                                <option value="BJ">BJ</option>
                                <option value="CTM">CTM</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="max_players" class="form-label">Max Players</label>
                            <input type="number" name="max_players" id="max_players" class="form-control"
                                value="7" required>
                        </div>
                        <div class="mb-3">
                            <label for="chip_value" class="form-label">Chip Value</label>
                            <input type="number" step="0.01" name="chip_value" id="chip_value" class="form-control"
                                required>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="jackpots">Select Applicable Jackpots</label>
                                @foreach ($jackpots as $jackpot)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jackpots[]"
                                            value="{{ $jackpot->id }}" id="jackpot-{{ $jackpot->id }}">
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
                                        <div class="form-check hand-checkbox" data-hand-id="{{ $hand->id }}"
                                            data-hand-group="{{ ceil($hand->id / 6) }}">
                                            <input type="checkbox" class="form-check-input"
                                                id="hand-{{ $hand->id }}" name="hands[]" value="{{ $hand->id }}">
                                            <label class="form-check-label"
                                                for="hand-{{ $hand->id }}">{{ $hand->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const typeSelect = document.getElementById('type');
                                const handCheckboxes = document.querySelectorAll('.hand-checkbox');

                                // Define type-to-group mapping (6 hands per group)
                                const typeGroupMap = {
                                    '5cp': 1,      // IDs 1-6
                                    '3cp': 2,      // IDs 7-12
                                    'hdm': 3,      // IDs 13-18
                                    'ab': 4,       // IDs 19-24
                                    'bj': 5,       // IDs 25-30
                                    'ctm': 6       // IDs 31-36
                                };

                                // Hide all hands initially
                                handCheckboxes.forEach(checkbox => {
                                    checkbox.style.display = 'none';
                                });

                                typeSelect.addEventListener('change', function() {
                                    const selectedType = this.value.toLowerCase();
                                    const targetGroup = typeGroupMap[selectedType];

                                    handCheckboxes.forEach(checkbox => {
                                        const handGroup = parseInt(checkbox.dataset.handGroup);
                                        if (targetGroup && handGroup === targetGroup) {
                                            checkbox.style.display = 'block';
                                        } else {
                                            checkbox.style.display = 'none';
                                            // Uncheck if hidden
                                            checkbox.querySelector('input[type="checkbox"]').checked = false;
                                        }
                                    });
                                });
                            });
                        </script>
                        <button type="submit" class="btn btn-success">Create Table</button>
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
