<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Edit Room Type</h2>
        @include('pages.room_types.form', ['action' => route('room_types.update', $roomType), 'roomType' => $roomType])
    </div>
</x-app-layout>
