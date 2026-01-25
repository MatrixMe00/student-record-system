<x-main-layout>
    @php
        // Transform schools data for Alpine.js
        $schoolsData = $schools->map(function($school) {
            return [
                'id' => $school->id,
                'name' => $school->school_name,
                'slug' => $school->school_slug,
                'district' => $school->district ?? 'N/A',
                'circuit' => $school->circuit ?? 'N/A',
                'type' => $school->school_type,
                'head' => $school->school_head,
                'email' => $school->school_email,
                'gps' => $school->gps_address ?? 'N/A',
                'boxNumber' => $school->box_number,
                'description' => $school->description ?? 'No description available.',
                'students' => $school->students_count ?? 0,
                'teachers' => $school->teachers_count ?? 0,
                'programs' => $school->programs_count ?? 0,
                'subjects' => $school->subjects_count ?? 0,
            ];
        })->toJson();
    @endphp
    <div x-data="schoolsPage({{ $schoolsData }})">
        {{-- Hero Section --}}
        <x-hero-section 
            title="Our Partner Schools"
            subtitle="Discover Basic and Secondary Schools using EduRecordsGH to manage their academic operations"
        />

        {{-- Schools Grid Section --}}
        <section class="py-20 px-4 bg-white md:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12" x-show="schools.length > 0" x-cloak>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Schools Using EduRecordsGH
                    </h2>
                    <p class="text-xl text-gray-600">
                        Explore our network of educational institutions
                    </p>
                </div>

                {{-- Search and Filter --}}
                <div class="mb-8 flex flex-col sm:flex-row gap-4" x-show="schools.length > 0" x-cloak>
                    <div class="flex-1">
                        <input 
                            type="text" 
                            x-model="searchQuery"
                            @input="filterSchools()"
                            placeholder="Search schools by name, district, or type..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                    <select 
                        x-model="filterType"
                        @change="filterSchools()"
                        class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                        <option value="">All Types</option>
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                    </select>
                </div>

                {{-- Schools Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-show="filteredSchools.length > 0">
                    <template x-for="school in filteredSchools" :key="school.id">
                        <div 
                            @click="openModal(school)"
                            class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-200 cursor-pointer border border-gray-100 overflow-hidden group"
                        >
                            {{-- School Logo/Icon --}}
                            <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                <i class="fas fa-school text-6xl text-white opacity-80 group-hover:scale-110 transition-transform duration-200"></i>
                            </div>

                            {{-- School Info --}}
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2" x-text="school.name"></h3>
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-map-marker-alt text-indigo-600 mr-2"></i>
                                        <span x-text="school.district"></span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-tag text-indigo-600 mr-2"></i>
                                        <span class="capitalize" x-text="school.type"></span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-user-tie text-indigo-600 mr-2"></i>
                                        <span x-text="school.head"></span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span class="flex items-center">
                                            <i class="fas fa-user-graduate mr-1"></i>
                                            <span x-text="school.students"></span>
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-chalkboard-teacher mr-1"></i>
                                            <span x-text="school.teachers"></span>
                                        </span>
                                    </div>
                                    <button class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">
                                        View Details <i class="fas fa-arrow-right ml-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Empty State - No Schools at All --}}
                <div x-show="schools.length === 0" class="text-center py-16" x-cloak>
                    <div class="max-w-md mx-auto">
                        <i class="fas fa-school text-6xl text-gray-300 mb-6"></i>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No Schools Available</h3>
                        <p class="text-gray-600 mb-6">
                            There are currently no schools registered on the platform. Check back later or contact us for more information.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('register') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-semibold">
                                Register Your School
                            </a>
                            <a href="{{ route('contact') }}" class="px-6 py-3 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors font-semibold">
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Empty State - No Search Results --}}
                <div x-show="schools.length > 0 && filteredSchools.length === 0" class="text-center py-12" x-cloak>
                    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Schools Found</h3>
                    <p class="text-gray-600 mb-4">No schools match your search criteria. Try adjusting your filters.</p>
                    <button 
                        @click="searchQuery = ''; filterType = '';"
                        class="px-4 py-2 text-indigo-600 hover:text-indigo-700 font-medium"
                    >
                        Clear Filters
                    </button>
                </div>
            </div>
        </section>

        {{-- School Details Modal --}}
        <div 
            x-show="isModalOpen"
            @click.away="closeModal()"
            x-cloak
            class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;"
        >
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

            {{-- Modal --}}
            <div class="flex min-h-full items-center justify-center p-4">
                <div 
                    @click.stop
                    x-show="isModalOpen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative bg-white rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto"
                >
                    {{-- Modal Header --}}
                    <div class="sticky top-0 bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-white" x-text="selectedSchool?.name"></h3>
                            <button 
                                @click="closeModal()"
                                class="text-white hover:text-gray-200 transition-colors"
                            >
                                <i class="fas fa-times text-2xl"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Modal Body --}}
                    <div class="p-6" x-show="selectedSchool">
                        {{-- School Overview --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase mb-2">School Type</h4>
                                <p class="text-lg text-gray-900 capitalize" x-text="selectedSchool?.type"></p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase mb-2">District</h4>
                                <p class="text-lg text-gray-900" x-text="selectedSchool?.district"></p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase mb-2">Circuit</h4>
                                <p class="text-lg text-gray-900" x-text="selectedSchool?.circuit"></p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase mb-2">GPS Address</h4>
                                <p class="text-lg text-gray-900" x-text="selectedSchool?.gps"></p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase mb-2">School Head</h4>
                                <p class="text-lg text-gray-900" x-text="selectedSchool?.head"></p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase mb-2">Email</h4>
                                <p class="text-lg text-gray-900" x-text="selectedSchool?.email"></p>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-500 uppercase mb-2">About</h4>
                            <p class="text-gray-700 leading-relaxed" x-text="selectedSchool?.description"></p>
                        </div>

                        {{-- Statistics --}}
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <div class="bg-indigo-50 rounded-lg p-4 text-center">
                                <i class="fas fa-user-graduate text-3xl text-indigo-600 mb-2"></i>
                                <p class="text-2xl font-bold text-gray-900" x-text="selectedSchool?.students"></p>
                                <p class="text-sm text-gray-600">Students</p>
                            </div>
                            <div class="bg-purple-50 rounded-lg p-4 text-center">
                                <i class="fas fa-chalkboard-teacher text-3xl text-purple-600 mb-2"></i>
                                <p class="text-2xl font-bold text-gray-900" x-text="selectedSchool?.teachers"></p>
                                <p class="text-sm text-gray-600">Teachers</p>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4 text-center">
                                <i class="fas fa-book text-3xl text-green-600 mb-2"></i>
                                <p class="text-2xl font-bold text-gray-900" x-text="selectedSchool?.programs"></p>
                                <p class="text-sm text-gray-600">Programs</p>
                            </div>
                            <div class="bg-yellow-50 rounded-lg p-4 text-center">
                                <i class="fas fa-graduation-cap text-3xl text-yellow-600 mb-2"></i>
                                <p class="text-2xl font-bold text-gray-900" x-text="selectedSchool?.subjects"></p>
                                <p class="text-sm text-gray-600">Subjects</p>
                            </div>
                        </div>

                        {{-- Contact Info --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-gray-500 uppercase mb-3">Contact Information</h4>
                            <div class="space-y-2">
                                <p class="text-gray-700">
                                    <i class="fas fa-envelope text-indigo-600 mr-2"></i>
                                    <span x-text="selectedSchool?.email"></span>
                                </p>
                                <p class="text-gray-700">
                                    <i class="fas fa-map-marker-alt text-indigo-600 mr-2"></i>
                                    <span x-text="selectedSchool?.boxNumber"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <button 
                                @click="closeModal()"
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors"
                            >
                                Close
                            </button>
                            <div class="flex space-x-3">
                                <a 
                                    :href="`{{ url('/schools') }}/${selectedSchool?.slug}`"
                                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-semibold"
                                >
                                    View Full Details <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function schoolsPage(schoolsData = []) {
            return {
                searchQuery: '',
                filterType: '',
                isModalOpen: false,
                selectedSchool: null,
                
                // Real data from backend
                schools: schoolsData || [
                    {
                        id: 1,
                        name: 'St. Mary\'s Basic School',
                        district: 'Accra Metropolitan',
                        circuit: 'Circuit A',
                        type: 'public',
                        head: 'Dr. John Mensah',
                        email: 'info@stmarys.edu.gh',
                        gps: 'GA-123-4567',
                        boxNumber: 'P.O. Box 123, Accra',
                        description: 'A leading public basic school in Accra, committed to providing quality education to students from diverse backgrounds. We focus on holistic development and academic excellence.',
                        students: 450,
                        teachers: 25,
                        programs: 6,
                        subjects: 12,
                        loginUrl: '#',
                        slug: 'st-marys-basic-school'
                    },
                    {
                        id: 2,
                        name: 'Premier Junior High School',
                        district: 'Kumasi Metropolitan',
                        circuit: 'Circuit B',
                        type: 'private',
                        head: 'Mrs. Grace Osei',
                        email: 'contact@premierjhs.edu.gh',
                        gps: 'KS-789-0123',
                        boxNumber: 'P.O. Box 456, Kumasi',
                        description: 'A private junior high school dedicated to academic excellence and character development. We prepare students for the BECE and beyond with modern teaching methods.',
                        students: 320,
                        teachers: 18,
                        programs: 3,
                        subjects: 10,
                        loginUrl: '#',
                        slug: 'premier-junior-high-school'
                    },
                    {
                        id: 3,
                        name: 'Ghana National Senior High School',
                        district: 'Tamale Metropolitan',
                        circuit: 'Circuit C',
                        type: 'public',
                        head: 'Mr. Ibrahim Mohammed',
                        email: 'admin@ghnshs.edu.gh',
                        gps: 'TA-456-7890',
                        boxNumber: 'P.O. Box 789, Tamale',
                        description: 'A prestigious public senior high school offering comprehensive education across science, arts, and business programs. We pride ourselves on producing well-rounded graduates.',
                        students: 850,
                        teachers: 45,
                        programs: 8,
                        subjects: 20,
                        loginUrl: '#',
                        slug: 'ghana-national-senior-high-school'
                    },
                    {
                        id: 4,
                        name: 'Excellence Academy',
                        district: 'Cape Coast',
                        circuit: 'Circuit D',
                        type: 'private',
                        head: 'Dr. Comfort Asante',
                        email: 'info@excellenceacademy.edu.gh',
                        gps: 'CC-234-5678',
                        boxNumber: 'P.O. Box 321, Cape Coast',
                        description: 'A private educational institution combining traditional values with modern teaching approaches. We offer both basic and secondary education programs.',
                        students: 280,
                        teachers: 22,
                        programs: 5,
                        subjects: 15,
                        loginUrl: '#',
                        slug: 'excellence-academy'
                    },
                    {
                        id: 5,
                        name: 'Unity Basic School',
                        district: 'Tema Metropolitan',
                        circuit: 'Circuit E',
                        type: 'public',
                        head: 'Mrs. Patience Addo',
                        email: 'unity@temametro.edu.gh',
                        gps: 'TE-567-8901',
                        boxNumber: 'P.O. Box 654, Tema',
                        description: 'A community-focused public basic school serving the Tema area. We emphasize inclusive education and community involvement in student development.',
                        students: 380,
                        teachers: 20,
                        programs: 6,
                        subjects: 11,
                        loginUrl: '#',
                        slug: 'unity-basic-school'
                    },
                    {
                        id: 6,
                        name: 'Bright Future Secondary School',
                        district: 'Takoradi',
                        circuit: 'Circuit F',
                        type: 'private',
                        head: 'Mr. Samuel Boateng',
                        email: 'contact@brightfuture.edu.gh',
                        gps: 'TK-890-1234',
                        boxNumber: 'P.O. Box 987, Takoradi',
                        description: 'A forward-thinking private secondary school preparing students for higher education and career success. We offer specialized programs in STEM and business.',
                        students: 420,
                        teachers: 28,
                        programs: 7,
                        subjects: 18,
                        loginUrl: '#',
                        slug: 'bright-future-secondary-school'
                    }
                ].filter(() => false), // This ensures demo data is never used when real data exists

                get filteredSchools() {
                    let filtered = this.schools;

                    // Filter by search query
                    if (this.searchQuery) {
                        const query = this.searchQuery.toLowerCase();
                        filtered = filtered.filter(school => 
                            school.name.toLowerCase().includes(query) ||
                            school.district.toLowerCase().includes(query) ||
                            school.type.toLowerCase().includes(query)
                        );
                    }

                    // Filter by type
                    if (this.filterType) {
                        filtered = filtered.filter(school => school.type === this.filterType);
                    }

                    return filtered;
                },

                openModal(school) {
                    this.selectedSchool = school;
                    this.isModalOpen = true;
                    document.body.style.overflow = 'hidden';
                },

                closeModal() {
                    this.isModalOpen = false;
                    this.selectedSchool = null;
                    document.body.style.overflow = 'auto';
                },

                filterSchools() {
                    // Reactive filtering is handled by computed property
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-main-layout>
