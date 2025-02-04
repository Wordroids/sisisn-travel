<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Manage Pax Slabs</h2>

        <a href="{{ route('pax_slabs.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 mb-4">+ Add Pax Slab</a>

        <table class="w-full mt-4 border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Min Pax</th>
                    <th class="border px-4 py-2">Max Pax</th>
                    <th class="border px-4 py-2">Order</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach($paxSlabs as $paxSlab)
                    <tr class="border hover:bg-gray-100" data-id="{{ $paxSlab->id }}">
                        <td class="border px-4 py-2">{{ $paxSlab->name }}</td>
                        <td class="border px-4 py-2">{{ $paxSlab->min_pax }}</td>
                        <td class="border px-4 py-2">{{ $paxSlab->max_pax }}</td>
                        <td class="border px-4 py-2 cursor-grab text-center">{{ $paxSlab->order }}</td>
                        <td class="border px-4 py-2 text-center">
                            <a href="{{ route('pax_slabs.edit', $paxSlab->id) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('pax_slabs.destroy', $paxSlab->id) }}" method="POST" class="inline-block ml-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('Delete this slab?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $("#sortable").sortable({
                update: function(event, ui) {
                    let order = $(this).sortable('toArray', { attribute: 'data-id' });
                    $.post("{{ route('pax_slabs.reorder') }}", { order: order, _token: "{{ csrf_token() }}" });
                }
            });
        });
    </script>
</x-app-layout>
