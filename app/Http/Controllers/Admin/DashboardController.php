<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coordinator;
use App\Models\Donation;
use App\Models\DonationPoint;
use App\Models\Volunteer;
use App\Models\Zone;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'zones' => Zone::where('active', true)->count(),
                'donations' => Donation::where('active', true)->count(),
                'donationPoints' => DonationPoint::where('active', true)->count(),
                'volunteers' => Volunteer::count(),
                'coordinators' => Coordinator::where('active', true)->count(),
                'pendingVolunteers' => Volunteer::where('status', 'pending')->count(),
            ],
        ]);
    }
}
