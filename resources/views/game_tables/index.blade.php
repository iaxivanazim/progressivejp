<x-app-layout>
    <div id="wrapper">
        @include('sidenav.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('sidenav.navbar')

                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1>Game Tables</h1>
                        <div>
                            <a href="{{ route('game_tables.index', array_merge(request()->all(), ['export' => 'excel'])) }}"
                                class="btn btn-success">Export to Excel</a>
                            <a href="{{ route('game_tables.create') }}" class="btn btn-primary">Add New Table</a>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('game_tables.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control" placeholder="Search by name, max players, or chip value...">
                            </div>
                            <div class="col-md-3">
                                <select name="sort_by" class="form-control">
                                    <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Sort by ID
                                    </option>
                                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Sort by
                                        Name</option>
                                    <option value="max_players"
                                        {{ request('sort_by') == 'max_players' ? 'selected' : '' }}>Sort by Max Players
                                    </option>
                                    <option value="chip_value"
                                        {{ request('sort_by') == 'chip_value' ? 'selected' : '' }}>Sort by Chip Value
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="sort_direction" class="form-control">
                                    <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>
                                        Ascending</option>
                                    <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>
                                        Descending</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Search & Sort</button>
                            </div>
                        </div>
                    </form>

                    @if ($gameTables->isEmpty())
                        <p>No game tables available.</p>
                    @else
                        <div class="row of">
                            @foreach ($gameTables as $gameTable)
                                {{--  --}}
                                <div class="col-md-4 holder">
<h3 class="badge bg-primary" style="font-size: 1.2rem;">{{ $gameTable->id }}</h3>
                                    <div class="image-cont">
                                        <img src="{{ asset('resources/img/pokerTable2.png') }}" alt=""
                                            class="poker-table">
                                        <img src="{{ asset('resources/img/progressivejp_logo.png') }}" alt=""
                                            class="icon">
                                        <h5>{{ $gameTable->name }}</h5>
                                    </div>
                                    <div class="jackpotsdisp">
                                        <div class="row disp-table-data m-auto">
                                            <div class="col-md-6 d-flex justify-content-center mt-3">Chip Value :
                                                {{ $gameTable->chip_value }}</div>
                                            <div class="col-md-6 d-flex justify-content-center mt-3">Max Players :
                                                {{ $gameTable->max_players }}</div>
                                        </div>
                                        <div class="row disp-meter-data">
                                            @foreach ($gameTable->jackpots as $jackpot)
                                                <div class="col-md-6 d-flex justify-content-center align-items-center mb-3">
                                                    {{ $jackpot->name }}</div>
                                                <div class="col-md-6 d-flex justify-content-center mb-3">
                                                    <div class="meter">
                                                        <div class="number-display">
                                                            @foreach (str_split(number_format($jackpot->current_amount, 2, '.', '')) as $char)
                                                                <span class="digit">{{ $char }}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="row m-auto">
                                                @foreach ($gameTable->hands as $hand)
                                                <div class="col-md-4 border d-flex justify-content-center align-items-center mb-3">
                                                    {{ $hand->name }}</div>
                                                @endforeach
                                            </div>

                                            <div class="row m-auto">
                                                <div class="col-md-6 mt-3 d-flex justify-content-center">
                                                    <a href="{{ route('game_tables.edit', $gameTable->id) }}"
                                                        class="btn btn-warning btn-sm">&nbsp;&nbsp;Edit&nbsp;&nbsp;</a>
                                                </div>
                                                <div class="col-md-6 mt-3 d-flex justify-content-center">
                                                    <form action="{{ route('game_tables.destroy', $gameTable->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{--  --}}
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $gameTables->appends(request()->all())->links() }}
                        </div>
                    @endif
                </div>
            </div>

            @include('sidenav.footer')
        </div>
    </div>
</x-app-layout>
