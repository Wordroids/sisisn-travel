<x-app-layout>
    <section class="bg-gray-50 py-3 sm:py-5">
        <div class="px-3">
            <div class="relative overflow-hidden bg-white shadow-md sm:rounded-lg">
                <div class="px-4 divide-y">
                    <div class="flex flex-col py-3 md:flex-row md:items-center md:justify-between">
                        <h5 class="text-gray-500">Meal Plans: <span>{{ $mealPlans->count() }}</span></h5>
                        <a href="{{ route('meal_plans.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-primary-700 rounded-lg hover:bg-primary-800">
                            Add new meal plan
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Meal Plan Name</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mealPlans as $mealPlan)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $mealPlan->name }}</td>
                                <td class="px-4 py-2">{{ $mealPlan->description ?: 'N/A' }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('meal_plans.edit', $mealPlan) }}" class="text-yellow-600 hover:underline">Edit</a>
                                    <form action="{{ route('meal_plans.destroy', $mealPlan) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this meal plan?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $mealPlans->links() }}</div>
            </div>
        </div>
    </section>
</x-app-layout>
