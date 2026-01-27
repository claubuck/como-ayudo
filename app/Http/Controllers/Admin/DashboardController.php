<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coordinator;
use App\Models\Donation;
use App\Models\DonationPoint;
use App\Models\Visit;
use App\Models\Volunteer;
use App\Models\Zone;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'zones' => Zone::where('active', true)->count(),
                'donations' => Donation::where('active', true)->count(),
                'donationPoints' => DonationPoint::where('active', true)->count(),
                'volunteers' => Volunteer::count(),
                'coordinators' => Coordinator::where('active', true)->count(),
                'pendingVolunteers' => Volunteer::where('status', 'pending')->count(),
                'visits' => [
                    'total' => Visit::count(),
                    'today' => Visit::whereDate('visited_at', $today)->count(),
                    'yesterday' => Visit::whereDate('visited_at', $yesterday)->count(),
                    'thisWeek' => Visit::where('visited_at', '>=', $thisWeek)->count(),
                    'thisMonth' => Visit::where('visited_at', '>=', $thisMonth)->count(),
                    'lastMonth' => Visit::whereBetween('visited_at', [$lastMonth, $lastMonthEnd])->count(),
                    'uniqueToday' => Visit::whereDate('visited_at', $today)->distinct()->count('ip_address'),
                    'uniqueThisWeek' => Visit::where('visited_at', '>=', $thisWeek)->distinct()->count('ip_address'),
                    'uniqueThisMonth' => Visit::where('visited_at', '>=', $thisMonth)->distinct()->count('ip_address'),
                ],
            ],
        ]);
    }
}
