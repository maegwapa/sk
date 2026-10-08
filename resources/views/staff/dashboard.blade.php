<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b1329] min-h-screen text-white p-8">
    <div class="max-w-2xl mx-auto bg-slate-800 p-8 rounded-xl shadow-lg">
        <h1 class="text-3xl font-bold mb-2">Welcome Staff, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-400 mb-6">You have access to staff incident reporting tools.</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 px-4 py-2 rounded text-sm font-bold">Logout</button>
        </form>
    </div>
</body>
</html>