<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonationPoint;
use App\Models\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DonationPointController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/DonationPoints/Index', [
            'donationPoints' => DonationPoint::with('zone')
                ->orderBy('order')
                ->orderBy('created_at', 'desc')
                ->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/DonationPoints/Create', [
            'zones' => Zone::where('active', true)
                ->orderBy('order')
                ->get(['id', 'name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'zone_id' => ['nullable', 'exists:zones,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'schedule' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string'],
            'active' => ['boolean'],
            'order' => ['integer', 'min:0'],
        ]);

        DonationPoint::create($validated);

        return redirect()->route('admin.donation-points.index')
            ->with('success', 'Punto de recepción creado exitosamente.');
    }

    public function edit(string $id): Response
    {
        return Inertia::render('Admin/DonationPoints/Edit', [
            'donationPoint' => DonationPoint::findOrFail($id),
            'zones' => Zone::where('active', true)
                ->orderBy('order')
                ->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $donationPoint = DonationPoint::findOrFail($id);

        $validated = $request->validate([
            'zone_id' => ['nullable', 'exists:zones,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'schedule' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string'],
            'active' => ['boolean'],
            'order' => ['integer', 'min:0'],
        ]);

        $donationPoint->update($validated);

        return redirect()->route('admin.donation-points.index')
            ->with('success', 'Punto de recepción actualizado exitosamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $donationPoint = DonationPoint::findOrFail($id);
        $donationPoint->delete();

        return redirect()->route('admin.donation-points.index')
            ->with('success', 'Punto de recepción eliminado exitosamente.');
    }
}
