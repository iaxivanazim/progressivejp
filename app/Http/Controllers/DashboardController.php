<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\HouseCommission;
use App\Models\JackpotWinner;
use App\Models\Bet;
use App\Models\Jackpot;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $totalCommission = $this->getCurrentMonthCommission();
        $totalWinAmount = $this->getCurrentMonthTotalWinAmount();
        $totalBets = $this->getCurrentMonthTotalBets();
        $hotTable = $this->getHotTable();

        // Fetch last 5 mystery-triggered jackpot wins
        $recentMysteryWins = $this->getRecentMysteryWins();
        $recentWins = $this->getRecentWins();
        $monthlyCommissions = $this->getMonthlyHouseCommissions();

        $jackpots = Jackpot::all();

        return view('dashboard', compact('totalCommission', 'totalWinAmount', 'totalBets', 'hotTable', 'recentMysteryWins', 'recentWins', 'jackpots', 'monthlyCommissions'));
    }

    public function getCurrentMonthCommission()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalCommission = HouseCommission::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('commission_amount');

        return $totalCommission;
    }

    private function getCurrentMonthTotalWinAmount()
    {
        // Get the current date range for the month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Sum the win amounts within the current month
        $totalWinAmount = JackpotWinner::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('win_amount');

        return $totalWinAmount;
    }

    private function getCurrentMonthTotalBets()
    {
        // Get the current date range for the month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Count the number of bets within the current month
        $totalBets = Bet::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        return $totalBets;
    }

    private function getHotTable()
    {
        $hotTable = Bet::select('game_tables.name', Bet::raw('COUNT(bets.id) as total_bets'))
            ->join('game_tables', 'bets.game_table_id', '=', 'game_tables.id')
            ->whereBetween('bets.created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->groupBy('game_tables.name')
            ->orderBy('total_bets', 'desc')
            ->first();

        return $hotTable;
    }

    private function getRecentMysteryWins()
    {
        $recentMysteryWins = JackpotWinner::whereHas('jackpot', function ($query) {
            $query->where('trigger_type', 'mystery');
        })
            ->with(['jackpot', 'gameTable'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return $recentMysteryWins;
    }

    private function getRecentWins()
    {
        $recentWins = JackpotWinner::with(['jackpot', 'gameTable'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return $recentWins;
    }

    private function getMonthlyHouseCommissions()
    {
        $commissions = [];

        // Loop from January to the current month (chronological order)
        for ($i = 1; $i <= 12; $i++) {
            // Get the start and end dates for each month
            $startOfMonth = Carbon::create(null, $i, 1)->startOfMonth();
            $endOfMonth = Carbon::create(null, $i, 1)->endOfMonth();

            // Sum the commission amount for the given month
            $commission = HouseCommission::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('commission_amount');

            // Push the data for the current month (store in array)
            $commissions[] = $commission;
        }

        return $commissions;
    }
}
