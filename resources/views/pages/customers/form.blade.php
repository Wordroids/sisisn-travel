<div class="bg-white shadow rounded-lg p-6">
    <form method="POST" action="{{ $action }}">
        @csrf
        @isset($customer)
            @method('PUT')
        @endisset

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   value="{{ old('name', $customer->name ?? '') }}" required>
            @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   value="{{ old('email', $customer->email ?? '') }}" required>
            @error('email') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <!-- Phone -->
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="number" name="phone" id="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   value="{{ old('phone', $customer->phone ?? '') }}" required>
            @error('phone') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <!-- WhatsApp -->
        <div class="mb-4">
            <label for="whatsapp" class="block text-sm font-medium text-gray-700">WhatsApp Number</label>
            <input type="number" name="whatsapp" id="whatsapp" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   value="{{ old('whatsapp', $customer->whatsapp ?? '') }}" required>
            @error('whatsapp') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <!-- Country -->
        <div class="mb-4">
            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
            <input type="text" name="country" id="country" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   value="{{ old('country', $customer->country ?? '') }}" required>
            @error('country') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                {{ isset($customer) ? 'Update Customer' : 'Create Customer' }}
            </button>
        </div>
    </form>
</div>
