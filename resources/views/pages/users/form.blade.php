<div class="bg-white shadow rounded-lg p-6">
    <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
        @csrf
        @isset($user)
            @method('PUT')
        @endisset

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   value="{{ old('name', $user->name ?? '') }}" required>
            @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   value="{{ old('email', $user->email ?? '') }}" required>
            @error('email') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <!-- Phone -->
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="text" name="phone" id="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   value="{{ old('phone', $user->phone ?? '') }}">
            @error('phone') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <!-- Avatar Upload -->
        <div class="mb-4">
            <label for="avatar" class="block text-sm font-medium text-gray-700">Profile Picture</label>
            <input type="file" name="avatar" id="avatar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @isset($user->avatar)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="h-16 w-16 rounded-full" alt="Avatar">
                </div>
            @endisset
            @error('avatar') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <!-- Role 
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                <option value="user" {{ old('role', $user->role ?? '') === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>-->

        <!-- Status -->
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                <option value="active" {{ old('status', $user->status ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $user->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   {{ isset($user) ? '' : 'required' }}>
            @error('password') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                {{ isset($user) ? 'Update User' : 'Create User' }}
            </button>
        </div>
    </form>
</div>
