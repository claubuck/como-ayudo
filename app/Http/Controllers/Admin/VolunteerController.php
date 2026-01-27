<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VolunteerController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Volunteers/Index', [
            'volunteers' => Volunteer::orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function edit(string $id): Response
    {
        return Inertia::render('Admin/Volunteers/Edit', [
            'volunteer' => Volunteer::findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $volunteer = Volunteer::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,contacted,active,completed'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $volunteer->update($validated);

        return redirect()->route('admin.volunteers.index')
            ->with('success', 'Voluntario actualizado exitosamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->delete();

        return redirect()->route('admin.volunteers.index')
            ->with('success', 'Voluntario eliminado exitosamente.');
    }
}
