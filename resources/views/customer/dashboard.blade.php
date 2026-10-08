<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK System Portal - Customer Dashboard</title>
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
                <a href="#" class="flex items-center space-x-3 bg-blue-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium">
                    <span>Customer Dashboard</span>
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

        <div class="bg-[#0b1329] rounded-xl p-6 text-white flex justify-between items-center mb-8 shadow-md">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-xl font-bold">
                    {{ strtolower(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold flex items-center gap-2">
                        Welcome back, {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-xs text-gray-400 mt-1">Customer user portal overview.</p>
                </div>
            </div>
            <span class="bg-blue-600 text-white text-xs font-semibold px-3 py-1.5 rounded-md tracking-wider uppercase">
                👤 Customer Portal
            </span>
        </div>
    </main>
</body>
</html>