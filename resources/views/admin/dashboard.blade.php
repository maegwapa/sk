<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK System Portal - Admin Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8fafc] min-h-screen flex">
    <aside class="w-64 bg-[#0b1329] text-white flex flex-col justify-between p-4 flex-shrink-0">
        <div>
            <div class="flex items-center space-x-2 mb-8 px-2">
                <div class="w-3 h-3 bg-blue-500 transform rotate-45"></div>
                <span class="font-bold text-lg tracking-wide">SK System Portal</span>
            </div>

            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 bg-blue-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium">
                    <span>Dashboard</span>
                </a>
            </nav>
        </div>

        <div class="border-t border-slate-800 pt-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center font-bold text-sm">
                    {{ strtolower(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-xs font-bold text-white">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-gray-400">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs text-red-400 hover:text-red-300 font-semibold">Logout</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500 text-white rounded-xl shadow-md flex items-center justify-between font-semibold text-sm">
                <div class="flex items-center space-x-2">
                    <span>🎉</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200 font-bold text-base">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-500 text-white rounded-xl shadow-md flex items-center justify-between font-semibold text-sm">
                <span>⚠️ {{ $errors->first() }}</span>
                <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200 font-bold text-base">&times;</button>
            </div>
        @endif

        <div class="bg-[#0b1329] rounded-xl p-6 text-white flex justify-between items-center mb-8 shadow-md">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-xl font-bold">
                    {{ strtolower(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold flex items-center gap-2">
                        Welcome back, {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-xs text-gray-400 mt-1">Here's an overview of your system controls and registered user accounts.</p>
                </div>
            </div>
            <span class="bg-blue-600 text-white text-xs font-semibold px-3 py-1.5 rounded-md tracking-wider uppercase">
                🛡️ Administrator Access
            </span>
        </div>

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Admin Control Center</h2>
                <p class="text-xs text-gray-500">Manage system users, assign roles, and control access permissions.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="bg-[#1e293b] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-800 transition">
                + Create user
            </a>
        </div>

        <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase">Total System Users</p>
                    <p class="text-2xl font-black text-gray-900 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="text-gray-400 text-2xl">👥</div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase">Administrators</p>
                    <p class="text-2xl font-black text-gray-900 mt-1">{{ $stats['admins'] }}</p>
                </div>
                <div class="text-gray-400 text-2xl">🛡️</div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase">Members & Personnel</p>
                    <p class="text-2xl font-black text-gray-900 mt-1">{{ $stats['personnel'] }}</p>
                </div>
                <div class="text-gray-400 text-2xl">👤</div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Current Weather</h3>
                    <p class="text-xs text-gray-500">Live weather information from Open-Meteo.</p>
                </div>
                <span class="text-2xl">🌤️</span>
            </div>

            @if($weather)
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-sm">
                    <div><p class="text-xs text-gray-500">Location</p><p class="font-bold text-gray-900">{{ $weather['location'] }}</p></div>
                    <div><p class="text-xs text-gray-500">Temperature</p><p class="font-bold text-gray-900">{{ $weather['temperature'] }}{{ $weather['temperature_unit'] }}</p></div>
                    <div><p class="text-xs text-gray-500">Condition</p><p class="font-bold text-gray-900">{{ $weather['condition'] }}</p></div>
                    <div><p class="text-xs text-gray-500">Humidity</p><p class="font-bold text-gray-900">{{ $weather['humidity'] }}%</p></div>
                    <div><p class="text-xs text-gray-500">Wind Speed</p><p class="font-bold text-gray-900">{{ $weather['wind_speed'] }} {{ $weather['wind_speed_unit'] }}</p></div>
                </div>
            @else
                <p class="text-sm text-amber-700 bg-amber-50 rounded-lg p-3">Weather information is currently unavailable. Please try again later.</p>
            @endif
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="font-bold text-gray-900 text-base">System Users Directory</h3>
                    <p class="text-xs text-gray-500">Real-time user accounts registered in the system.</p>
                </div>
                <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-md">
                    {{ count($users) }} Total Accounts
                </span>
            </div>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase">
                        <th class="py-3 px-4">Name & Email</th>
                        <th class="py-3 px-4">System Role</th>
                        <th class="py-3 px-4">Date Joined</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @foreach($users as $u)
                    <tr class="hover:bg-gray-50/50">
                        <td class="py-3 px-4">
                            <p class="font-bold text-gray-900">{{ $u->name }}</p>
                            <p class="text-xs text-gray-500">{{ $u->email }}</p>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                👤 {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-xs text-gray-600">
                            {{ $u->created_at->format('M d, Y') }}
                        </td>
                        <td class="py-3 px-4 text-right space-x-3 text-xs">
                            <a href="{{ route('admin.users.edit', $u->id) }}" class="text-blue-600 hover:underline font-semibold">Edit</a>
                            
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete {{ $u->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>