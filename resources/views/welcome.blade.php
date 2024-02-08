<x-main-layout>
    {{-- page banner --}}
    <section class="relative overflow-hidden py-28 px-4 bg-gray-900 md:px-8">
        <div class="w-full h-full rounded-full bg-gradient-to-r from-[#58AEF1] to-pink-500 absolute -top-12 -right-14 blur-2xl opacity-10"></div>
        <div class="max-w-xl mx-auto text-center relative">
            <div class="py-4">
                <h3 class="text-3xl text-gray-200 font-semibold md:text-4xl">
                    Get Unlimited Access To Your Digitalized Records
                </h3>
                <p class="text-gray-300 leading-relaxed mt-3">
                    {{-- Nam erat risus, sodales sit amet lobortis ut, finibus eget metus. Cras aliquam ante ut tortor posuere feugiat. Duis sodales nisi id porta lacinia. --}}
                </p>
            </div>
            <div class="mt-5 items-center justify-center gap-3 sm:flex">
                <a href="#logins" class="block w-full mt-2 py-2.5 px-8 text-gray-700 bg-white rounded-md duration-150 hover:bg-gray-100 sm:w-auto">
                    Login
                </a>
                <a href="/register" class="block w-full mt-2 py-2.5 px-8 text-gray-300 bg-gray-700 rounded-md duration-150 hover:bg-gray-800 sm:w-auto">
                    Register with us
                </a>
            </div>
        </div>
    </section>

    <section id="logins" class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="max-w-7xl mx-auto w-full p-6 lg:p-8">
            <div class="flex justify-center">
                <h2 class="text-3xl mt-4 pb-4 border-b border-slate-400 px-4">Choose Login Type</h2>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <x-welcome-tag href="/admin-login" tag_name="Admin Login" icon="fas fa-user-clock"/>
                    <x-welcome-tag href="/teacher-login" tag_name="Teacher Login" icon="fas fa-person-chalkboard" />
                    <x-welcome-tag href="/login" tag_name="Student Login" icon="fas fa-user-graduate" />
                    <x-welcome-tag href="/schools" tag_name="Our Schools" icon="fas fa-school-flag" />
                    <x-welcome-tag href="/register" tag_name="Register School" icon="fas fa-school-circle-check" />
                </div>
            </div>

            <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </div>
    </section>

</x-main-layout>
