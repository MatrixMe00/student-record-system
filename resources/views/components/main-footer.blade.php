<footer class="bg-gray-900 text-gray-300">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
      <!-- Brand Section -->
      <div class="col-span-1 md:col-span-2">
        <div class="mb-4">
          <x-application-logo text-color="text-white" />
        </div>
        <p class="text-gray-400 leading-relaxed max-w-md">
          A comprehensive multi-tenant student record management system designed for schools to efficiently manage students, grades, payments, and academic activities.
        </p>
      </div>

      <!-- Quick Links -->
      <div>
        <h3 class="text-white font-semibold mb-4">Quick Links</h3>
        <ul class="space-y-2">
          <li>
            <a href="{{ route('index') }}" class="hover:text-white transition-colors duration-200">
              Home
            </a>
          </li>
          <li>
            <a href="{{ route('about') }}" class="hover:text-white transition-colors duration-200">
              About Us
            </a>
          </li>
          <li>
            <a href="{{ route('school.index') }}" class="hover:text-white transition-colors duration-200">
              Schools
            </a>
          </li>
          <li>
            <a href="{{ route('contact') }}" class="hover:text-white transition-colors duration-200">
              Contact Us
            </a>
          </li>
        </ul>
      </div>

      <!-- Resources -->
      <div>
        <h3 class="text-white font-semibold mb-4">Resources</h3>
        <ul class="space-y-2">
          <li>
            <a href="{{ route('admin.login') }}" class="hover:text-white transition-colors duration-200">
              Login
            </a>
          </li>
          <li>
            <a href="{{ route('register') }}" class="hover:text-white transition-colors duration-200">
              Register School
            </a>
          </li>
          @auth
            <li>
              <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors duration-200">
                Dashboard
              </a>
            </li>
          @endauth
        </ul>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="mt-6 sm:mt-8 pt-6 sm:pt-8 border-t border-gray-800">
      <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0 text-center sm:text-left">
        <p class="text-gray-400 text-sm">
          &copy; {{ date('Y') }} {{ config('app.name', 'EduRecordsGH') }}. All rights reserved.
        </p>
        <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-6">
          <a href="{{ route('privacy') }}" class="text-gray-400 hover:text-white transition-colors duration-200" aria-label="Privacy Policy">
            Privacy Policy
          </a>
          <a href="{{ route('terms') }}" class="text-gray-400 hover:text-white transition-colors duration-200" aria-label="Terms of Service">
            Terms of Service
          </a>
        </div>
      </div>
    </div>
  </div>
</footer>
