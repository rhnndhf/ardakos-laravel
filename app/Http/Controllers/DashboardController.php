<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Landlord;
use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        // Agent 3: Security check - Ensure we only fetch what we are allowed to see.
        // For now, assuming standard user auth.
        // If the user has a landlord_id, the global scope handles isolation.

        // However, for the "Landlord Switcher" to work, we need a way to see ALL landlords
        // IF the user is a Super Admin.
        // For this demo, let's assume if user.landlord_id is NULL, they are Super Admin.

        $user = $request->user();
        $landlords = [];

        if ($user && is_null($user->landlord_id)) {
             $landlords = Landlord::all(['id', 'name']);
        }

        // Fetch rooms. The global scope will automatically filter by landlord_id
        // if the user is assigned to one.
        // If user is super admin (no landlord_id), they might see all rooms
        // or we might want to filter by a selected landlord from the request.

        $query = Room::query()->with(['tenants' => function ($q) {
            $q->where('status', 'AKTIF');
        }]);

        if ($request->has('landlord_id') && is_null($user->landlord_id)) {
            $query->withoutGlobalScopes()->where('landlord_id', $request->input('landlord_id'));
        }

        $rooms = $query->get();

        return Inertia::render('Dashboard', [
            'landlords' => $landlords,
            'rooms' => $rooms,
            'stats' => [
                'total_rooms' => $rooms->count(),
                'occupied' => $rooms->where('occupancy_status', 'Terisi')->count(),
                'available' => $rooms->where('occupancy_status', 'Tersedia')->count(),
            ]
        ]);
    }
}
