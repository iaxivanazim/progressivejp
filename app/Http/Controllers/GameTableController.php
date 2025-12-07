<?php

namespace App\Http\Controllers;

use App\Models\GameTable;
use App\Models\Hand;
use App\Models\Jackpot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GameTablesExport;

class GameTableController extends Controller
{
    public function index(Request $request)
    {
        // Search functionality
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');

        // Get filtered and sorted game tables
        $gameTables = GameTable::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%")
                ->orWhere('max_players', 'like', "%{$search}%")
                ->orWhere('chip_value', 'like', "%{$search}%");
        })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10);

        // Export to Excel functionality
        if ($request->has('export') && $request->export == 'excel') {
            return Excel::download(new GameTablesExport($gameTables), 'game_tables.xlsx');
        }

        $jackpots = Jackpot::all();
        return view('game_tables.index', compact('gameTables', 'jackpots'));
    }

    public function create()
    {
        $jackpots = Jackpot::all();
        $hands = Hand::all();  // Get all jackpots to display for selection
        return view('game_tables.create', compact('jackpots', 'hands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'max_players' => 'required|integer|min:1',
            'chip_value' => 'required|numeric|min:0',
            'jackpots' => 'required|array', // New field for jackpot selection
            'jackpots.*' => 'exists:jackpots,id',
            'hands' => 'nullable|array', // Expect an array of hand IDs
            'hands.*' => 'exists:hands,id',
        ]);

        $gameTable = GameTable::create($validated);

        // Sync selected jackpots
        $gameTable->jackpots()->sync($validated['jackpots']);

        // Sync selected hands
        if (!empty($validated['hands'])) {
            $gameTable->hands()->sync($validated['hands']);
        } else {
            $gameTable->hands()->sync([]);
        }

        return redirect()->route('game_tables.index');
    }

    public function show($id)
    {
        $gameTable = GameTable::findOrFail($id);
        return view('game_tables.show', compact('gameTable'));
    }

    public function edit($id)
    {
        $gameTable = GameTable::findOrFail($id); // Fetch the game table by its ID
        $jackpots = Jackpot::all(); // Fetch all jackpots
        $hands = Hand::all();
        $selectedJackpots = $gameTable->jackpots->pluck('id')->toArray(); // Get the IDs of the associated jackpots
        $selectedhands = $gameTable->hands->pluck('id')->toArray(); // Get the IDs of the associated hands

        return view('game_tables.edit', compact('gameTable', 'jackpots', 'selectedJackpots', 'hands', 'selectedhands'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|string|max:255',
            'max_players' => 'sometimes|required|integer|min:1',
            'chip_value' => 'sometimes|required|numeric|min:0',
            'jackpots' => 'sometimes|required|array', // New field for jackpot selection
            'jackpots.*' => 'sometimes|exists:jackpots,id',
            'hands' => 'nullable|array', // Expect an array of hand IDs
            'hands.*' => 'exists:hands,id',
        ]);

        $gameTable = GameTable::findOrFail($id); // Fetch the game table by its ID

        // Update the game table with validated data
        $gameTable->update($validated);

        // Sync selected jackpots
        if (!empty($validated['jackpots'])) {
            $gameTable->jackpots()->sync($validated['jackpots']);
        }

        // Sync selected hands
        if (!empty($validated['hands'])) {
            $gameTable->hands()->sync($validated['hands']);
        } else {
            $gameTable->hands()->sync([]);
        }

        return redirect()->route('game_tables.index');
    }

    public function destroy($id)
    {
        $gameTable = GameTable::findOrFail($id);
        $gameTable->delete();
        return redirect()->route('game_tables.index');
    }

    // Function to get all game tables
    public function getAllGameTables(): JsonResponse
    {
        // Retrieve all records from the game_tables table
        $gameTables = GameTable::all();

        // Return the records as a JSON response
        return response()->json([
            'success' => true,
            'data' => $gameTables
        ]);
    }

    // Function to get all game tables with their associated jackpots
    public function getAllGameTablesWithJackpots(): JsonResponse
    {
        // Retrieve all game tables with their associated jackpots
        $gameTables = GameTable::with('jackpots')->get();

        // Return the records as a JSON response
        return response()->json([
            'success' => true,
            'data' => $gameTables
        ]);
    }

    // Function to get all jackpots associated with a specific game table by ID
    public function getJackpotsByGameTableId($id): JsonResponse
    {
        // Find the game table by ID
        $gameTable = GameTable::with('jackpots')->find($id);

        if (!$gameTable) {
            return response()->json([
                'success' => false,
                'message' => 'Game table not found.'
            ], 404);
        }

        // Return the associated jackpots as a JSON response
        return response()->json([
            'success' => true,
            'data' => $gameTable->jackpots
        ]);
    }

    // Function to get all game tables with their associated hands
    public function getAllGameTablesWithHands(): JsonResponse
    {
        // Retrieve all game tables with their associated hands
        $gameTables = GameTable::with('hands')->get();

        // Return the records as a JSON response
        return response()->json([
            'success' => true,
            'data' => $gameTables
        ]);
    }

    // Function to get all hands associated with a specific game table by ID
    public function getHandsByGameTableId($id): JsonResponse
    {
        // Find the game table by ID
        $gameTable = GameTable::with('hands')->find($id);

        if (!$gameTable) {
            return response()->json([
                'success' => false,
                'message' => 'Game table not found.'
            ], 404);
        }

        // Return the associated hands as a JSON response
        return response()->json([
            'success' => true,
            'data' => $gameTable->hands
        ]);
    }
}

