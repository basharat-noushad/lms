<x-public-layout>
    <!-- Hero Section -->
    <div class="relative bg-white dark:bg-gray-900 overflow-hidden">
        <div class="absolute inset-y-0 right-0 w-1/2 bg-gray-50 dark:bg-gray-800/50 rounded-l-[50px] transform translate-x-1/3 skew-x-12 z-0 hidden lg:block"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 lg:pt-32 lg:pb-40">
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
                <div class="lg:col-span-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-50 dark:bg-primary-900/30 border border-primary-100 dark:border-primary-800 mb-8">
                        <span class="flex h-2 w-2 rounded-full bg-primary-600"></span>
                        <span class="text-sm font-medium text-primary-700 dark:text-primary-300">New courses added weekly</span>
                    </div>

                    <h1 class="text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 dark:text-white leading-tight mb-6">
                        Unlock your potential with <span class="text-primary-600">world-class</span> learning.
                    </h1>

                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-10 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Join over 10,000 students gaining new skills every day. From coding to design, business to marketing — we have the expert-led courses you need to advance your career.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                        <a href="{{ route('courses.index') }}" class="w-full sm:w-auto px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-full transition-all duration-200 shadow-lg shadow-primary-600/30 transform hover:-translate-y-1 text-center">
                            Start Learning Now
                        </a>
                        <a href="#" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white font-bold rounded-full border border-gray-200 dark:border-gray-700 transition-all duration-200 text-center flex items-center justify-center gap-2 group">
                            <svg class="w-5 h-5 text-gray-500 group-hover:text-primary-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Watch Demo
                        </a>
                    </div>

                    <div class="mt-10 flex items-center justify-center lg:justify-start gap-6 text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <span>No credit card required</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <span>14-day free trial</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-6 mt-16 lg:mt-0 relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white dark:border-gray-800 transform rotate-1 hover:rotate-0 transition-all duration-500">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" alt="Students learning" class="w-full h-auto">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6 text-white">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="flex -space-x-2">
                                    <img class="w-8 h-8 rounded-full border-2 border-white" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=64&h=64" alt="">
                                    <img class="w-8 h-8 rounded-full border-2 border-white" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=64&h=64" alt="">
                                    <img class="w-8 h-8 rounded-full border-2 border-white" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=64&h=64" alt="">
                                </div>
                                <span class="font-medium text-sm">Join 2,000+ others currently learning</span>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Cards -->
                    <div class="absolute -top-10 -left-10 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 hidden md:block animate-bounce-slow">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-100 rounded-lg text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">Course Completed</p>
                                <p class="text-xs text-gray-500">Just now</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trusted By -->
    <div class="py-10 bg-gray-50 dark:bg-gray-800/50 border-y border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-widest mb-6">Trusted by leading companies</p>
            <div class="flex flex-wrap justify-center gap-8 md:gap-16 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
                <!-- Simple Text Logos for specific "brands" -->
                <span class="text-xl font-bold text-gray-800 dark:text-white">ACME Corp</span>
                <span class="text-xl font-bold text-gray-800 dark:text-white">GlobalBank</span>
                <span class="text-xl font-bold text-gray-800 dark:text-white">TechFlow</span>
                <span class="text-xl font-bold text-gray-800 dark:text-white">NextGen</span>
                <span class="text-xl font-bold text-gray-800 dark:text-white">Starlight</span>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="py-24 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Explore Top Categories</h2>
                <p class="text-gray-600 dark:text-gray-400 text-lg">Browse our wide selection of courses to find your next learning path.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @php
                $categories = [
                    ['name' => 'Design', 'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01'],
                    ['name' => 'Development', 'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'],
                    ['name' => 'Marketing', 'icon' => 'M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z'],
                    ['name' => 'Business', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['name' => 'Photography', 'icon' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z'],
                    ['name' => 'Music', 'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'],
                    ['name' => 'Data Science', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ['name' => 'Finance', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
                @endphp

                @foreach($categories as $cat)
                <a href="{{ route('courses.index') }}" class="group flex flex-col items-center justify-center p-8 bg-gray-50 dark:bg-gray-800 rounded-3xl border border-transparent hover:border-primary-100 hover:bg-white dark:hover:bg-gray-700 hover:shadow-xl transition-all duration-300">
                    <div class="h-14 w-14 rounded-2xl bg-white dark:bg-gray-600 shadow-sm flex items-center justify-center text-gray-400 group-hover:text-primary-600 group-hover:scale-110 transition-all duration-300 mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cat['icon'] }}" /></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $cat['name'] }}</h3>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Features Section (Alternating) -->
    <div class="py-24 bg-gray-50 dark:bg-gray-800 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Feature 1 -->
            <div class="flex flex-col lg:flex-row items-center gap-16 mb-24">
                <div class="lg:w-1/2">
                    <div class="relative">
                        <div class="absolute inset-0 bg-primary-200 dark:bg-primary-900/30 blur-3xl rounded-full opacity-30 transform -translate-x-10 translate-y-10"></div>
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" alt="Dashboard interface" class="relative rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700">
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <div class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider mb-4">Structured Learning</div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">Stay on track with our intuitive dashboard.</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                        Track your progress, resume where you left off, and earn certificates upon completion. Our platform is designed to keep you motivated.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <span class="text-gray-700 dark:text-gray-300">Personalized progress tracking</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <span class="text-gray-700 dark:text-gray-300">Interactive quizzes and assignments</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <span class="text-gray-700 dark:text-gray-300">Downloadable resources</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="flex flex-col-reverse lg:flex-row items-center gap-16">
                <div class="lg:w-1/2">
                    <div class="inline-block px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider mb-4">Expert Instructors</div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">Learn from the very best in the industry.</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                        Our instructors are industry experts, authors, and consultants who are passionate about teaching.
                    </p>
                    <a href="{{ route('courses.index') }}" class="text-primary-600 font-semibold hover:text-primary-700 flex items-center gap-2 group">
                        Meet our instructors <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                </div>
                 <div class="lg:w-1/2">
                    <div class="relative">
                        <div class="absolute inset-0 bg-purple-200 dark:bg-purple-900/30 blur-3xl rounded-full opacity-30 transform translate-x-10 -translate-y-10"></div>
                        <div class="grid grid-cols-2 gap-4">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Instructor" class="rounded-2xl shadow-lg mt-8">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Instructor" class="rounded-2xl shadow-lg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="relative py-24 bg-primary-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="relative max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Ready to start your journey?</h2>
            <p class="text-xl text-primary-200 mb-10 max-w-2xl mx-auto">
                Join our community of lifelong learners and get unlimited access to all courses for a simple monthly price.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-primary-900 font-bold rounded-full hover:bg-gray-100 transition-all duration-200 shadow-xl transform hover:-translate-y-1">
                    Get Started for Free
                </a>
                <a href="{{ route('courses.index') }}" class="px-8 py-4 bg-transparent border border-white/30 text-white font-bold rounded-full hover:bg-white/10 transition-all duration-200">
                    Browse Courses
                </a>
            </div>
        </div>
    </div>
</x-public-layout>
