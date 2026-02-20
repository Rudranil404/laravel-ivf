<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - IVF APP</title>
    
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #f0f4f8 0%, #e8edf3 50%, #dbe4ed 100%);
            background-attachment: fixed;
        }
        
        /* Glass Sidebar */
        .glass-sidebar {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-right: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 4px 0 24px rgba(57, 87, 150, 0.05);
        }

        /* Bento Box Glass Cards */
        .bento-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 30px rgba(57, 87, 150, 0.05); 
            border-radius: 1.5rem;
        }

        /* Dark Card (Deep customized Navy based on #395796) */
        .dark-card {
            background: #1e2e4f; 
            border-radius: 1.5rem;
            color: white;
            box-shadow: 0 20px 40px rgba(30, 46, 79, 0.25);
            border: 1px solid #2a3d66;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800">

    <aside class="w-72 h-full glass-sidebar flex flex-col relative z-40 flex-shrink-0">
        <div class="h-24 px-8 flex items-center border-b border-white/60">
            <img src="{{ asset('assets/images/logo.png') }}" alt="IVF Logo" class="w-8 h-8 object-contain mr-3 mix-blend-multiply">
            <span class="text-xl font-bold text-[#395796] tracking-wide">IVF Portal</span>
        </div>

        <div class="px-8 py-6">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Logged in as</p>
            <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
            <p class="text-xs text-[#E97F95] font-medium">Super Administrator</p>
        </div>

        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center px-4 py-3.5 bg-[#395796] text-white rounded-xl shadow-md shadow-[#395796]/30 font-semibold">
                <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            
            <a href="{{ route('superadmin.clinics.index') }}" class="flex items-center px-4 py-3.5 text-slate-600 hover:bg-[#395796]/10 hover:text-[#395796] rounded-xl transition-all font-medium group">
                <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-[#395796] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Clinic Directory
            </a>
            
            <!-- <a href="{{ route('password.change') }}" class="flex items-center px-4 py-3.5 text-slate-600 hover:bg-[#395796]/10 hover:text-[#395796] rounded-xl transition-all font-medium group">
                <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-[#395796] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Security Settings
            </a> -->
        </nav>

        <div class="p-4 border-t border-white/60">
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3.5 text-slate-600 hover:bg-[#E97F95]/10 hover:text-[#E97F95] rounded-xl transition-all font-medium group">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-[#E97F95] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 h-screen overflow-y-auto p-8 relative">
        <div class="max-w-[1400px] mx-auto">
            
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
                    <div class="flex flex-col items-center group cursor-default">
                        <div class="w-10 h-10 rounded-full bg-[#395796]/10 text-[#395796] flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span class="text-4xl font-bold text-slate-800 leading-none">{{ $totalClinics }}</span>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mt-2">Total Clinics</span>
                    </div>
                    
                    <div class="flex flex-col items-center group cursor-default">
                        <div class="w-10 h-10 rounded-full bg-[#E97F95]/10 text-[#E97F95] flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-4xl font-bold text-slate-800 leading-none">{{ $activeClinics }}</span>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mt-2">Active</span>
                    </div>

                    <div class="flex flex-col items-center group cursor-default">
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
                            <h2 class="text-2xl font-bold text-[#395796]">Clinic Directory Overview</h2>
                            <p class="text-sm text-slate-500 mt-1">Snapshot of registered medical environments</p>
                        </div>
                        <a href="{{ route('superadmin.clinics.index') }}" class="px-5 py-2.5 bg-[#395796]/10 text-[#395796] font-semibold text-sm rounded-xl border border-[#395796]/20 hover:bg-[#395796] hover:text-white transition-all shadow-sm">
                            View All Clinics &rarr;
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
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($clinics->take(5) as $clinic)
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-slate-400 text-sm">
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
        </div>
    </main>

</body>
</html>