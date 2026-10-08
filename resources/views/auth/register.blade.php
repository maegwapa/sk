<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK System Portal - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b1329] min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full">
        <div class="text-center mb-6">
            <p class="text-xs font-bold text-blue-600 tracking-wider uppercase">SK System Portal</p>
            <h1 class="text-2xl font-black text-gray-900 mt-1">Create Account</h1>
            <p class="text-xs text-gray-500 mt-1">Register as a Staff or Customer member.</p>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 text-xs rounded-lg">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border border-gray-200 rounded-md bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@gmail.com" class="w-full px-3 py-2 border border-gray-200 rounded-md bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Select Role</label>
                <select name="role" required class="w-full px-3 py-2 border border-gray-200 rounded-md bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="customer">Customer</option>
                    <option value="staff">Staff</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-200 rounded-md bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-3 py-2 border border-gray-200 rounded-md bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md text-sm transition">
                Register Account
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-6">
            Already have an account? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Sign in</a>
        </p>
    </div>
</body>
</html>