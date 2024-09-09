<?php

namespace App\Http\Controllers;

use App\Models\Jackpot;
use App\Models\Hand;
use Illuminate\Http\Request;

class JackpotController extends Controller
{
    public function index()
    {
        $jackpots = Jackpot::paginate(20);
        return view('jackpots.index', compact('jackpots'));
    }

    public function create()
    {
        return view('jackpots.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'seed_amount' => 'required|numeric|min:0',
            'contribution_percentage' => 'required|numeric|min:0|max:100',
            'max_trigger_amount' => 'nullable',
            'trigger_type'=>'required',
            'is_global' => 'required|boolean',
        ]);

        $data = $request->all();
        $data['current_amount'] = $request->seed_amount; // Initialize current amount with seed amount

        Jackpot::create($data);

        return redirect()->route('jackpots.index')->with('success', 'Jackpot created successfully.');
    }

    public function show($id)
    {
        $jackpot = Jackpot::findOrFail($id);
        return view('jackpots.show', compact('jackpot'));
    }

    public function edit($id)
    {
        $jackpot = Jackpot::findOrFail($id);
        return view('jackpots.edit', compact('jackpot'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'seed_amount' => 'required|numeric|min:0',
            'contribution_percentage' => 'required|numeric|min:0|max:100',
            'max_trigger_amount' => 'nullable',
            'trigger_type'=>'required',
            'is_global' => 'required|boolean',
        ]);

        $jackpot = Jackpot::findOrFail($id);
        $jackpot->update($request->all());

        return redirect()->route('jackpots.index')->with('success', 'Jackpot updated successfully.');
    }

    public function destroy($id)
    {
        $jackpot = Jackpot::findOrFail($id);
        $jackpot->delete();

        return redirect()->route('jackpots.index')->with('success', 'Jackpot deleted successfully.');
    }

    public function updateJackpotAmount(Hand $hand, $jackpotAmount)
    {
        $deduction = $hand->calculateDeduction($jackpotAmount);
        $newJackpotAmount = $jackpotAmount - $deduction;

        // Update the jackpot amount in the database
        // Assuming you have a Jackpot model and a method to update the amount
        $jackpot = Jackpot::first(); // Get the relevant jackpot
        $jackpot->amount = $newJackpotAmount;
        $jackpot->save();

        return $newJackpotAmount;
    }
}
