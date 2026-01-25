<footer class="bg-gray-900 text-gray-300">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      <!-- Brand Section -->
      <div class="col-span-1 md:col-span-2">
        <div class="flex items-center space-x-2 mb-4">
          <x-application-logo icon="fas fa-school text-3xl text-white" />
          <span class="text-xl font-bold text-white">{{ config('app.name', 'EduRecordsGH') }}</span>
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
    <div class="mt-8 pt-8 border-t border-gray-800">
      <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
        <p class="text-gray-400 text-sm">
          &copy; {{ date('Y') }} {{ config('app.name', 'EduRecordsGH') }}. All rights reserved.
        </p>
        <div class="flex items-center space-x-6">
          <a href="javascript:void(0)" class="text-gray-400 hover:text-white transition-colors duration-200" aria-label="Privacy Policy">
            Privacy Policy
          </a>
          <a href="javascript:void(0)" class="text-gray-400 hover:text-white transition-colors duration-200" aria-label="Terms of Service">
            Terms of Service
          </a>
        </div>
      </div>
    </div>
  </div>
</footer>
