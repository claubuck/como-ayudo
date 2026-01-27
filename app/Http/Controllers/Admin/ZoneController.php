<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ZoneController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Zones/Index', [
            'zones' => Zone::orderBy('order')->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Zones/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:critical,moderate,recovering'],
            'active' => ['boolean'],
            'order' => ['integer', 'min:0'],
        ]);

        Zone::create($validated);

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zona creada exitosamente.');
    }

    public function edit(string $id): Response
    {
        return Inertia::render('Admin/Zones/Edit', [
            'zone' => Zone::findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $zone = Zone::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:critical,moderate,recovering'],
            'active' => ['boolean'],
            'order' => ['integer', 'min:0'],
        ]);

        $zone->update($validated);

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zona actualizada exitosamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $zone = Zone::findOrFail($id);
        $zone->delete();

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zona eliminada exitosamente.');
    }
}
