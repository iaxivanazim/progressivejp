<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hand;
use App\Models\Jackpot;
use App\Models\Bet;
use App\Models\GameTable;
use App\Models\JackpotWinner;
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
            'jackpot_id' => 'required|exists:jackpots,id',
            'game_table_id' => 'required|exists:game_tables,id',
            'sensors' => 'required|array|min:1',  // At least one sensor must be selected
        ]);

        $hand = Hand::findOrFail($request->hand_id);
        $jackpot = Jackpot::findOrFail($request->jackpot_id);
        $gameTable = GameTable::findOrFail($request->game_table_id);
        $sensors = $request->input('sensors');

        // Calculate deduction (either percentage or fixed amount)
        $deduction = $hand->calculateDeduction($jackpot->current_amount);

        // Split the deduction equally among all selected sensors (players)
        $individualWinAmount = $deduction / count($sensors);

        // Deduct the amount from the jackpot
        $newJackpotAmount = $jackpot->current_amount - $deduction;

        // If the jackpot amount goes below the seed amount, reset to seed amount
        if ($newJackpotAmount < $jackpot->seed_amount) {
            $newJackpotAmount = $jackpot->seed_amount;
        }

        // Update jackpot current amount
        $jackpot->current_amount = $newJackpotAmount;
        $jackpot->save();

        // Log each winner individually
        foreach ($sensors as $sensor) {
            JackpotWinner::create([
                'jackpot_id' => $jackpot->id,
                'game_table_id' => $gameTable->id,
                'table_name' => $gameTable->name,
                'sensor_number' => $sensor,
                'win_amount' => $individualWinAmount,
                'is_settled' => false,  // Set as false initially; it can be marked settled later
            ]);
        }

        return redirect()->back()->with('success', 'Jackpot triggered for hand: ' . $hand->name);
    }

    public function triggerHandWin(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'hand_id' => 'required|exists:hands,id',
            'jackpot_id' => 'required|exists:jackpots,id',
            'game_table_id' => 'required|exists:game_tables,id',
            'sensors' => 'required|array|min:1',  // At least one sensor (player) must be selected
        ]);

        // Fetch the relevant models
        $hand = Hand::findOrFail($request->hand_id);
        $jackpot = Jackpot::findOrFail($request->jackpot_id);
        $gameTable = GameTable::findOrFail($request->game_table_id);
        $sensors = $request->input('sensors');

        // Calculate the deduction (either percentage or fixed amount)
        $deduction = $hand->calculateDeduction($jackpot->current_amount);

        // Split the deduction equally among all selected sensors (players)
        $individualWinAmount = $deduction / count($sensors);

        // Deduct the amount from the jackpot
        $newJackpotAmount = $jackpot->current_amount - $deduction;

        // If the jackpot amount goes below the seed amount, reset to seed amount
        if ($newJackpotAmount < $jackpot->seed_amount) {
            $newJackpotAmount = $jackpot->seed_amount;
        }

        // Update the jackpot's current amount
        $jackpot->current_amount = $newJackpotAmount;
        $jackpot->save();

        // Array to store the win details
        $winDetails = [];

        // Log each winner individually
        foreach ($sensors as $sensor) {
            $winner = JackpotWinner::create([
                'jackpot_id' => $jackpot->id,
                'game_table_id' => $gameTable->id,
                'table_name' => $gameTable->name,
                'sensor_number' => $sensor,
                'win_amount' => $individualWinAmount,
                'is_settled' => false,  // Set as false initially; it can be marked settled later
            ]);

            // Add win details for each sensor to the response array
            $winDetails[] = [
                'sensor_number' => $sensor,
                'win_amount' => $individualWinAmount,
                'jackpot_id' => $jackpot->id,
                'jackpot_name' => $jackpot->name,
                'game_table_id' => $gameTable->id,
            ];
        }

        // Return the win details in JSON format
        return response()->json([
            'success' => true,
            'message' => 'Jackpot triggered successfully!',
            'jackpot_name' => $jackpot->name,
            'new_jackpot_amount' => $jackpot->current_amount,
            'win_details' => $winDetails
        ]);
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
