<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK System Portal - Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b1329] min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full">
        <div class="text-center mb-6">
            <p class="text-xs font-bold text-blue-600 tracking-wider uppercase">Admin Portal</p>
            <h1 class="text-2xl font-black text-gray-900 mt-1">Edit User</h1>
            <p class="text-xs text-gray-500 mt-1">Update details for {{ $user->name }}.</p>
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

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3 py-2 border border-gray-200 rounded-md bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3 py-2 border border-gray-200 rounded-md bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">System Role</label>
                <select name="role" required class="w-full px-3 py-2 border border-gray-200 rounded-md bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">New Password (Optional)</label>
                <input type="password" name="password" placeholder="Leave blank to keep current" class="w-full px-3 py-2 border border-gray-200 rounded-md bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="w-1/2 py-2.5 bg-gray-200 text-gray-800 text-center font-semibold rounded-md text-sm hover:bg-gray-300 transition">
                    Cancel
                </a>
                <button type="submit" class="w-1/2 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md text-sm transition">
                    Update User
                </button>
            </div>
        </form>
    </div>
</body>
</html>