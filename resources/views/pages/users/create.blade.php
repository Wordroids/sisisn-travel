<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Create New User</h2>
        @include('pages.users.form', ['action' => route('users.store')])
    </div>
</x-app-layout>
