<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $clinic->name }} - Details</title>
    
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #f0f4f8 0%, #e8edf3 50%, #dbe4ed 100%); background-attachment: fixed; }
        .glass-sidebar { background: rgba(255, 255, 255, 0.65); backdrop-filter: blur(24px); border-right: 1px solid rgba(255, 255, 255, 0.9); box-shadow: 4px 0 24px rgba(57, 87, 150, 0.05); }
        .bento-card { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(24px); border: 1px solid rgba(255, 255, 255, 0.9); box-shadow: 0 10px 30px rgba(57, 87, 150, 0.05); border-radius: 1.5rem; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
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
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center px-4 py-3.5 text-slate-600 hover:bg-[#395796]/10 hover:text-[#395796] rounded-xl transition-all font-medium group">
                <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-[#395796] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('superadmin.clinics.index') }}" class="flex items-center px-4 py-3.5 bg-[#395796] text-white rounded-xl shadow-md font-semibold">
                <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Clinic Directory
            </a>
        </nav>
    </aside>

    <main class="flex-1 h-screen overflow-y-auto p-8 relative">
        <a href="{{ route('superadmin.clinics.index') }}" class="text-sm font-bold text-[#395796] hover:underline mb-4 inline-block">&larr; Back to Directory</a>
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8">
            <div>
                <h1 class="text-4xl font-light text-slate-900 tracking-tight">{{ $clinic->name }}</h1>
                <p class="text-sm text-slate-500 mt-2">Customer ID: <span class="font-bold text-slate-700">{{ $clinic->customer_id }}</span></p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-3">
                <a href="{{ route('superadmin.clinics.print', $clinic->id) }}" target="_blank" class="px-5 py-2 bg-white text-[#395796] border border-[#395796]/30 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all flex items-center shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    PRINT DETAILS
                </a>

                @if($clinic->is_active)
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-[#E97F95]/10 text-[#E97F95] border border-[#E97F95]/20 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-[#E97F95] mr-2 animate-pulse"></span> AMC ACTIVE
                    </span>
                @else
                    @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 flex flex-col gap-8">
                <div class="bento-card p-8">
                    <h3 class="text-lg font-bold text-[#395796] mb-6 border-b border-slate-200 pb-2">General Information</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Primary Email</p>
                            <p class="text-sm font-medium text-slate-800 mt-1">{{ $clinic->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Address</p>
                            <p class="text-sm font-medium text-slate-800 mt-1">
                                {{ $clinic->address_line_1 }} <br>
                                {{ $clinic->state }}, {{ $clinic->country }} {{ $clinic->zip_code }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Registered On</p>
                            <p class="text-sm font-medium text-slate-800 mt-1">{{ $clinic->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Subscription Expiry</p>
                            <p class="text-sm font-medium text-slate-800 mt-1">{{ $clinic->exp_date ? \Carbon\Carbon::parse($clinic->exp_date)->format('M d, Y') : 'Lifetime' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bento-card p-8">
                    <div class="flex justify-between items-center mb-6 border-b border-slate-200 pb-2">
                        <h3 class="text-lg font-bold text-[#395796]">Registered Branches</h3>
                        <span class="text-xs font-bold bg-[#395796]/10 text-[#395796] px-3 py-1 rounded-md">{{ $clinic->branches->count() }} / {{ $clinic->max_branches }} Allowed</span>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($clinic->branches as $branch)
                            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-slate-800">{{ $branch->name }}</p>
                                    <p class="text-xs text-slate-500 mt-1">ID: {{ $branch->branch_cust_id }} &bull; {{ $branch->state }}, {{ $branch->country }}</p>
                                </div>
                                <div>
                                    <button class="text-xs font-bold text-[#395796] hover:underline">View Branch</button>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500 py-4">No branches registered for this clinic.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 flex flex-col gap-8">
                <div class="bento-card p-8">
                    <h3 class="text-lg font-bold text-[#395796] mb-6 border-b border-slate-200 pb-2">Primary Contacts</h3>
                    <div class="space-y-5">
                        @forelse($clinic->contacts as $contact)
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-[#E97F95]/10 text-[#E97F95] flex items-center justify-center font-bold mr-4 border border-[#E97F95]/20">
                                    {{ substr($contact->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $contact->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $contact->position }} &bull; {{ $contact->phone }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">No contacts added.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>