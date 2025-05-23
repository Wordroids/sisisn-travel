<div class="bg-white shadow rounded-lg p-6">
    <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
        @csrf
        @isset($travelRoute)
            @method('PUT')
        @endisset

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Route Name</label>
            <input type="text" name="name" class="block w-full border-gray-300 rounded-md shadow-sm"
                value="{{ old('name', $travelRoute->name ?? '') }}" required>
            @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" class="block w-full h-52 border-gray-300 rounded-md shadow-sm">{{ old('description', $travelRoute->description ?? '') }}</textarea>
            @error('description') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Mileage (KM)</label>
            <input type="number" name="mileage" class="block w-full border-gray-300 rounded-md shadow-sm"
                value="{{ old('mileage', $travelRoute->mileage ?? '') }}" min="1">
            @error('mileage') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Images (Max 2 images)</label>

            <!-- Show existing images if editing -->
            @if (isset($travelRoute) && $travelRoute->assets->count() > 0)
                <div class="grid grid-cols-2 gap-4 mb-4">
                    @foreach ($travelRoute->assets as $asset)
                        <div class="relative group" id="asset-{{ $asset->id }}">
                            <img src="{{ asset('storage/' . $asset->file_path) }}" alt="Travel Route Image"
                                class="w-full h-40 object-cover rounded-lg">

                            <div class="absolute top-2 right-2 flex space-x-2">

                                <button type="button" onclick="deleteImage({{ $asset->id }})"
                                    class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                    ×
                                </button>
                            </div>

                            @if ($asset->is_featured)
                                <span
                                    class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                                    Featured
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- New image upload input -->
            @if (!isset($travelRoute) || $travelRoute->assets->count() < 2)
                <input type="file" name="images[]"
                    class="block w-full border border-gray-300 rounded-md shadow-sm mt-1" accept="image/*" multiple
                    onchange="previewImages(this)">
                <p class="text-sm text-gray-500 mt-1">
                    Select up to {{ isset($travelRoute) ? 2 - $travelRoute->assets->count() : 2 }} images
                </p>

                <!-- Image preview container -->
                <div id="imagePreviewContainer" class="grid grid-cols-2 gap-4 mt-4"></div>
            @endif
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
            {{ isset($travelRoute) ? 'Update Travel Route' : 'Create Travel Route' }}
        </button>
    </form>
    <script>
        function validateImages(input) {
            if (input.files.length > 2) {
                alert('You can only upload a maximum of 2 images');
                input.value = '';
            }
        }
    </script>
    <script>
        function deleteImage(assetId) {
            if (!confirm('Are you sure you want to delete this image?')) {
                return;
            }

            fetch(`/travel-routes/delete-image/${assetId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`asset-${assetId}`).remove();
                        // Refresh page if no images left to update the file input
                        if (!document.querySelector('.grid').children.length) {
                            window.location.reload();
                        }
                    }
                });
        }

        function previewImages(input) {
            const previewContainer = document.getElementById('imagePreviewContainer');
            previewContainer.innerHTML = '';

            if (input.files.length > 2) {
                alert('You can only upload a maximum of 2 images');
                input.value = '';
                return;
            }

            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-40 object-cover rounded-lg';

                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = '×';
                    removeBtn.className =
                        'absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600';
                    removeBtn.onclick = function() {
                        div.remove();
                        input.value = '';
                    };

                    div.appendChild(img);
                    div.appendChild(removeBtn);
                    previewContainer.appendChild(div);
                };

                reader.readAsDataURL(file);
            }
        }
    </script>
</div>
