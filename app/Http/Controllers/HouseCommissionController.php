<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HouseCommission;

class HouseCommissionController extends Controller
{
    public function index()
    {
        $commissions = HouseCommission::with('bet')->paginate(20);
        return view('house_commissions.index', compact('commissions'));
    }
}
