<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VolunteerController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'help_type' => ['required', Rule::in(['donation', 'volunteering', 'transport', 'other'])],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Volunteer::create($validated);

        return redirect()->back()->with('success', '¡Gracias por tu interés en ayudar! Nos pondremos en contacto contigo pronto.');
    }
}
