<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1>Place Your Bets</h1>

                    <div class="form-group">
                        <label for="game-table-select">Select Game Table</label>
                        <select id="game-table-select" class="form-control">
                            <option value="">Select a Game Table</option>
                            @foreach ($gameTables as $gameTable)
                                <option value="{{ $gameTable->id }}">{{ $gameTable->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="game-tables">
                        @foreach ($gameTables as $gameTable)
                            <div class="game-table" id="game-table-{{ $gameTable->id }}" style="display: none;">
                                <h2>{{ $gameTable->name }}</h2>

                                <div class="jackpots">
                                    <h3>Jackpots</h3>
                                    <ul>
                                        @foreach ($gameTable->jackpots as $jackpot)
                                            <li id="jackpot-{{ $jackpot->id }}">
                                                {{ $jackpot->name }}:
                                                <span class="jackpot-amount">{{ $jackpot->current_amount }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="sensors">
                                    @for ($i = 1; $i <= $gameTable->max_players; $i++)
                                        <label>
                                            <input type="checkbox" class="sensor-checkbox"
                                                data-sensor-id="{{ $i }}">
                                            Sensor {{ $i }}
                                        </label>
                                    @endfor
                                </div>

                                
                                    <button id="place-bet-{{ $gameTable->id }}"
                                        class="btn btn-primary place-bet-btn">Place Bet</button>

                                        <button id="win_button" class="btn btn-info place-bet-btn">Win</button>
                                        <div id="hands_dropdown" style="display:none;">
                                            <form action="{{ route('hands.trigger') }}" method="POST">
                                                @csrf
                                                <select name="hand_id">
                                                    @foreach ($hands as $hand)
                                                        <option value="{{ $hand->id }}">{{ $hand->name }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="game_table_id" value="{{ $gameTable->id }}">
                                                <button type="submit">Trigger Jackpot</button>
                                            </form>
                                        </div>    
                                
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <script>
        document.getElementById('game-table-select').addEventListener('change', function() {
            const selectedGameTableId = this.value;

            // Hide all game tables
            document.querySelectorAll('.game-table').forEach(table => {
                table.style.display = 'none';
            });

            // Show the selected game table
            if (selectedGameTableId) {
                document.getElementById('game-table-' + selectedGameTableId).style.display = 'block';
            }
        });

        document.querySelectorAll('.place-bet-btn').forEach(button => {
            button.addEventListener('click', function() {
                const gameTableId = this.id.split('-').pop();
                const gameTableElement = document.getElementById('game-table-' + gameTableId);

                let sensorData = '';
                gameTableElement.querySelectorAll('.sensor-checkbox').forEach(checkbox => {
                    sensorData += checkbox.checked ? '1' : '0';
                });

                fetch('{{ route('bets.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            game_table_id: gameTableId,
                            sensor_data: sensorData,
                        }),
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update jackpots displayed on the UI
                            updateJackpots();
                        }
                    });
            });
        });

        function updateJackpots() {
            fetch('{{ route('bets.index') }}')
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newJackpots = doc.querySelectorAll('.jackpot-amount');

                    document.querySelectorAll('.jackpot-amount').forEach((el, index) => {
                        el.textContent = newJackpots[index].textContent;
                    });
                });
        }

    document.getElementById('win_button').addEventListener('click', function() {
        document.getElementById('hands_dropdown').style.display = 'block';
    });

    </script>

</x-guest-layout>
