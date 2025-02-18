<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Edit Driver</h2>
        @include('pages.drivers.form', ['action' => route('drivers.update', $driver), 'driver' => $driver])

        <!-- Additional button to cancel editing and go back to the previous page -->
        <div class="mt-4">
            <a href="{{ route('drivers.index') }}" class="text-blue-500 hover:text-blue-700">Cancel</a>
        </div>
    </div>
</x-app-layout>
