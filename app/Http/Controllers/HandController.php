<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hand;
use App\Models\Jackpot;
use App\Models\Bet;
use App\Models\GameTable;
use Illuminate\Http\JsonResponse;
use App\Exports\HandsExport;
use Maatwebsite\Excel\Facades\Excel;

class HandController extends Controller
{
    public function index(Request $request)
    {
        // Search functionality
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');

        // Fetch hands with search and sorting
        $hands = Hand::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('deduction_type', 'like', "%{$search}%")
                             ->orWhere('deduction_value', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(20);

        // Export to Excel functionality
        if ($request->has('export') && $request->export == 'excel') {
            return Excel::download(new HandsExport($hands), 'hands.xlsx');
        }

        return view('hands.index', compact('hands'));
    }

    public function create()
    {
        return view('hands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Hand::create($request->all());

        return redirect()->route('hands.index')->with('success', 'Hand created successfully.');
    }

    public function edit($id)
    {
        $hand = Hand::findOrFail($id);
        return view('hands.edit', compact('hand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $hand = Hand::findOrFail($id);
        $hand->update($request->all());

        return redirect()->route('hands.index')->with('success', 'Hand updated successfully.');
    }

    public function destroy($id)
    {
        $hand = Hand::findOrFail($id);
        $hand->delete();

        return redirect()->route('hands.index')->with('success', 'Hand deleted successfully.');
    }

    public function triggerHandJackpot(Request $request)
    {
        $request->validate([
            'hand_id' => 'required|exists:hands,id',
            'game_table_id' => 'required|exists:game_tables,id',
        ]);

        $hand = Hand::findOrFail($request->hand_id);
        $gameTable = GameTable::findOrFail($request->game_table_id);

        $jackpot = $gameTable->jackpots()->where('trigger_type', 'hand')->first();

        if ($jackpot) {
            $winner = [
                'table_id' => $gameTable->id,
                'table_name' => $gameTable->name,
                'sensor_number' => random_int(1, $gameTable->max_players),
            ];

            // Handle the winner (broadcast, notify, etc.)
        }

        return redirect()->back()->with('success', 'Jackpot triggered for hand: ' . $hand->name);
    }

    /**
     * Return all hands as a JSON object.
     *
     * @return JsonResponse
     */
    public function getAllHands(): JsonResponse
    {
        $hands = Hand::all(); // Fetch all records from the hands table

        return response()->json([
            'success' => true,
            'data' => $hands
        ]);
    }
}
