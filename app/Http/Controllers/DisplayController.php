<?php

namespace App\Http\Controllers;

use App\Models\Display;
use App\Models\Jackpot;
use App\Models\Hand;
use App\Models\JackpotWinner;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function index()
    {
        $displays = Display::paginate(6);
        $displayRecentWins = [];

        // Loop through each display
        foreach ($displays as $display) {
            $jackpotIds = $display->jackpot_ids; // Already an array if cast in the model

            if (!empty($jackpotIds)) {
                // Get the recent 5 wins for the current display's jackpots, eager load the jackpot relationship
                $recentWins = JackpotWinner::with('jackpot')
                    ->whereIn('jackpot_id', $jackpotIds)
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();

                // Store the wins for each display
                $displayRecentWins[$display->id] = $recentWins;
            } else {
                // No jackpots selected for this display, set recent wins as empty
                $displayRecentWins[$display->id] = collect([]);
            }
        }

        return view('displays.index', compact('displays', 'displayRecentWins'));
    }

    public function create()
    {
        $jackpots = Jackpot::all();
        $hands = Hand::all();
        return view('displays.create', compact('jackpots', 'hands'));
    }

    public function store(Request $request)
    {
        $display = Display::create([
            'name' => $request->name,
            'jackpot_ids' => json_encode($request->jackpot_ids),
            'hand_ids' => json_encode($request->hand_ids),
        ]);

        return redirect()->route('displays.index')->with('success', 'Display created successfully.');
    }

    // Function to be called by external device through an API
    public function show($id)
    {
        $display = Display::findOrFail($id);

        $jackpots = Jackpot::whereIn('id', $display->jackpot_ids)->get();
        $hands = Hand::whereIn('id', $display->hand_ids)->get();

        // Get last 5 wins
        $recentWins = JackpotWinner::whereIn('jackpot_id', $display->jackpot_ids)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'display' => $display,
            'jackpots' => $jackpots,
            'hands' => $hands,
            'recentWins' => $recentWins,
        ]);
    }

    public function edit($id)
    {
        $display = Display::findOrFail($id);
        $jackpots = Jackpot::all();
        $hands = Hand::all();
        $selectedJackpots = $display->jackpots()->pluck('id')->toArray(); // Get the IDs of the associated jackpots
        $selectedHands = $display->hands()->pluck('id')->toArray(); // Get the IDs of the associated jackpots
        // Pass the display to the edit view
        return view('displays.edit', compact('display', 'jackpots', 'hands', 'selectedJackpots', 'selectedHands'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'jackpot_ids' => 'nullable|array',
            'hand_ids' => 'nullable|array',
        ]);

        // Find the display and update its fields
        $display = Display::findOrFail($id);

        // Update fields, ensuring that jackpot_ids and hand_ids are stored as JSON
        $display->update([
            'name' => $request->name,
            'jackpot_ids' => json_encode($request->jackpot_ids),
            'hand_ids' => json_encode($request->hand_ids),
        ]);

        return redirect()->route('displays.index')->with('success', 'Display updated successfully.');
    }

    public function destroy($id)
    {
        $display = Display::findOrFail($id);
        $display->delete();

        return redirect()->route('displays.index')->with('success', 'Display deleted successfully.');
    }
}
