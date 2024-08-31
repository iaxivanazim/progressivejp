<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hand;
use App\Models\Jackpot;
use App\Models\Bet;
use App\Models\GameTable;

class HandController extends Controller
{
    public function index()
    {
        $hands = Hand::paginate(20);
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
}
