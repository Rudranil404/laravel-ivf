<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - IVF APP</title>
    
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            /* Soft, cool background to let the glass and brand colors pop */
            background: linear-gradient(135deg, #f0f4f8 0%, #e8edf3 50%, #dbe4ed 100%);
            background-attachment: fixed;
        }
        
        /* Bento Box Glass Cards */
        .bento-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 30px rgba(57, 87, 150, 0.05); /* Tinted shadow */
            border-radius: 1.5rem;
        }

        /* Floating Nav Elements */
        .pill-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 1);
            box-shadow: 0 4px 20px rgba(57, 87, 150, 0.08);
        }

        /* Dark Card (Deep customized Navy based on #395796) */
        .dark-card {
            background: #1e2e4f; 
            border-radius: 1.5rem;
            color: white;
            box-shadow: 0 20px 40px rgba(30, 46, 79, 0.25);
            border: 1px solid #2a3d66;
        }
        
        /* Custom Scrollbar for the table */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden text-slate-800 pb-12">

    <nav class="max-w-[1400px] mx-auto px-6 py-6 flex justify-between items-center z-50 relative">
        <div class="pill-nav px-6 py-3 rounded-full flex items-center">
            <img src="{{ asset('assets/images/logo.png') }}" alt="IVF Logo" class="w-7 h-7 object-contain mr-3 mix-blend-multiply">
            <span class="text-lg font-bold text-[#395796] tracking-wide">IVF Super-Admin</span>
        </div>

        <div class="hidden lg:flex pill-nav p-1.5 rounded-full items-center space-x-1">
            <a href="{{ route('superadmin.dashboard') }}" class="bg-[#395796] text-white px-7 py-2.5 rounded-full text-sm font-semibold shadow-md shadow-[#395796]/30 transition-all">
                Dashboard
            </a>
            <a href="{{ route('superadmin.clinics.index') }}" class="text-slate-600 hover:bg-[#395796]/10 hover:text-[#395796] px-7 py-2.5 rounded-full text-sm font-medium transition-all">
                Register Clinic
            </a>
            <a href="{{ route('password.change') }}" class="text-slate-600 hover:bg-[#395796]/10 hover:text-[#395796] px-7 py-2.5 rounded-full text-sm font-medium transition-all">
                Security
            </a>
        </div>

        <div class="flex items-center space-x-3">
            <div class="pill-nav w-12 h-12 rounded-full flex items-center justify-center cursor-pointer hover:bg-[#395796]/10 hover:text-[#395796] transition-all text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="pill-nav w-12 h-12 rounded-full flex items-center justify-center hover:bg-[#E97F95]/10 text-slate-500 hover:text-[#E97F95] transition-all group" title="Logout">
                    <svg class="w-5 h-5 ml-1 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-[1400px] mx-auto px-6">
        
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl mb-6 shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-end mt-2 mb-10">
            <div class="lg:col-span-7">
                <h1 class="text-4xl md:text-5xl font-light text-slate-900 tracking-tight">
                    Overview, <span class="font-semibold text-[#395796]">{{ explode(' ', auth()->user()->name)[0] }}</span>
                </h1>
                
                <div class="mt-8 flex items-center space-x-6">
                    <div class="flex flex-col">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Global Network Status</span>
                        <div class="flex items-center space-x-2">
                            <span class="bg-[#1e2e4f] text-white text-xs px-3 py-1 rounded-full font-medium">14% Load</span>
                            <span class="bg-[#E97F95]/10 text-[#E97F95] text-xs px-3 py-1 rounded-full font-bold border border-[#E97F95]/20">Optimal</span>
                        </div>
                    </div>
                    <div class="flex-grow h-3 bg-slate-200/80 rounded-full overflow-hidden flex shadow-inner">
                        <div class="w-[14%] bg-[#395796] h-full rounded-full shadow-[0_0_10px_rgba(57,87,150,0.8)]"></div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 flex justify-between items-end border-b border-slate-300/60 pb-4 px-2">
                <div class="flex flex-col items-center group">
                    <div class="w-10 h-10 rounded-full bg-[#395796]/10 text-[#395796] flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="text-4xl font-bold text-slate-800 leading-none">{{ $totalClinics }}</span>
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mt-2">Total Clinics</span>
                </div>
                
                <div class="flex flex-col items-center group">
                    <div class="w-10 h-10 rounded-full bg-[#E97F95]/10 text-[#E97F95] flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-4xl font-bold text-slate-800 leading-none">{{ $activeClinics }}</span>
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mt-2">Active</span>
                </div>

                <div class="flex flex-col items-center group">
                    <div class="w-10 h-10 rounded-full bg-[#395796]/10 text-[#395796] flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <span class="text-4xl font-bold text-slate-800 leading-none">{{ $totalUsers }}</span>
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mt-2">Global Users</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-8 bento-card p-8 flex flex-col">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-[#395796]">Clinic Directory</h2>
                        <p class="text-sm text-slate-500 mt-1">Manage all registered medical environments</p>
                    </div>
                    <a href="{{ route('superadmin.clinics.index') }}" class="px-5 py-2.5 bg-[#395796]/10 text-[#395796] font-semibold text-sm rounded-xl border border-[#395796]/20 hover:bg-[#395796] hover:text-white transition-all shadow-sm">
                        + Add Clinic
                    </a>
                </div>

                <div class="overflow-x-auto flex-grow">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[11px] text-slate-400 uppercase tracking-widest border-b border-slate-200">
                                <th class="pb-4 font-semibold">Clinic Detail</th>
                                <th class="pb-4 font-semibold text-center">Branches</th>
                                <th class="pb-4 font-semibold text-center">Users</th>
                                <th class="pb-4 font-semibold">Status</th>
                                <th class="pb-4 font-semibold text-right">Manage</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($clinics as $clinic)
                                <tr class="group hover:bg-[#395796]/5 transition-colors">
                                    <td class="py-4">
                                        <p class="text-sm font-bold text-slate-800">{{ $clinic->name }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $clinic->email }}</p>
                                    </td>
                                    <td class="py-4 text-center">
                                        <span class="text-sm font-medium text-slate-700">{{ $clinic->max_branches }}</span>
                                    </td>
                                    <td class="py-4 text-center">
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-md bg-white border border-slate-200 text-xs font-bold text-slate-600 shadow-sm">
                                            {{ $clinic->users_count }}
                                        </span>
                                    </td>
                                    <td class="py-4">
                                        @if($clinic->is_active)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#E97F95]/10 text-[#E97F95] border border-[#E97F95]/20">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#E97F95] mr-1.5 animate-pulse"></span> ACTIVE
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mr-1.5"></span> INACTIVE
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-right">
                                        <button class="opacity-0 group-hover:opacity-100 text-[#395796] hover:text-[#1e2e4f] text-xs font-bold transition-all bg-white px-3 py-1.5 border border-slate-200 rounded-lg shadow-sm">
                                            EDIT
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400 text-sm">
                                        No clinics found. Get started by registering one.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="lg:col-span-4 flex flex-col gap-8">
                
                <div class="dark-card p-8 relative overflow-hidden flex-shrink-0">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-[#E97F95] rounded-full mix-blend-screen filter blur-[60px] opacity-30"></div>

                    <div class="flex justify-between items-end mb-6 relative z-10">
                        <h3 class="text-xl font-bold text-white">Quick Actions</h3>
                        <div class="w-8 h-8 rounded-full bg-[#2a3d66] flex items-center justify-center border border-[#395796]">
                            <svg class="w-4 h-4 text-[#E97F95]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>

                    <div class="space-y-3 relative z-10">
                        <a href="{{ route('superadmin.clinics.index') }}" class="flex items-center justify-between p-4 rounded-xl bg-[#2a3d66] hover:bg-[#324877] border border-[#395796] transition-all group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-[#E97F95] text-white flex items-center justify-center mr-4 group-hover:scale-110 transition-transform shadow-lg shadow-[#E97F95]/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-white text-sm">New Clinic</p>
                                    <p class="text-[11px] text-[#94a3b8] mt-0.5">Deploy new environment</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('password.change') }}" class="flex items-center justify-between p-4 rounded-xl bg-[#1e2e4f] hover:bg-[#2a3d66] border border-[#2a3d66] transition-all group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-[#15213d] text-slate-300 flex items-center justify-center mr-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-white text-sm">Security</p>
                                    <p class="text-[11px] text-[#94a3b8] mt-0.5">Update credentials</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="bento-card p-6 flex-grow flex flex-col">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-sm font-bold text-slate-800">Registration Trend</h3>
                        <span class="text-[10px] font-bold bg-[#E97F95]/10 text-[#E97F95] px-2 py-1 rounded-md border border-[#E97F95]/20">+12%</span>
                    </div>
                    
                    <div class="flex items-end justify-between h-24 gap-2 mt-auto">
                        <div class="w-full bg-[#395796]/20 rounded-t-md h-[30%] relative group"><div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">Jan</div></div>
                        <div class="w-full bg-[#395796]/30 rounded-t-md h-[45%] relative group"><div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">Feb</div></div>
                        <div class="w-full bg-[#395796]/40 rounded-t-md h-[60%] relative group"><div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">Mar</div></div>
                        <div class="w-full bg-[#395796]/60 rounded-t-md h-[50%] relative group"><div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">Apr</div></div>
                        <div class="w-full bg-[#E97F95] rounded-t-md h-[85%] relative shadow-[0_0_15px_rgba(233,127,149,0.4)] group"><div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-[#E97F95]">May</div></div>
                    </div>
                </div>
                
            </div>
            
            <div class="lg:col-span-12 bento-card p-6 flex flex-col lg:flex-row items-center justify-between">
                <div class="flex items-center mb-4 lg:mb-0">
                    <div class="w-10 h-10 rounded-full bg-[#395796]/10 text-[#395796] flex items-center justify-center mr-4 border border-[#395796]/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#395796]">Recent System Activity</p>
                        <p class="text-xs text-slate-500">Last login from <span class="font-semibold text-slate-700">Super Admin</span> at {{ now()->format('h:i A') }}</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <span class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-600 shadow-sm flex items-center">
                        <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div> System OK
                    </span>
                    <span class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-600 shadow-sm flex items-center">
                        <div class="w-2 h-2 rounded-full bg-[#395796] mr-2"></div> Backup Synced
                    </span>
                </div>
            </div>

        </div>
    </main>

</body>
</html>