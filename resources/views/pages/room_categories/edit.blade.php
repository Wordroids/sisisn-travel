<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Edit Room Category</h2>
        @include('pages.room_categories.form', ['action' => route('room_categories.update', $roomCategory), 'roomCategory' => $roomCategory])
    </div>
</x-app-layout>
