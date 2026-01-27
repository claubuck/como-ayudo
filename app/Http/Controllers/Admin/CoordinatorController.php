<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coordinator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CoordinatorController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Coordinators/Index', [
            'coordinators' => Coordinator::orderBy('order')->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Coordinators/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'description' => ['nullable', 'string'],
            'active' => ['boolean'],
            'order' => ['integer', 'min:0'],
        ]);

        Coordinator::create($validated);

        return redirect()->route('admin.coordinators.index')
            ->with('success', 'Coordinador creado exitosamente.');
    }

    public function edit(string $id): Response
    {
        return Inertia::render('Admin/Coordinators/Edit', [
            'coordinator' => Coordinator::findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $coordinator = Coordinator::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'description' => ['nullable', 'string'],
            'active' => ['boolean'],
            'order' => ['integer', 'min:0'],
        ]);

        $coordinator->update($validated);

        return redirect()->route('admin.coordinators.index')
            ->with('success', 'Coordinador actualizado exitosamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $coordinator = Coordinator::findOrFail($id);
        $coordinator->delete();

        return redirect()->route('admin.coordinators.index')
            ->with('success', 'Coordinador eliminado exitosamente.');
    }
}
