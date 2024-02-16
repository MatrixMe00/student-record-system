<div x-data="{ open: false }">
    <header>
      <nav class="relative items-center pt-5 px-4 mx-auto max-w-screen-xl sm:px-8 sm:flex sm:space-x-6">
        <div class="flex justify-between">
          <a href="/">
            {{-- <img
              src="https://www.floatui.com/logo.svg"
              width="120"
              height="50"
              alt="Float UI logo"
            /> --}}
            <x-application-logo />
          </a>
          <button class="text-gray-500 outline-none sm:hidden"
                  @click="open = !open"
          >
            <div x-if="open">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </div>
            <div x-if="!open">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </div>
          </button>
        </div>
        <ul :class="{'hidden': !open, 'block': open}" class="bg-white shadow-md rounded-md p-4 flex-1 mt-12 absolute z-20 top-8 right-4 w-64 border sm:shadow-none sm:block sm:border-0 sm:mt-0 sm:static sm:w-auto">
          <div class="order-1 justify-end items-center space-y-5 sm:flex sm:space-x-6 sm:space-y-0">
            <x-nav-menu-link href="{{ route('index') }}" is_current="{{ request()->routeIs('index') }}">Home</x-nav-menu-link>
            <x-nav-menu-link href="javascript:void(0)" :is_current="false">About Us</x-nav-menu-link>
            <x-nav-menu-link href="javascript:void(0)" :is_current="false">Schools</x-nav-menu-link>
            <x-nav-menu-link href="{{ route('contact') }}" is_current="{{ request()->routeIs('contact') }}">Contact Us</x-nav-menu-link>
            @auth
                <x-nav-menu-link href="{{ route('dashboard') }}">{{ auth()->user()->username }}</x-nav-menu-link>
            @endauth
          </div>
        </ul>
      </nav>
    </header>
</div>
