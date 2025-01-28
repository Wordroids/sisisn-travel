<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <section class="bg-blue-500 min-h-screen flex items-center justify-center">
        <div class="grid bg-white max-w-screen-xl mx-auto lg:gap-20 lg:grid-cols-12  shadow">
            <div class="w-full shadow h-full flex items-center justify-center lg:col-span-6 ">
                <div class="p-6 mx-auto rounded-lg  sm:max-w-xl sm:p-8">

                    <x-application-logo />

                    <form class="my-4 space-y-6 sm:mt-6 pt-3" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="grid gap-6">
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " placeholder="name@company.com" required="">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                            </div>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>

                        <button type="submit" class="w-full text-white bg-primary-400 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">LOG INTO THE SYSTEM</button>
                    </form>
                </div>
            </div>
            <div class="mr-auto place-self-center lg:col-span-6">
                <img class="hidden mx-auto lg:flex p-6" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/authentication/illustration.svg" alt="illustration">
            </div>
        </div>

    </section>


</x-guest-layout>