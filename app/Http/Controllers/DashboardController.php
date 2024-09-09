<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\HouseCommission;
use App\Models\JackpotWinner;
use App\Models\Bet;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $totalCommission = $this->getCurrentMonthCommission();
        $totalWinAmount = $this->getCurrentMonthTotalWinAmount();
        $totalBets = $this->getCurrentMonthTotalBets();
        return view('dashboard', compact('totalCommission','totalWinAmount', 'totalBets'));
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
}
