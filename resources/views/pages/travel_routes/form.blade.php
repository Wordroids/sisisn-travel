<div class="bg-white shadow rounded-lg p-6">
    <form method="POST" action="{{ $action }}">
        @csrf
        @isset($travelRoute)
            @method('PUT')
        @endisset

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Route Name</label>
            <input type="text" name="name" class="block w-full border-gray-300 rounded-md shadow-sm"
                   value="{{ old('name', $travelRoute->name ?? '') }}" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" class="block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $travelRoute->description ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Mileage (KM)</label>
            <input type="number" name="mileage" class="block w-full border-gray-300 rounded-md shadow-sm"
                   value="{{ old('mileage', $travelRoute->mileage ?? '') }}" min="1">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
            {{ isset($travelRoute) ? 'Update Travel Route' : 'Create Travel Route' }}
        </button>
    </form>
</div>
