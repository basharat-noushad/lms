<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LearnHub') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-gray-900 selection:bg-primary-500 selection:text-white">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav x-data="{ open: false }" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center gap-8">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                                <div class="w-10 h-10 bg-gradient-to-br from-primary-600 to-primary-400 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-primary-500/30 transition-all duration-300">
                                    <span class="text-white font-bold text-xl">L</span>
                                </div>
                                <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300">LearnHub</span>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-1 sm:flex">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-full transition-all duration-200 {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                                Home
                            </a>
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-full transition-all duration-200 {{ request()->routeIs('courses.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                                Courses
                            </a>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                        @auth
                            <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                                <div @click="open = ! open">
                                    <button class="flex items-center space-x-3 pl-3 pr-2 py-1.5 border border-gray-200 dark:border-gray-700 rounded-full text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                        <span>{{ Auth::user()->name }}</span>
                                        <div class="h-8 w-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center text-primary-600 dark:text-primary-300">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                    </button>
                                </div>

                                <div x-show="open"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 z-50 mt-2 w-56 rounded-2xl shadow-xl origin-top-right bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 py-2 overflow-hidden"
                                        style="display: none;">
                                    
                                    <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Signed in as</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->email }}</p>
                                    </div>

                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">Admin Dashboard</a>
                                    @elseif(auth()->user()->isInstructor())
                                        <a href="{{ route('instructor.dashboard') }}" class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">Instructor Dashboard</a>
                                    @else
                                        <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">My Dashboard</a>
                                    @endif

                                    <a href="{{ route('profile') }}" class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">Profile</a>

                                    <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                            Log Out
                                        </a>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Log in</a>
                            <a href="{{ route('register') }}" class="ml-4 px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded-full shadow-md hover:shadow-lg hover:shadow-primary-600/30 transition-all duration-200 transform hover:-translate-y-0.5">Get Started</a>
                        @endauth
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="pt-2 pb-3 space-y-1 px-4">
                    <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }} transition duration-150 ease-in-out">
                        Home
                    </a>
                    <a href="{{ route('courses.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('courses.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }} transition duration-150 ease-in-out">
                        Courses
                    </a>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-4 border-t border-gray-200 dark:border-gray-700">
                    @auth
                        <div class="px-6 mb-3">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="space-y-1 px-4">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 transition duration-150 ease-in-out">Admin Dashboard</a>
                            @elseif(auth()->user()->isInstructor())
                                <a href="{{ route('instructor.dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 transition duration-150 ease-in-out">Instructor Dashboard</a>
                            @else
                                <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 transition duration-150 ease-in-out">My Dashboard</a>
                            @endif
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-3 rounded-xl text-base font-medium text-red-600 hover:bg-red-50 transition duration-150 ease-in-out">
                                    Log Out
                                </a>
                            </form>
                        </div>
                    @else
                        <div class="mt-3 space-y-1 px-4">
                            <a href="{{ route('login') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 transition duration-150 ease-in-out">Log in</a>
                            <a href="{{ route('register') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-primary-600 bg-primary-50 hover:bg-primary-100 transition duration-150 ease-in-out">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <div class="col-span-1 md:col-span-1">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2 mb-4">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary-600 to-primary-400 rounded-lg flex items-center justify-center shadow-md">
                                <span class="text-white font-bold text-lg">L</span>
                            </div>
                            <span class="text-xl font-bold text-gray-900 dark:text-white">LearnHub</span>
                        </a>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-6">
                            Empowering learners worldwide with high-quality courses from expert instructors. Learn at your own pace, anywhere, anytime.
                        </p>
                        <div class="flex space-x-4">
                            <!-- Social Media Icons (Placeholders) -->
                            <a href="#" class="text-gray-400 hover:text-primary-600 transition-colors">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary-600 transition-colors">
                                <span class="sr-only">GitHub</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider mb-4">Platform</h3>
                        <ul class="space-y-3">
                            <li><a href="{{ route('courses.index') }}" class="text-base text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white transition-colors">Browse Courses</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white transition-colors">Mentorship</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white transition-colors">Become an Instructor</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white transition-colors">Pricing</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider mb-4">Support</h3>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-base text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white transition-colors">Help Center</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white transition-colors">Terms of Service</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white transition-colors">Privacy Policy</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white transition-colors">Contact Us</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider mb-4">Stay Connected</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            Subscribe to our newsletter for the latest updates and special offers.
                        </p>
                        <form class="flex flex-col space-y-2">
                            <input type="email" placeholder="Enter your email" class="px-4 py-2 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                            <button type="submit" class="px-4 py-2 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors shadow-sm">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
                <div class="mt-16 border-t border-gray-200 dark:border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-400">
                        &copy; {{ date('Y') }} LearnHub LMS. All rights reserved.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <span class="text-sm text-gray-400">Made with ❤️ for learning.</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
