<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">User Details</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Avatar -->
            <div class="flex items-center space-x-4">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                     alt="{{ $user->name }}" class="w-16 h-16 rounded-full shadow">
                <div>
                    <h4 class="text-gray-600">Full Name</h4>
                    <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                </div>
            </div>

            <!-- Email -->
            <div>
                <h4 class="text-gray-600">Email</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $user->email }}</p>
            </div>

            <!-- Phone -->
            <div>
                <h4 class="text-gray-600">Phone</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $user->phone ?? 'N/A' }}</p>
            </div>

            <!-- Role -->
            <div>
                <h4 class="text-gray-600">Role</h4>
                <p class="text-lg font-semibold text-gray-900">{{ ucfirst($user->role) }}</p>
            </div>

            <!-- Status -->
            <div>
                <h4 class="text-gray-600">Status</h4>
                <p class="text-lg font-semibold {{ $user->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                    {{ ucfirst($user->status) }}
                </p>
            </div>

            <!-- Email Verified At -->
            <div>
                <h4 class="text-gray-600">Email Verified</h4>
                <p class="text-lg font-semibold text-gray-900">
                    {{ $user->email_verified_at ? $user->email_verified_at->format('d M Y') : 'Not Verified' }}
                </p>
            </div>

            <!-- Created At -->
            <div>
                <h4 class="text-gray-600">Created At</h4>
                <p class="text-lg font-semibold text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex space-x-4">
            <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Edit User
            </a>

            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Delete User
                </button>
            </form>

            <a href="{{ route('users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Back to List
            </a>
        </div>
    </div>
</x-app-layout>
