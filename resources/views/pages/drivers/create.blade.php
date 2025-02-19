<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Add New Driver</h2>
        @include('pages.drivers.form', ['action' => route('drivers.store')])

        <div class="mt-4">
            <a href="{{ route('drivers.index') }}" class="text-blue-500 hover:text-blue-700">Cancel</a>
        </div>
    </div>
</x-app-layout>