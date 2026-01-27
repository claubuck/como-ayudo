<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use App\Models\Donation;
use App\Models\DonationPoint;
use App\Models\Zone;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Home', [
            'zones' => Zone::where('active', true)
                ->with(['donationPoints' => function ($query) {
                    $query->where('active', true)->orderBy('order');
                }])
                ->orderBy('order')
                ->orderBy('created_at')
                ->get()
                ->map(function ($zone) {
                    return [
                        'id' => $zone->id,
                        'name' => $zone->name,
                        'description' => $zone->description,
                        'status' => $zone->status,
                        'donation_points' => $zone->donationPoints->map(function ($point) {
                            return [
                                'id' => $point->id,
                                'name' => $point->name,
                                'address' => $point->address,
                                'schedule' => $point->schedule,
                                'phone' => $point->phone,
                                'whatsapp' => $point->whatsapp,
                                'notes' => $point->notes,
                            ];
                        })->values()->toArray(),
                    ];
                }),
            'donations' => Donation::where('active', true)
                ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
                ->orderBy('order')
                ->get()
                ->map(function ($donation) {
                    return [
                        'id' => $donation->id,
                        'name' => $donation->name,
                        'description' => $donation->description,
                        'quantity_needed' => $donation->quantity_needed,
                        'quantity_received' => $donation->quantity_received,
                        'unit' => $donation->unit,
                        'priority' => $donation->priority,
                        'progress_percentage' => $donation->progress_percentage,
                        'is_fulfilled' => $donation->is_fulfilled,
                    ];
                }),
            // Coordinadores ocultos por el momento
            // 'coordinators' => Coordinator::where('active', true)
            //     ->orderBy('order')
            //     ->orderBy('created_at')
            //     ->get(),
        ]);
    }
}
