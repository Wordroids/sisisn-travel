<x-app-layout>
    <section class="bg-gray-50 py-3 sm:py-5">
        <div class="px-3">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold mb-4">Role Permissions Management</h2>

                @foreach ($roles as $role)
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4">{{ ucfirst($role->name) }} Permissions</h3>
                        <form action="{{ route('role-permissions.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="role_id" value="{{ $role->id }}">

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach ($permissions as $permission)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                            id="{{ $role->id }}_{{ $permission->id }}"
                                            class="rounded border-gray-300"
                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <label class="ml-2" for="{{ $role->id }}_{{ $permission->id }}">
                                            {{ ucwords(str_replace('-', ' ', $permission->name)) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Update Permissions
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
