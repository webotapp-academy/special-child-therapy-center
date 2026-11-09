<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aura SpecialCare - Autism & Special Child School')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', 'sans-serif'],
                    },
                    fontSize: {
                        '2xs': ['0.6875rem', { lineHeight: '0.9rem' }], // 11px
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: "Plus Jakarta Sans", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col antialiased">

    <!-- Top Uniform Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-3">
                
                <!-- Left: Brand Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2.5 group">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-teal-500 flex items-center justify-center text-white shadow-sm shadow-indigo-500/30 group-hover:scale-105 transition shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="whitespace-nowrap">
                            <div class="flex items-center gap-1.5 leading-none">
                                <span class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight">Aura SpecialCare</span>
                                <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-1.5 py-0.5 rounded">v1.0</span>
                            </div>
                            <span class="text-[11px] text-slate-400 font-semibold tracking-normal block mt-0.5">Autism & Special Child Care</span>
                        </div>
                    </a>
                </div>

                <!-- Middle: Role-Specific Uniform Menu Items (NO WORD WRAP) -->
                <nav class="hidden md:flex items-center space-x-1 lg:space-x-1.5 overflow-x-auto py-1">
                    @auth
                        @if(Auth::user()->role === 'parent')
                            <!-- Parent View Navigation -->
                            <a href="{{ route('parent.progress') }}" 
                               class="h-9 px-3.5 rounded-lg text-xs font-bold inline-flex items-center gap-1.5 whitespace-nowrap shrink-0 transition bg-purple-700 text-white shadow-xs">
                                <svg class="w-4 h-4 text-rose-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span>My Child's Progress Dashboard</span>
                            </a>
                        @else
                            <!-- Admin / Therapist Navigation -->
                            <!-- 1. Dashboard -->
                            <a href="{{ route('dashboard') }}" 
                               class="h-9 px-3 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 whitespace-nowrap shrink-0 transition {{ request()->routeIs('dashboard') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                <svg class="w-4 h-4 opacity-75 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                <span>Dashboard</span>
                            </a>

                            <!-- 2. Enquiries (Admin only) -->
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('enquiries.index') }}" 
                                   class="h-9 px-3 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 whitespace-nowrap shrink-0 transition {{ request()->routeIs('enquiries.*') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>1. Enquiries</span>
                                </a>
                            @endif

                            <!-- 3. Diagnostics (Admin + Therapist) -->
                            <a href="{{ route('diagnostics.index') }}" 
                               class="h-9 px-3 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 whitespace-nowrap shrink-0 transition {{ request()->routeIs('diagnostics.*') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                <svg class="w-4 h-4 text-teal-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <span>2. Diagnostics</span>
                            </a>

                            <!-- 4. Students -->
                            <a href="{{ route('students.index') }}" 
                               class="h-9 px-3 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 whitespace-nowrap shrink-0 transition {{ request()->routeIs('students.*') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>3. Students</span>
                            </a>

                            <!-- 5. Parent Progress Portal -->
                            <a href="{{ route('parent.progress') }}" 
                               class="h-9 px-3 rounded-lg text-xs font-semibold inline-flex items-center gap-1.5 whitespace-nowrap shrink-0 transition {{ request()->routeIs('parent.*') ? 'bg-purple-700 text-white shadow-xs' : 'text-purple-700 bg-purple-50 hover:bg-purple-100' }}">
                                <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span>Parent Portal</span>
                            </a>
                        @endif
                    @endauth
                </nav>

                <!-- Right: Auth User Profile, Logout & Action Button -->
                <div class="flex items-center space-x-2 shrink-0">
                    
                    @auth
                        <!-- Logged-in User Badge -->
                        <div class="flex items-center space-x-2 px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-200 shrink-0">
                            <div class="w-6 h-6 rounded-full bg-indigo-600 text-white font-bold text-[10px] flex items-center justify-center shrink-0">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="text-left whitespace-nowrap hidden sm:block">
                                <span class="text-xs font-bold text-slate-800 block leading-tight">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] font-semibold text-slate-400 capitalize block leading-none">{{ Auth::user()->role }}</span>
                            </div>
                        </div>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST" class="inline shrink-0">
                            @csrf
                            <button type="submit" title="Sign Out" 
                                    class="h-9 px-2.5 sm:px-3 rounded-lg border border-slate-200 bg-white hover:bg-rose-50 hover:text-rose-700 hover:border-rose-200 text-slate-600 text-xs font-bold inline-flex items-center gap-1.5 whitespace-nowrap transition shadow-2xs">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>

                        @if(Auth::user()->role === 'admin')
                            <!-- Primary Action Button (Admin only) -->
                            <a href="{{ route('enquiries.create') }}" 
                               class="h-9 px-3 sm:px-3.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold inline-flex items-center gap-1.5 whitespace-nowrap shrink-0 shadow-sm shadow-blue-600/30 transition">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>New Enquiry</span>
                            </a>
                        @endif
                    @endauth
                </div>

            </div>
        </div>
    </header>

    <!-- Subheader Notification Banner -->
    @if(session('success'))
        <div class="bg-emerald-50 border-b border-emerald-200 px-4 py-2.5">
            <div class="max-w-7xl mx-auto flex items-center justify-between text-emerald-800 text-xs font-semibold">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border-b border-rose-200 px-4 py-2.5">
            <div class="max-w-7xl mx-auto flex items-center space-x-2 text-rose-800 text-xs font-semibold">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-1 py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center space-x-2">
                <span class="font-bold text-slate-700">Aura SpecialCare</span>
                <span>•</span>
                <span>Specialized Autism & SEN Education Platform</span>
            </div>
            <div class="flex items-center space-x-4 text-slate-400">
                <span>Database: <strong class="text-slate-600">special</strong> (MySQL Local XAMPP)</span>
                <span>•</span>
                @guest
                    <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Sign In</a>
                @else
                    <span class="text-slate-600 font-medium">Logged in as: <strong>{{ Auth::user()->name }}</strong></span>
                @endguest
            </div>
        </div>
    </footer>

</body>
</html>
