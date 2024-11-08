<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bet;
use App\Models\GameTable;
use App\Models\Jackpot;
use App\Models\HouseCommission;
use App\Models\Hand;
use App\Models\JackpotWinner;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BetsExport;

class BetController extends Controller
{
    public function index()
    {
        $gameTables = GameTable::with('jackpots')->get();
        $hands = Hand::all(); // Fetch all hands

        return view('bets.index', compact('gameTables', 'hands'));
    }

    public function showAllBets(Request $request)
{
    // Handle search, sorting, and date range inputs
    $search = $request->input('search');
    $sortBy = $request->input('sort_by', 'id');
    $sortDirection = $request->input('sort_direction', 'desc');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Fetch bets with optional search, sorting, and date range filtering
    $bets = Bet::with('gameTable')
        ->when($search, function ($query) use ($search) {
            return $query->where('sensor_data', 'like', "%$search%")
                         ->orWhereHas('gameTable', function ($q) use ($search) {
                             $q->where('name', 'like', "%$search%");
                         });
        })
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            return $query->whereBetween('created_at', [$startDate, $endDate]);
        })
        ->orderBy($sortBy, $sortDirection)
        ->paginate(20);

    // Handle Excel export
    if ($request->has('export') && $request->export == 'excel') {
        return Excel::download(new BetsExport($bets), 'bets.xlsx');
    }

    // Return the view with the bets data
    return view('bets.show_all', compact('bets'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_table_id' => 'required|exists:game_tables,id',
            'sensor_data' => 'required|string',
        ]);

        $gameTable = GameTable::findOrFail($validated['game_table_id']);

        // Calculate the total bet amount
        $activeSensorsCount = substr_count($validated['sensor_data'], '1');
        $totalBetAmount = $gameTable->chip_value * $activeSensorsCount;

        // Create the bet with the total bet amount
        $bet = Bet::create([
            'game_table_id' => $validated['game_table_id'],
            'sensor_data' => $validated['sensor_data'],
            'total_bet_amount' => $totalBetAmount,
        ]);

        // Update jackpots with the total bet amount and pass the bet instance
        // $this->updateJackpots($totalBetAmount, $gameTable->id, $bet);

        return $this->updateJackpots($totalBetAmount, $gameTable->id, $bet);
    }

    protected function updateJackpots($amount, $gameTableId, Bet $bet)
    {
        try {
            // Fetch the GameTable object using the gameTableId
            $gameTable = GameTable::findOrFail($gameTableId);

            // Retrieve jackpots associated with the game table
            $jackpots = $gameTable->jackpots;
            if ($jackpots->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No jackpots associated with this game table.']);
            }

            $totalContributions = 0;
            $winners = []; // Array to store winner details

            foreach ($jackpots as $jackpot) {
                $contribution = ($jackpot->contribution_percentage / 100) * $amount;
                $totalContributions += $contribution;

                // Update the current amount for the jackpot
                $jackpot->current_amount += $contribution;
                $jackpot->save();

                if ($jackpot->is_global) {
                    // Handle global jackpots
                    $relatedGameTables = $jackpot->gameTables;

                    foreach ($relatedGameTables as $relatedGameTable) {
                        if ($this->checkJackpotTrigger($jackpot, $relatedGameTable->id)) {
                            $winner = $this->selectRandomPlayer($gameTable, $bet->sensor_data);
                            $this->logJackpotWinner($jackpot, $winner);

                            // Store the winner details
                            $winners[] = [
                                'jackpot_id' => $jackpot->id,
                                'win_amount' => $jackpot->current_amount,
                                'winner' => $winner
                            ];

                            $jackpot->current_amount = $jackpot->seed_amount;
                            $jackpot->save();
                        }
                    }
                } else {
                    // Handle non-global jackpots
                    if ($this->checkJackpotTrigger($jackpot, $gameTable->id)) {
                        $winner = $this->selectRandomPlayer($gameTable, $bet->sensor_data);
                        $this->logJackpotWinner($jackpot, $winner);

                        // Store the winner details
                        $winners[] = [
                            'jackpot_id' => $jackpot->id,
                            'win_amount' => $jackpot->current_amount,
                            'winner' => $winner
                        ];

                        $jackpot->current_amount = $jackpot->seed_amount;
                        $jackpot->save();
                    }
                }
            }

            // Calculate and record the house commission
            $commissionAmount = $amount - $totalContributions;
            HouseCommission::create([
                'bet_id' => $bet->id,
                'commission_amount' => $commissionAmount,
            ]);

            // Return success response with winners if any
            if (!empty($winners)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Jackpots updated successfully.',
                    'winners' => $winners
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Jackpots updated successfully, no winners this time.']);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error in updateJackpots: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while updating jackpots.']);
        }
    }

    protected function logJackpotWinner(Jackpot $jackpot, $winner)
    {
        // Log or store winner information as needed
        // Example: Storing in a 'jackpot_winners' table
        JackpotWinner::create([
            'jackpot_id' => $jackpot->id,
            'game_table_id' => $winner['game_table_id'], // Ensure this is correct
            'table_name' => $winner['table_name'], // Ensure this is correct
            'sensor_number' => $winner['sensor_number'],
            'win_amount' => $jackpot->current_amount,
            'is_settled' => false, // Default to not settled; update later when needed
        ]);
    }

    protected function checkJackpotTrigger(Jackpot $jackpot, $gameTableId)
    {
        if ($jackpot->trigger_type == 'mystery' && $jackpot->current_amount >= $jackpot->max_trigger_amount) {
            return true;
        }

        // Additional conditions can be added for other trigger types
        return false;
    }

    protected function selectRandomPlayer(GameTable $gameTable, $sensorData)
    {
        // Get the positions of active sensors ('1') from the sensor data
        $activeSensors = [];
        for ($i = 0; $i < strlen($sensorData); $i++) {
            if ($sensorData[$i] === '1') {
                $activeSensors[] = $i + 1; // +1 because sensor positions are 1-based
            }
        }

        // Randomly select a sensor from the active ones
        $randomSensorId = $activeSensors[array_rand($activeSensors)];

        // Return the correct game table information
        return [
            'game_table_id' => $gameTable->id,
            'table_name' => $gameTable->name,
            'sensor_number' => $randomSensorId
        ];
    }

    // hand trigger

    public function getGameTables()
    {
        $gameTables = GameTable::all();
        return response()->json($gameTables);
    }

    public function getJackpots()
    {
        $jackpots = Jackpot::all();
        return response()->json($jackpots);
    }
}
