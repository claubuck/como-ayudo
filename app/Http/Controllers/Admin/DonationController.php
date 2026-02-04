<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DonationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Donations/Index', [
            'donations' => Donation::orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
                ->orderBy('order')
                ->orderBy('created_at', 'desc')
                ->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Donations/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'quantity_needed' => ['required', 'integer', 'min:0'],
            'quantity_received' => ['nullable', 'integer', 'min:0'],
            'unit' => ['required', 'string', 'max:50'],
            'priority' => ['required', 'in:high,medium,low'],
            'active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['quantity_received'] = $validated['quantity_received'] ?? 0;
        $validated['order'] = $validated['order'] ?? 0;

        Donation::create($validated);

        return redirect()->route('admin.donations.index')
            ->with('success', 'Donación creada exitosamente.');
    }

    public function edit(string $id): Response
    {
        return Inertia::render('Admin/Donations/Edit', [
            'donation' => Donation::findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $donation = Donation::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'quantity_needed' => ['required', 'integer', 'min:0'],
            'quantity_received' => ['nullable', 'integer', 'min:0'],
            'unit' => ['required', 'string', 'max:50'],
            'priority' => ['required', 'in:high,medium,low'],
            'active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $donation->update($validated);

        return redirect()->route('admin.donations.index')
            ->with('success', 'Donación actualizada exitosamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();

        return redirect()->route('admin.donations.index')
            ->with('success', 'Donación eliminada exitosamente.');
    }
}
