<x-public-layout>
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-white dark:bg-gray-900 pt-16 pb-32 space-y-24">
        <div class="relative">
            <div class="lg:mx-auto lg:grid lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-2 lg:gap-24 lg:px-8">
                <div class="mx-auto max-w-xl px-6 lg:mx-0 lg:max-w-none lg:px-0 lg:py-16">
                    <div>
                        <div class="inline-flex items-center rounded-full border border-primary-200 bg-primary-50 p-2 pr-4 sm:text-base lg:text-sm xl:text-base hover:text-gray-900">
                            <span class="rounded-full bg-primary-500 px-3 py-0.5 text-xs font-semibold leading-5 text-white">New</span>
                            <span class="ml-4 text-sm text-primary-700">Explore our latest AI courses</span>
                            <!-- Chevron -->
                            <svg class="ml-2 h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="mt-6">
                            <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                                Master new skills with <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-indigo-600">expert-led</span> online courses.
                            </h1>
                            <p class="mt-6 text-lg text-gray-500 dark:text-gray-300">
                                Unlock your potential with LearnHub. Access thousands of high-quality courses from industry experts and take your career to the next level.
                            </p>
                            <div class="mt-8 flex gap-x-4">
                                <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center rounded-full bg-primary-600 px-8 py-3 text-base font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-all duration-200 transform hover:-translate-y-1">
                                    Browse Courses
                                </a>
                                <a href="#" class="inline-flex items-center justify-center rounded-full bg-white dark:bg-gray-800 px-8 py-3 text-base font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                                    Become Instructor
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-12 sm:mt-16 lg:mt-0">
                    <div class="-mr-48 pl-6 md:-mr-16 lg:relative lg:m-0 lg:h-full lg:px-0">
                        <!-- Abstract shapes/blobs -->
                        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-primary-200/50 mix-blend-multiply blur-3xl animate-blob"></div>
                        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-indigo-200/50 mix-blend-multiply blur-3xl animate-blob animation-delay-2000"></div>

                        <img loading="lazy" class="w-full rounded-2xl shadow-2xl ring-1 ring-black ring-opacity-5 lg:absolute lg:left-0 lg:h-full lg:w-auto lg:max-w-none" src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1471&q=80" alt="Students learning together">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-gray-50 dark:bg-gray-800 py-12 sm:py-16 border-y border-gray-100 dark:border-gray-700">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-4">
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base leading-7 text-gray-600 dark:text-gray-400">Active Students</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl">10k+</dd>
                </div>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base leading-7 text-gray-600 dark:text-gray-400">Expert Instructors</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl">200+</dd>
                </div>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base leading-7 text-gray-600 dark:text-gray-400">Total Courses</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl">500+</dd>
                </div>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                    <dt class="text-base leading-7 text-gray-600 dark:text-gray-400">Satisfaction Rate</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl">4.9/5</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Featured Categories -->
    <div class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Explore Top Categories</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">Find the perfect course for your career goals from our wide range of categories.</p>
            </div>
            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-6 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-4">
                @php
                    $categories = [
                        ['name' => 'Web Development', 'icon' => 'code', 'color' => 'bg-blue-100 text-blue-600'],
                        ['name' => 'Data Science', 'icon' => 'chart-bar', 'color' => 'bg-green-100 text-green-600'],
                        ['name' => 'Digital Marketing', 'icon' => 'speakerphone', 'color' => 'bg-purple-100 text-purple-600'],
                        ['name' => 'Design', 'icon' => 'pencil', 'color' => 'bg-pink-100 text-pink-600'],
                    ];
                @endphp
                @foreach($categories as $category)
                    <div class="relative flex items-center space-x-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-primary-500 hover:shadow-lg hover:border-primary-200 transition-all duration-300">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $category['color'] }}">
                                <!-- Icon Placeholder -->
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <a href="#" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $category['name'] }}</p>
                                <p class="truncate text-sm text-gray-500 dark:text-gray-400">100+ Courses</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Featured Courses Section -->
    <div class="bg-gray-50 dark:bg-gray-900 py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Featured Courses</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">Hand-picked courses to help you get started on your journey.</p>
            </div>

            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                <!-- Mock Course Card 1 -->
                <article class="flex flex-col items-start justify-between rounded-3xl bg-white dark:bg-gray-800 p-4 shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                    <div class="relative w-full">
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                        <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium text-gray-900 shadow-sm">
                            $49.99
                        </div>
                    </div>
                    <div class="max-w-xl p-4">
                        <div class="mt-4 flex items-center gap-x-4 text-xs">
                            <span class="text-gray-500 dark:text-gray-400">Mar 16, 2024</span>
                            <a href="#" class="relative z-10 rounded-full bg-gray-50 dark:bg-gray-700 px-3 py-1.5 font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">Development</a>
                        </div>
                        <div class="group relative">
                            <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">
                                <a href="#">
                                    <span class="absolute inset-0"></span>
                                    Full-Stack Web Development Bootcamp
                                </a>
                            </h3>
                            <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600 dark:text-gray-400">Learn to build modern web applications with React, Node.js, and MongoDB from scratch.</p>
                        </div>
                        <div class="relative mt-8 flex items-center gap-x-4">
                            <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-10 w-10 rounded-full bg-gray-100">
                            <div class="text-sm leading-6">
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    <a href="#">
                                        <span class="absolute inset-0"></span>
                                        Michael Foster
                                    </a>
                                </p>
                                <p class="text-gray-600 dark:text-gray-400">Senior Developer</p>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Mock Course Card 2 -->
                <article class="flex flex-col items-start justify-between rounded-3xl bg-white dark:bg-gray-800 p-4 shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                    <div class="relative w-full">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                        <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium text-gray-900 shadow-sm">
                            $89.99
                        </div>
                    </div>
                    <div class="max-w-xl p-4">
                        <div class="mt-4 flex items-center gap-x-4 text-xs">
                            <span class="text-gray-500 dark:text-gray-400">Mar 10, 2024</span>
                            <a href="#" class="relative z-10 rounded-full bg-gray-50 dark:bg-gray-700 px-3 py-1.5 font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">Data Science</a>
                        </div>
                        <div class="group relative">
                            <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">
                                <a href="#">
                                    <span class="absolute inset-0"></span>
                                    Data Science Mastery with Python
                                </a>
                            </h3>
                            <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600 dark:text-gray-400">Master data analysis, visualization, and machine learning using Python libraries like Pandas and Scikit-Learn.</p>
                        </div>
                        <div class="relative mt-8 flex items-center gap-x-4">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-10 w-10 rounded-full bg-gray-100">
                            <div class="text-sm leading-6">
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    <a href="#">
                                        <span class="absolute inset-0"></span>
                                        Tom Cook
                                    </a>
                                </p>
                                <p class="text-gray-600 dark:text-gray-400">Data Scientist</p>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Mock Course Card 3 -->
                <article class="flex flex-col items-start justify-between rounded-3xl bg-white dark:bg-gray-800 p-4 shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                    <div class="relative w-full">
                        <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                        <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium text-gray-900 shadow-sm">
                            $59.99
                        </div>
                    </div>
                    <div class="max-w-xl p-4">
                        <div class="mt-4 flex items-center gap-x-4 text-xs">
                            <span class="text-gray-500 dark:text-gray-400">Feb 12, 2024</span>
                            <a href="#" class="relative z-10 rounded-full bg-gray-50 dark:bg-gray-700 px-3 py-1.5 font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">Design</a>
                        </div>
                        <div class="group relative">
                            <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">
                                <a href="#">
                                    <span class="absolute inset-0"></span>
                                    UI/UX Design Fundamentals
                                </a>
                            </h3>
                            <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600 dark:text-gray-400">Learn the principles of user interface and user experience design to create beautiful products.</p>
                        </div>
                        <div class="relative mt-8 flex items-center gap-x-4">
                            <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-10 w-10 rounded-full bg-gray-100">
                            <div class="text-sm leading-6">
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    <a href="#">
                                        <span class="absolute inset-0"></span>
                                        Lindsay Walton
                                    </a>
                                </p>
                                <p class="text-gray-600 dark:text-gray-400">Product Designer</p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <div class="mt-16 text-center">
                <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-x-2 rounded-full border border-gray-300 bg-white px-6 py-2 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50 transition-all duration-200">
                    View All Courses
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="relative isolate overflow-hidden bg-primary-900">
        <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Start your learning journey today.</h2>
                <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-primary-200">
                    Join thousands of students and start learning the skills you need for your future career.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="{{ route('register') }}" class="rounded-full bg-white px-8 py-3.5 text-sm font-semibold text-primary-900 shadow-sm hover:bg-primary-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-all duration-200 transform hover:scale-105">
                        Get started
                    </a>
                    <a href="#" class="text-sm font-semibold leading-6 text-white group flex items-center">
                        Learn more <span class="ml-1 group-hover:translate-x-1 transition-transform" aria-hidden="true">→</span>
                    </a>
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
        <svg viewBox="0 0 1024 1024" class="absolute left-1/2 top-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2 [mask-image:radial-gradient(closest-side,white,transparent)]" aria-hidden="true">
            <circle cx="512" cy="512" r="512" fill="url(#827591b1-ce8c-4110-b064-7cb85a0b1217)" fill-opacity="0.7" />
            <defs>
                <radialGradient id="827591b1-ce8c-4110-b064-7cb85a0b1217">
                    <stop stop-color="#7775D6" />
                    <stop offset="1" stop-color="#E935C1" />
                </radialGradient>
            </defs>
        </svg>
    </div>
</x-public-layout>
