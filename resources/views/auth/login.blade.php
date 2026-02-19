<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IVF APP</title>
    
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-teal-custom { background-color: #395796; }
        .hover-bg-teal-custom:hover { background-color: rgb(42, 147, 165); }
        .text-teal-custom { color: #2b9eb3; }
        .text-navy-custom { color: #395796; }
        
        /* Custom Glass Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.1);
        }
        
        /* Input styling */
        .glass-input {
            background: rgba(236, 242, 248, 0.7);
            border: 1px solid rgba(200, 215, 230, 0.5);
        }
    </style>
</head>
<body class="bg-white min-h-screen flex overflow-hidden">

    <div class="w-full lg:w-1/2 flex flex-col relative overflow-hidden bg-gradient-to-br from-blue-50/50 via-white to-teal-50/30">
        
        <div class="absolute top-1/4 -left-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-30"></div>
        <div class="absolute bottom-1/4 -right-10 w-72 h-72 bg-teal-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-30"></div>

        <div class="absolute top-8 left-8 sm:left-12 flex items-center z-10">
            <img src="{{ asset('assets/images/logo.png') }}" alt="IVF Logo" class="w-14 h-14 object-contain mr-3 mix-blend-multiply">
            <span class="text-2xl font-bold text-navy-custom tracking-wide">IVF - APP</span>
        </div>

        <div class="flex-grow flex items-center justify-center px-6 sm:px-12 mt-12 lg:mt-0 relative z-10">
            
            <div class="max-w-md w-full glass-card rounded-3xl p-8 sm:p-10">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back</h1>
                <p class="text-gray-500 text-sm mb-8">Welcome back! Please enter your details.</p>

                @if ($errors->any())
                    <div class="bg-red-50/80 backdrop-blur-sm border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm mb-6">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-[#2b9eb3] focus:border-[#2b9eb3] focus:bg-white outline-none transition-all placeholder-gray-400 glass-input"
                            placeholder="super@admin.com">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-[#2b9eb3] focus:border-[#2b9eb3] focus:bg-white outline-none transition-all placeholder-gray-400 glass-input"
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-[#2b9eb3] focus:ring-[#2b9eb3] border-gray-300 rounded bg-white/50">
                            <label for="remember" class="ml-2 block text-sm font-medium text-gray-600">Remember for 30 days</label>
                        </div>
                        <a href="#" class="text-sm font-semibold text-teal-custom hover:underline">Forgot password</a>
                    </div>

                    <button type="submit"
                        class="w-full bg-teal-custom hover-bg-teal-custom text-white font-semibold py-3 px-4 rounded-xl shadow-lg shadow-teal-500/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2b9eb3] transition-all mt-4">
                        Sign in
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="hidden lg:block lg:w-1/2 p-4 relative z-20 bg-white">
        <div class="relative w-full h-full rounded-3xl overflow-hidden shadow-xl bg-gray-100">
            <img src="{{ asset('assets/images/login-bg.jpg') }}" 
                alt="Mom holding newborn baby" 
                class="absolute inset-0 w-full h-full object-cover">
            
            <div class="absolute bottom-8 left-8 right-8 bg-black/30 backdrop-blur-md p-8 rounded-2xl border border-white/20">
                <p class="text-2xl text-white font-medium leading-snug mb-8">
                    "IVF - APP has streamlined our patient care and embryology processes, making our clinic more efficient and patient-focused."
                </p>
                
                <div class="flex justify-between items-end">
                    <div>
                        <h3 class="text-lg font-bold text-white">Dr. Sarah Chen</h3>
                        <p class="text-gray-300 text-sm mt-1">Reproductive Endocrinologist,<br>Hope Fertility Center</p>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button class="w-10 h-10 rounded-full border border-white/40 flex items-center justify-center text-white hover:bg-white/20 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button class="w-10 h-10 rounded-full border border-white/40 flex items-center justify-center text-white hover:bg-white/20 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>