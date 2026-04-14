<?php

namespace App\Http\Controllers;

use App\Models\Lending; 
use App\Models\User;
use App\Models\Item;

class StaffDashboardController extends Controller
{
    public function index()
    {

$activeLendings = 0;
    $lateReturns = 0;
    $totalStaff = 0;
    $totalItems = 0;
    
    // Logika untuk Staff
    $activeLendings = Lending::where('status', 'borrowed')->count();
    $lateReturns = Lending::where('status', 'borrowed')
                    ->where('due_date', '<', now())
                    ->count();

    // Logika untuk Admin (Tambahan biar lengkap)
    $totalStaff = User::where('role', 'staff')->count();
    $totalItems = Item::sum('quantity');

    // Kirim semua variabel ke view menggunakan compact
    return view('staff.dashboard', compact(
        'activeLendings', 
        'lateReturns', 
        'totalStaff', 
        'totalItems'
    ));
}
}