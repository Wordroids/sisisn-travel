<x-app-layout>
    <section class="bg-gray-50 test:bg-gray-900 py-3 sm:py-5">
        <div class="px-3">
            <div class="relative overflow-hidden bg-white shadow-md test:bg-gray-800 sm:rounded-lg">
                <div class="px-4 divide-y test:divide-gray-700">
                    <div class="flex flex-col py-3 space-y-3 md:flex-row md:items-center md:justify-between md:space-y-0 md:space-x-4">
                        <div class="flex items-center flex-1 space-x-4">
                            <h5>
                                <span class="text-gray-500">All Users:</span>
                                <span class="test:text-white">{{ $user_count }}</span>
                            </h5>

                        </div>

                    </div>

                    <!-- Add New User Button  -->
                    <div class="flex flex-col items-stretch justify-between py-4 space-y-3 md:flex-row md:items-center md:space-y-0">
                        <button type="button" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 test:bg-primary-600 test:hover:bg-primary-700 focus:outline-none test:focus:ring-primary-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add new user
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 test:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 test:bg-gray-700 test:text-gray-400">
                            <tr>

                                <th scope="col" class="px-4 py-3">User</th>
                                <th scope="col" class="px-4 py-3">Email</th>
                                <th scope="col" class="px-4 py-3">User Role</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3 whitespace-nowrap">Last Login</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user )
                            <tr class="border-b test:border-gray-600 hover:bg-gray-100 test:hover:bg-gray-700">

                                <th scope="row" class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap test:text-white">
                                    <div class="flex items-center">
                                        <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/avatar-10.png" alt="iMac Front Image" class="w-auto h-8 mr-3 rounded-full">
                                        {{ $user->name }}
                                    </div>
                                </th>

                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">
                                    <div class="inline-flex items-center bg-primary-100 text-primary-800 text-xs font-medium px-2 py-0.5 rounded test:bg-primary-900 test:text-primary-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" />
                                        </svg>
                                        Administrator
                                    </div>
                                </td>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap test:text-white">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 mr-2 bg-green-500 border rounded-full"></div>
                                        Active
                                    </div>
                                </td>

                                <td class="px-4 py-2">20 Nov 2022</td>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap test:text-white">
                                    <button id="dropdown-button-0" type="button" data-dropdown-toggle="dropdown-0" class="inline-flex items-center p-1 text-sm font-medium text-center text-gray-500 rounded-lg hover:text-gray-800 hover:bg-gray-200 test:hover:bg-gray-700 focus:outline-none test:text-gray-400 test:hover:text-gray-100">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                    <div id="dropdown-0" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 test:bg-gray-700 test:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 test:text-gray-200" aria-labelledby="dropdown-button-0">
                                            <li>
                                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 test:hover:bg-gray-600 test:hover:text-white">Show</a>
                                            </li>
                                            <li>
                                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 test:hover:bg-gray-600 test:hover:text-white">Edit</a>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 test:hover:bg-gray-600 test:text-gray-200 test:hover:text-white">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               
            </div>
        </div>
    </section>
</x-app-layout>