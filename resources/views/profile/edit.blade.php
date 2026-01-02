<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-brand-gold rounded-xl flex items-center justify-center shadow-lg shadow-brand-gold/20">
                    <i class="fa-solid fa-user-shield text-white text-lg"></i>
                </div>
                <h2 class="font-extrabold text-2xl text-slate-900 dark:text-white leading-tight tracking-tight uppercase">
                    {{ __('Profile Settings') }}
                </h2>
            </div>
            <button onclick="toggleTheme()" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 flex items-center justify-center hover:bg-brand-gold hover:text-white transition-all">
                <i id="theme-icon" class="fa-solid fa-moon"></i>
            </button>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-brand-midnight min-h-screen transition-colors duration-300">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white dark:bg-brand-dark rounded-[2.5rem] p-8 shadow-sm border border-gray-200 dark:border-white/5 flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-brand-gold/5 rounded-full -mr-20 -mt-20 blur-3xl"></div>
                
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=DAA520&color=fff&size=128" 
                         alt="{{ Auth::user()->name }}" 
                         class="w-32 h-32 rounded-3xl shadow-2xl border-4 border-white dark:border-brand-midnight">
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 border-4 border-white dark:border-brand-dark rounded-full"></div>
                </div>

                <div class="text-center md:text-left flex-grow">
                    <h1 class="text-3xl font-black dark:text-white mb-1">
                        {{ Auth::user()->name }}
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 font-medium mb-4">
                        {{ Auth::user()->email }}
                    </p>
                    <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                        <span class="px-3 py-1 bg-brand-gold/10 text-brand-gold text-[10px] font-bold uppercase tracking-widest rounded-lg">
                            Member Since {{ Auth::user()->created_at?->format('M Y') ?? '2026' }}
                        </span>
                        <span class="px-3 py-1 bg-slate-100 dark:bg-white/5 text-slate-500 text-[10px] font-bold uppercase tracking-widest rounded-lg">
                            ID: {{ Auth::user()->id }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <section class="bg-white dark:bg-brand-dark p-8 rounded-[2rem] shadow-sm border border-gray-200 dark:border-white/5 transition-all hover:shadow-xl">
                    <div class="flex items-center gap-4 mb-8 border-b border-gray-100 dark:border-white/5 pb-6">
                        <div class="w-12 h-12 bg-blue-500/10 text-blue-500 rounded-2xl flex items-center justify-center">
                            <i class="fa-solid fa-user-pen text-lg"></i>
                        </div>
                        <h2 class="text-xl font-black dark:text-white uppercase tracking-tight">Personal Details</h2>
                    </div>
                    
                    <div class="form-style-provider">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </section>

                <section class="bg-white dark:bg-brand-dark p-8 rounded-[2rem] shadow-sm border border-gray-200 dark:border-white/5 transition-all hover:shadow-xl">
                    <div class="flex items-center gap-4 mb-8 border-b border-gray-100 dark:border-white/5 pb-6">
                        <div class="w-12 h-12 bg-green-500/10 text-green-500 rounded-2xl flex items-center justify-center">
                            <i class="fa-solid fa-shield-halved text-lg"></i>
                        </div>
                        <h2 class="text-xl font-black dark:text-white uppercase tracking-tight">Security & Privacy</h2>
                    </div>
                    
                    <div class="form-style-provider">
                        @include('profile.partials.update-password-form')
                    </div>
                </section>

            </div>

            <div class="bg-red-50 dark:bg-red-950/20 p-8 rounded-[2rem] border border-red-100 dark:border-red-900/30 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-5 text-center md:text-left">
                 
                    <div>
                        <h3 class="text-lg font-black text-red-900 dark:text-red-400 leading-tight">Delete My Account</h3>
                        <p class="text-sm text-red-700 dark:text-red-400/60 max-w-sm">This will permanently erase all your data from Oweru Real Estate.</p>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div id="toast" class="fixed bottom-10 left-1/2 -translate-x-1/2 z-50 animate-bounce">
            <div class="bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-8 py-4 rounded-2xl shadow-2xl flex items-center gap-3 border border-brand-gold/50">
                <i class="fa-solid fa-circle-check text-brand-gold"></i>
                <span class="font-bold tracking-tight uppercase text-xs">{{ session('status') }}</span>
            </div>
        </div>
    @endif

    <style>
        :root { --brand-gold: #DAA520; }
        .bg-brand-midnight { background-color: #0b0f1a; }
        .dark .bg-brand-dark { background-color: #001529; }

        /* Scoped styles to fix the injected Laravel forms */
        .form-style-provider label {
            @apply text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-2 block !important;
        }
        .form-style-provider input {
            @apply w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold transition-all text-slate-900 dark:text-white !important;
        }
        .form-style-provider button[type="submit"] {
            @apply w-full bg-brand-gold text-white font-bold py-4 rounded-xl shadow-lg shadow-brand-gold/30 hover:bg-slate-900 dark:hover:bg-white dark:hover:text-slate-900 transition-all uppercase tracking-widest text-[10px] mt-6 !important;
        }
        /* Fix the spacing Laravel adds */
        .form-style-provider .mt-6 { margin-top: 1.5rem !important; }
        .form-style-provider .mt-1 { margin-top: 0.25rem !important; }
    </style>

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const icon = document.getElementById('theme-icon');
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                icon.classList.replace('fa-sun', 'fa-moon');
            } else {
                html.classList.add('dark');
                icon.classList.replace('fa-moon', 'fa-sun');
            }
        }
        
        // Auto-hide session messages
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if(toast) toast.classList.add('hidden');
        }, 4000);
    </script>
</x-app-layout>