<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In Required - Aura SpecialCare School</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: "Plus Jakarta Sans", system-ui, -apple-system, sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col justify-center py-10 sm:px-6 lg:px-8 text-slate-800 antialiased">

    <div class="sm:mx-auto sm:w-full sm:max-w-2xl text-center px-4">
        <!-- Logo -->
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-teal-500 text-white shadow-lg shadow-indigo-500/25 mb-3">
            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Aura SpecialCare</h1>
        <p class="text-xs font-bold text-slate-500 mt-1 uppercase tracking-wider">Autism & Special Child Care Management System</p>
        
        <!-- Privacy Notice -->
        <div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-200/70 text-slate-700 text-xs font-semibold">
            <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <span>Confidential Medical & Student Data: Sign In Required</span>
        </div>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-2xl px-4">

        @if(session('success'))
            <div class="mb-4 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Card Container -->
        <div class="bg-white p-6 sm:p-8 shadow-sm rounded-2xl border border-slate-200 space-y-6">

            <!-- Section 1: Three Dedicated Logins (Admin, Therapist, Parent) -->
            <div>
                <div class="text-center mb-4">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500 block">Select Your Role for 1-Click Access</span>
                    <p class="text-xs text-slate-400 mt-0.5">Choose between Admin, Therapist, or Parent view:</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    @foreach($threeLogins as $login)
                        <div class="p-4 rounded-xl border border-slate-200 hover:border-slate-300 bg-slate-50/50 hover:bg-slate-50 transition flex flex-col justify-between">
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-extrabold px-2 py-0.5 rounded-full border {{ $login['badge'] }}">
                                        {{ $login['role'] }}
                                    </span>
                                </div>
                                <h3 class="font-bold text-slate-900 text-sm mt-1">{{ $login['name'] }}</h3>
                                <p class="text-xs text-slate-500 leading-snug">{{ $login['desc'] }}</p>
                                <span class="text-[11px] font-mono text-slate-400 block pt-1">{{ $login['email'] }}</span>
                            </div>
                            <div class="pt-4 mt-3 border-t border-slate-200/60">
                                <a href="{{ route('login.quick', ['email' => $login['email']]) }}" 
                                   class="w-full py-2 px-3 rounded-lg {{ $login['btn_bg'] }} text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-2xs">
                                    <span>Sign in as {{ $login['role'] }}</span>
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Divider -->
            <div class="relative my-2">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-3 text-slate-400 font-bold">Or Sign In with Password</span></div>
            </div>

            <!-- Section 2: Standard Email & Password Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4 max-w-md mx-auto">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                    <input id="email" type="email" name="email" required value="{{ old('email') }}" placeholder="admin@specialcare.com"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden @error('email') border-rose-500 @enderror">
                    @error('email')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required placeholder="••••••••"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                        <span class="text-slate-600 font-medium">Remember me</span>
                    </label>
                    <span class="text-slate-400 font-medium">Default password: password</span>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs sm:text-sm font-bold shadow-sm transition">
                    Sign In to Portal &rarr;
                </button>
            </form>

        </div>

    </div>

</body>
</html>
