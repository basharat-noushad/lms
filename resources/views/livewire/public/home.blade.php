<div>
    <!-- Hero Section -->
    <div class="relative bg-white dark:bg-gray-900 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white dark:bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Master new skills</span>
                            <span class="block text-primary-600 xl:inline">advance your career</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 dark:text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Access thousands of high-quality courses from expert instructors. Learn at your own pace, anywhere, anytime.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('courses.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 md:py-4 md:text-lg md:px-10">
                                    Browse Courses
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary-700 bg-primary-100 hover:bg-primary-200 md:py-4 md:text-lg md:px-10">
                                    Join for Free
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1471&q=80" alt="Students learning">
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-primary-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Trusted by learners worldwide
                </h2>
                <p class="mt-3 text-xl text-primary-200 sm:mt-4">
                    Join our growing community of students and instructors.
                </p>
            </div>
            <dl class="mt-10 text-center sm:max-w-3xl sm:mx-auto sm:grid sm:grid-cols-3 sm:gap-8">
                <div class="flex flex-col">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-primary-200">
                        Active Students
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold text-white">
                        10k+
                    </dd>
                </div>
                <div class="flex flex-col mt-10 sm:mt-0">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-primary-200">
                        Courses
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold text-white">
                        500+
                    </dd>
                </div>
                <div class="flex flex-col mt-10 sm:mt-0">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-primary-200">
                        Instructors
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold text-white">
                        100+
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Popular Categories -->
    <div class="bg-gray-50 dark:bg-gray-800 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Popular Categories
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
                    Explore courses in our most popular topics.
                </p>
            </div>
            <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4">
                @foreach($popularCategories as $category)
                    <a href="{{ route('courses.index', ['category' => $category->id]) }}" class="group relative bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transition p-6 text-center border border-gray-200 dark:border-gray-600">
                        <div class="text-lg font-medium text-gray-900 dark:text-white group-hover:text-primary-600 transition">
                            {{ $category->name }}
                        </div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $category->courses_count }} courses
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Featured Courses -->
    <div class="bg-white dark:bg-gray-900 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Featured Courses
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
                    Hand-picked courses to get you started.
                </p>
            </div>
            <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($featuredCourses as $course)
                    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition">
                        <div class="flex-shrink-0">
                            @if($course->thumbnail)
                                <img class="h-48 w-full object-cover" src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}">
                            @else
                                <div class="h-48 w-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-primary-600">
                                    {{ $course->category->name ?? 'General' }}
                                </p>
                                <a href="#" class="block mt-2">
                                    <p class="text-xl font-semibold text-gray-900 dark:text-white">
                                        {{ $course->title }}
                                    </p>
                                    <p class="mt-3 text-base text-gray-500 dark:text-gray-400 line-clamp-3">
                                        {{ $course->short_description }}
                                    </p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="sr-only">{{ $course->instructor->name }}</span>
                                    <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold">
                                        {{ substr($course->instructor->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $course->instructor->name }}
                                    </p>
                                    <div class="flex space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                        <span>{{ $course->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="ml-1 text-sm font-bold text-gray-900 dark:text-white">
                                        {{ number_format($course->reviews()->avg('rating') ?? 0, 1) }}
                                    </span>
                                    <span class="ml-1 text-sm text-gray-500 dark:text-gray-400">
                                        ({{ $course->reviews()->count() }})
                                    </span>
                                </div>
                                <span class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ $course->is_free ? 'Free' : format_currency($course->price) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700">
                    View All Courses
                </a>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-primary-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                <span class="block">Ready to dive in?</span>
                <span class="block text-primary-600">Start your free trial today.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                        Get started
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-primary-600 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                        Learn more
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