// ⠀⠀⠀⠀⠀⢀⣀⣀⣀⣀⣀⣀⣀⣀⣀⣀⣀⣀⣀⣠⣴⣷⣶⣶⣤⣄⠀⠀⠀
// ⠀⠀⢀⣶⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣷⣄⠀
// ⠀⢠⣿⣿⣿⣿⣿⡿⠟⠛⠛⠛⠛⠛⠛⠛⠛⠛⠛⠛⠻⢿⣿⣿⣿⣿⣿⣿⣆
// ⠀⣼⣿⣿⣿⡿⠋⢀⣠⣴⣶⣶⣶⣶⣶⣶⣶⣶⣶⣶⣤⡀⠈⢻⣿⣯⣿⣿⣻
// ⠡⣿⣿⣿⣿⠁⢠⣿⣿⣿⣿⣿⣿⡿⣿⢿⣿⣿⣟⠉⠙⣿⡆⠀⢿⣿⣟⣿⣽
// ⡁⣿⣿⣿⡿⠀⣸⣿⣿⣿⡿⠋⠀⣀⣠⣀⠈⠙⢿⣶⣾⣿⡷⠀⢺⣿⣿⡷⠊
// ⡀⣿⣿⣿⡟⠀⢸⣿⣿⡿⠀⢠⣿⣿⡿⣿⣿⣆⠀⢻⣿⣽⣟⠀⢼⣿⣿⡽⠀
// ⡐⣿⣿⢿⣯⠀⢸⣿⣟⣧⠀⢿⣿⣳⣿⣟⣷⣿⠀⢸⣿⣯⡷⠀⢸⣿⣟⡿⠀         __mr.iax__
// ⢧⣿⣻⡿⣷⠀⢸⣿⡽⣿⡄⠈⠿⣿⣾⣽⠾⠃⢀⣿⣿⡽⣟⠀⢺⣿⣟⡿⠀
// ⣯⣷⢿⣻⣿⠀⢸⡿⣽⣳⢿⣶⣄⣀⣀⣀⣠⣴⡿⣟⣷⣿⡯⠀⣽⣿⣻⣟⠀
// ⣷⣟⣯⢷⣻⡆⠈⢿⣳⢯⣛⡾⡽⢯⣟⡿⣯⢿⣽⣻⣽⡾⠃⢀⣿⣿⣽⡯⣄
// ⢿⣟⡞⣯⢳⣛⢦⡀⠉⠙⠛⠚⠛⠛⠚⠛⠛⠛⠛⠋⠉⢀⣠⣾⣿⣻⣾⢿⣟
// ⠈⢿⣞⡱⢳⡌⢧⡙⡛⠖⡶⠲⠖⣆⢖⡲⢶⢶⡶⣾⣾⢿⣟⣿⣽⡿⣽⣿⠃
// ⠀⠈⠻⢷⣧⣘⣢⠡⠙⢌⠰⢉⠚⠤⢋⠼⣩⢞⣹⢳⣯⢿⣞⣿⣾⡿⠟⠁⠀
// ⠀⠀⠀⠀⠉⠓⠛⠛⠿⠛⠟⠻⠛⠟⠻⠻⠝⠯⠛⠯⠛⢟⠛⣓⠋⠁⠀⠀⠀
