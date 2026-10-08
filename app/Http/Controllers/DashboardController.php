<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function admin()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'personnel' => User::whereIn('role', ['staff', 'customer'])->count(),
        ];

        $weather = null;

        try {
            $response = Http::timeout(5)->get(config('services.weather.url'), [
                'latitude' => config('services.weather.latitude'),
                'longitude' => config('services.weather.longitude'),
                'current' => 'temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m',
            ]);

            $current = $response->json('current');

            if ($response->successful() && is_array($current)
                && isset($current['temperature_2m'], $current['relative_humidity_2m'], $current['weather_code'], $current['wind_speed_10m'])) {
                $weather = [
                    'location' => config('services.weather.location'),
                    'temperature' => $current['temperature_2m'],
                    'temperature_unit' => $response->json('current_units.temperature_2m', '°C'),
                    'condition' => $this->weatherDescription($current['weather_code']),
                    'humidity' => $current['relative_humidity_2m'],
                    'wind_speed' => $current['wind_speed_10m'],
                    'wind_speed_unit' => $response->json('current_units.wind_speed_10m', 'km/h'),
                ];
            }
        } catch (\Throwable $exception) {
            report($exception);
        }

        return view('admin.dashboard', compact('users', 'stats', 'weather'));
    }

    private function weatherDescription(?int $weatherCode): string
    {
        return match ($weatherCode) {
            0 => 'Clear sky',
            1, 2, 3 => 'Partly cloudy',
            45, 48 => 'Foggy',
            51, 53, 55, 56, 57 => 'Drizzle',
            61, 63, 65, 66, 67 => 'Rain',
            71, 73, 75, 77 => 'Snow',
            80, 81, 82 => 'Rain showers',
            85, 86 => 'Snow showers',
            95, 96, 99 => 'Thunderstorm',
            default => 'Unavailable',
        };
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,staff,customer',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User account created successfully!');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,staff,customer',
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User account updated successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return back()->withErrors(['error' => 'You cannot delete your own logged-in account!']);
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User account deleted successfully!');
    }

    public function staff()
    {
        return view('staff.dashboard');
    }

    public function customer()
    {
        return view('customer.dashboard');
    }
}