<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Edit Travel Route</h2>
        @include('pages.travel_routes.form', ['action' => route('travel_routes.update', $travelRoute), 'travelRoute' => $travelRoute])
    </div>
</x-app-layout>
