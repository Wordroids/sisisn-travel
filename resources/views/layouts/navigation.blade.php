<nav class="bg-white border-b border-gray-200 px-4 py-2.5 fixed left-0 right-0 top-0 z-50">
    <div class="flex flex-wrap justify-between items-center">
        <div class="flex justify-start items-center">
            <button
                data-drawer-target="drawer-navigation"
                data-drawer-toggle="drawer-navigation"
                aria-controls="drawer-navigation"
                class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100  focus:ring-2 focus:ring-gray-100">
                <svg
                    aria-hidden="true"
                    class="w-6 h-6"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                <svg
                    aria-hidden="true"
                    class="hidden w-6 h-6"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Toggle sidebar</span>
            </button>
            <a href="/" class="flex items-center justify-between mr-4 w-60">
                <x-application-logo />
            </a>
            
        </div>
        <div class="flex items-center lg:order-2">
            
            <button
                type="button"
                class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 test:focus:ring-gray-600"
                id="user-menu-button"
                aria-expanded="false"
                data-dropdown-toggle="dropdown">
                <span class="sr-only">Open user menu</span>
                <img
        class="w-8 h-8 rounded-full"
        src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
        alt="{{ auth()->user()->name }}" />
            </button>
            <!-- Dropdown menu -->
            <div
                class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow test:bg-gray-700 test:divide-gray-600 rounded-xl"
                id="dropdown">
                <div class="py-3 px-4">
                    <span class="block text-sm font-semibold text-gray-900 test:text-white">
                        {{ auth()->user()->name }}
                    </span>
                    <span class="block text-sm text-gray-900 truncate test:text-white">
                        {{ auth()->user()->email }}
                    </span>
                </div>
                
                <ul
                    class="py-1 text-gray-700 test:text-gray-300"
                    aria-labelledby="dropdown">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full py-2 px-4 text-sm hover:bg-gray-100 test:hover:bg-gray-600 test:hover:text-white">
                                Sign out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar -->

<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-transform -translate-x-full bg-blue-600 border-r border-gray-200 md:translate-x-0  "
    aria-label="Sidenav"
    id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full bg-blue-600 ">

        <ul class="space-y-2">
            <!-- Quote  -->
            <li>
                <a
                    href="{{ route('quotations.index') }}"
                    class="flex items-center p-2 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700 test:hover:bg-gray-700">
                    <svg
                        aria-hidden="true"
                        class="flex-shrink-0 w-6 h-6 text-white transition duration-75 group-hover:text-gray-900  test:group-hover:text-white"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Quotes</span>
                </a>
            </li>

            <!-- Users  -->
            <li>
                <button
                    type="button"
                    class="flex items-center p-2 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700 test:hover:bg-gray-700"
                    aria-controls="dropdown-pages"
                    data-collapse-toggle="dropdown-pages">
                    <svg
                        aria-hidden="true"
                        class="flex-shrink-0 w-6 h-6 text-white transition duration-75 group-hover:text-gray-900  test:group-hover:text-white"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Users</span>
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                    <li>
                        <a
                            href="{{ route('users.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">All Users</a>
                    </li>
                    <li>
                        <a
                            href="{{ route('user-roles.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            User Roles
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ route('role-permissions.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Role Permissions
                        </a>
                    </li>
                    
                </ul>
            </li>

            <!-- System Data Menu -->
            <li>
                <button
                    type="button"
                    class="flex items-center p-2 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700"
                    aria-controls="dropdown-system-data"
                    data-collapse-toggle="dropdown-system-data">
                    <svg
                        aria-hidden="true"
                        class="flex-shrink-0 w-6 h-6 text-white transition duration-75 group-hover:text-gray-900"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm4 8a1 1 0 100 2h4a1 1 0 100-2H8zm0-4a1 1 0 100 2h4a1 1 0 100-2H8z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">System Data</span>
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-system-data" class="hidden py-2 space-y-2">
                    
                    <li>
                        <a
                            href="{{ route('customers.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Customer Data
                        </a>
                    </li>
                    <li>
                        <a
                            href="#"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Vehicle Fleet
                        </a>
                    </li>

                    <!-- Hotels  -->
                    <li>
                        <a
                            href="{{ route('hotels.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Hotels
                        </a>
                    </li>

                    <!-- Routes  -->
                    <li>
                        <a
                            href="{{ route('travel_routes.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Routes
                        </a>
                    </li>

                    <!-- Drivers  -->
                    <li>
                        <a
                            href="{{ route('drivers.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Drivers
                        </a>
                    </li>

                    <!-- Guides  -->
                    <li>
                        <a
                            href="{{ route('guides.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Guides
                        </a>
                    </li>
                    <!-- Markets -->
                    <li>
                        <a
                            href="{{ route('markets.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Markets
                        </a>
                    </li>

                    <!-- Currency  -->
                    <li>
                        <a
                            href="{{ route('currencies.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Currencies
                        </a>
                    </li>

                    <!-- Meals -->
                    <li>
                        <a
                            href="{{ route('meal_plans.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Meals
                        </a>
                    </li>

                    <!-- Room Categories  -->
                    <li>
                        <a
                            href="{{ route('room_categories.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Room Categories
                        </a>
                    </li>

                    <!-- Room Types  -->
                    <li>
                        <a
                            href="{{ route('room_types.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Room Types
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('pax_slabs.index') }}"
                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Pax Slabs
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('vehicle_types.index') }}" class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Vehicle Types
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('markup.index') }}" class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-gray-100 hover:text-gray-700">
                            Markup Value
                        </a>
                    </li>
                </ul>
            </li>


        </ul>

    </div>

</aside>