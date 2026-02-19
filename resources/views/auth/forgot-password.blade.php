<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - IVF APP</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-teal-custom { background-color: #2b9eb3; }
        .hover-bg-teal-custom:hover { background-color: #228294; }
        .text-teal-custom { color: #2b9eb3; }
        .text-navy-custom { color: #20355b; }
        .glass-card { background: rgba(255, 255, 255, 0.55); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 10px 40px -10px rgba(0,0,0,0.1); }
        .glass-input { background: rgba(236, 242, 248, 0.7); border: 1px solid rgba(200, 215, 230, 0.5); }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50/50 via-white to-teal-50/30 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute top-1/4 -left-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-30"></div>
    <div class="absolute bottom-1/4 -right-10 w-72 h-72 bg-teal-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-30"></div>

    <div class="max-w-md w-full glass-card rounded-3xl p-8 sm:p-10 relative z-10">
        <div class="flex items-center justify-center mb-6">
            <img src="{{ asset('assets/images/logo.png') }}" alt="IVF Logo" class="w-12 h-12 object-contain mr-3 mix-blend-multiply">
        </div>
        
        <h1 class="text-2xl font-bold text-center text-gray-900 mb-2">Forgot Password?</h1>
        <p class="text-center text-gray-500 text-sm mb-8">No worries, we'll send you reset instructions.</p>

        @if (session('status'))
            <div class="bg-green-50/80 backdrop-blur-sm border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm mb-6 text-center">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50/80 backdrop-blur-sm border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm mb-6 text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-[#2b9eb3] focus:border-[#2b9eb3] focus:bg-white outline-none transition-all placeholder-gray-400 glass-input"
                    placeholder="super@admin.com">
            </div>

            <button type="submit" class="w-full bg-teal-custom hover-bg-teal-custom text-white font-semibold py-3 px-4 rounded-xl shadow-lg shadow-teal-500/20 focus:outline-none transition-all">
                Send Reset Link
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-teal-custom transition-colors">&larr; Back to log in</a>
        </div>
    </div>
</body>
</html>