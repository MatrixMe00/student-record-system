<div x-data="{ open: false }">
    <header class="bg-white shadow-sm sticky top-0 z-50">
      <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <!-- Logo -->
          <div class="flex-shrink-0">
            <a href="{{ route('index') }}" class="flex items-center space-x-2">
              <x-application-logo icon="fas fa-school text-2xl" />
            </a>
          </div>

          <!-- Desktop Navigation -->
          <div class="hidden md:flex md:items-center md:space-x-8">
            <x-nav-menu-link href="{{ route('index') }}" is_current="{{ request()->routeIs('index') }}">Home</x-nav-menu-link>
            <x-nav-menu-link href="javascript:void(0)" :is_current="false">About Us</x-nav-menu-link>
            <x-nav-menu-link href="{{ route('school.index') }}" is_current="{{ request()->routeIs('school.index') }}">Schools</x-nav-menu-link>
            <x-nav-menu-link href="{{ route('contact') }}" is_current="{{ request()->routeIs('contact') }}">Contact Us</x-nav-menu-link>
            @auth
              <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                {{ auth()->user()->username }}
              </a>
            @else
              <a href="{{ route('admin.login') }}" class="px-4 py-2 text-sm font-medium text-indigo-600 border border-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors duration-200">
                Login
              </a>
            @endauth
          </div>

          <!-- Mobile menu button -->
          <div class="md:hidden">
            <button 
              @click="open = !open"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-colors duration-200"
              aria-expanded="false"
            >
              <span class="sr-only">Open main menu</span>
              <!-- Hamburger icon -->
              <svg x-show="!open" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <!-- Close icon -->
              <svg x-show="open" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Mobile Navigation -->
        <div 
          x-show="open"
          x-transition:enter="transition ease-out duration-100 transform"
          x-transition:enter-start="opacity-0 scale-95"
          x-transition:enter-end="opacity-100 scale-100"
          x-transition:leave="transition ease-in duration-75 transform"
          x-transition:leave-start="opacity-100 scale-100"
          x-transition:leave-end="opacity-0 scale-95"
          class="md:hidden"
        >
          <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
            <x-nav-menu-link href="{{ route('index') }}" is_current="{{ request()->routeIs('index') }}" class="block px-3 py-2 rounded-md text-base font-medium">Home</x-nav-menu-link>
            <x-nav-menu-link href="javascript:void(0)" :is_current="false" class="block px-3 py-2 rounded-md text-base font-medium">About Us</x-nav-menu-link>
            <x-nav-menu-link href="{{ route('school.index') }}" is_current="{{ request()->routeIs('school.index') }}" class="block px-3 py-2 rounded-md text-base font-medium">Schools</x-nav-menu-link>
            <x-nav-menu-link href="{{ route('contact') }}" is_current="{{ request()->routeIs('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium">Contact Us</x-nav-menu-link>
            @auth
              <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                {{ auth()->user()->username }}
              </a>
            @else
              <a href="{{ route('admin.login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-indigo-600 border border-indigo-600 hover:bg-indigo-50">
                Login
              </a>
            @endauth
          </div>
        </div>
      </nav>
    </header>
</div>
