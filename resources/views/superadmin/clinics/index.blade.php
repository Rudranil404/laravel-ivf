<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <title>Organization Management - IVF Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; }
        .glass-sidebar { background: #ffffff; border-right: 1px solid #eaedf1; }
        .btn-outline-red { color: #f87171; background: #fef2f2; border: 1px solid #fecaca; transition: all 0.2s; }
        .btn-outline-red:hover { background: #fee2e2; }
        .btn-outline-purple { color: #8b5cf6; background: #f5f3ff; border: 1px solid #ede9fe; transition: all 0.2s; }
        .btn-outline-purple:hover { background: #ede9fe; }
        .btn-outline-yellow { color: #f59e0b; background: #fffbeb; border: 1px solid #fde68a; transition: all 0.2s; }
        .btn-outline-yellow:hover { background: #fef3c7; }
        .btn-solid-blue { background: #3b82f6; color: white; border: 1px solid #3b82f6; transition: all 0.2s; }
        .btn-solid-blue:hover { background: #2563eb; }
        .badge-id { background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; padding: 2px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; }
        .status-active { color: #10b981; background: #ecfdf5; padding: 4px 16px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .status-suspended { color: #ef4444; background: #fef2f2; padding: 4px 16px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .input-field { width: 100%; padding: 0.625rem 1rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; outline: none; transition: all 0.2s;}
        .input-field:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800" x-data="setupForm()">

    <aside class="w-[260px] h-full glass-sidebar flex flex-col flex-shrink-0 z-40">
        <div class="h-24 px-8 flex items-center mt-2">
            <img src="{{ asset('assets/images/logo.png') }}" alt="IVF Logo" class="w-8 h-8 object-contain mr-3 mix-blend-multiply">
            <span class="text-xl font-bold text-[#395796]">IVF Portal</span>
        </div>
        
        <div class="px-8 mt-2 mb-6">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">LOGGED IN AS</p>
            <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'System Super Admin' }}</p>
            <p class="text-[11px] text-[#f87171] font-semibold mt-0.5">Super Administrator</p>
        </div>

        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-xl transition-all font-semibold text-sm">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg> Dashboard
            </a>
            <a href="{{ route('superadmin.clinics.index') }}" class="flex items-center px-4 py-3 bg-[#395796] text-white rounded-xl font-semibold text-sm shadow-md">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg> Clinic Directory
            </a>
        </nav>

        <div class="p-4 mb-4">
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-red-500 rounded-xl transition-all font-semibold text-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg> Sign Out
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 h-screen overflow-y-auto flex flex-col relative">
        <div class="h-1.5 w-full bg-[#fcd34d] absolute top-0 left-0 z-40"></div>
        <header class="h-[72px] px-8 flex justify-between items-center bg-white border-b border-slate-200 sticky top-0 z-30 flex-shrink-0 pt-1.5">
            <div class="text-[13px] font-bold text-slate-500">
                Network Management <span class="mx-2 font-normal text-slate-300">/</span> <span class="text-[#3b82f6]">Organizations & Branches</span>
            </div>
            <button @click="openModal = true" class="bg-[#3b82f6] hover:bg-[#2563eb] text-white px-5 py-2.5 rounded-lg font-bold text-[13px] transition-colors shadow-sm">
                + Register New Group
            </button>
        </header>

        <div class="p-10 w-full max-w-[1500px] mx-auto flex-1">
            @if(session('success'))
                <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg border border-green-200 font-semibold text-sm mb-6">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 text-red-700 px-4 py-3 rounded-lg border border-red-200 font-semibold text-sm mb-6">{{ $errors->first() }}</div>
            @endif

            <div class="bg-white rounded-xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-slate-200 overflow-hidden w-full mb-10">
                
                <div class="grid grid-cols-12 gap-4 px-8 py-4 bg-white border-b border-slate-200 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    <div class="col-span-3 pl-2">Location & Branch</div>
                    <div class="col-span-3">Details</div>
                    <div class="col-span-2">License Validity</div>
                    <div class="col-span-2">Status</div>
                    <div class="col-span-2 text-right pr-2">Actions</div>
                </div>

                @forelse($organizations ?? [] as $org)
                    <div class="bg-white border-b border-slate-200 px-8 py-5 flex justify-between items-center">
                        <div class="flex items-center space-x-4 pl-2">
                            <div class="w-10 h-10 bg-[#eff6ff] text-[#3b82f6] rounded-lg border border-[#bfdbfe] flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-black text-slate-800 text-[17px] leading-tight">{{ $org->org_name }}</h3>
                                <p class="text-[11px] font-semibold text-slate-400 mt-0.5">Organization Group</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3 pr-2">
                            <form action="{{ route('superadmin.organizations.destroy', $org->id) }}" method="POST" onsubmit="return confirm('WARNING: Deleting this organization will permanently delete all its branches. Continue?');" class="m-0 p-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-outline-red px-3 py-1.5 rounded-md text-[11px] font-bold flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete Org
                                </button>
                            </form>
                            <button @click="openViewAdminsModal({{ $org->clinics->flatMap->users->toJson() ?? '[]' }})" class="btn-outline-purple px-3 py-1.5 rounded-md text-[11px] font-bold flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View Admins
                            </button>
                            <button @click="openEditOrgModal({{ $org->toJson() }})" class="btn-outline-yellow px-4 py-1.5 rounded-md text-[11px] font-bold flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg> Edit Name
                            </button>
                            <button @click="openCreateAdminModal({{ $org->toJson() }})" class="btn-outline-purple px-4 py-1.5 rounded-md text-[11px] font-bold flex items-center">
                                Create Admin
                            </button>
                            <button @click="openAddBranchModal({{ $org->toJson() }})" class="btn-solid-blue px-4 py-1.5 rounded-md text-[11px] font-bold flex items-center">
                                + Add Branch
                            </button>
                        </div>
                    </div>

                    @foreach($org->clinics as $branch)
                    <div class="grid grid-cols-12 gap-4 px-8 py-5 border-b border-slate-100 items-center bg-white hover:bg-slate-50 transition-colors">
                        
                        <div class="col-span-3 flex items-start space-x-4 pl-4 pt-1">
                            <svg class="w-4 h-4 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-[13px] font-bold text-slate-600">{{ $branch->state ? $branch->state . ' - ' . $branch->country : $branch->address_line_1 }}</span>
                        </div>
                        
                        <div class="col-span-3">
                            <div class="flex items-center space-x-2">
                                <span class="font-bold text-slate-800 text-[13px]">{{ $branch->name }} {!! $branch->is_main_branch ? '<span class="text-[10px] text-[#f59e0b] ml-1 font-black uppercase">(Hub)</span>' : '' !!}</span>
                                <span class="badge-id">ID: {{ $branch->customer_id ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center text-[11px] font-semibold text-slate-500 mt-1.5">
                                <span>{{ $branch->contacts->first()->phone ?? '+91 N/A' }}</span>
                                @if($branch->mrn_prefix)
                                    <span class="ml-3 px-2 py-0.5 bg-[#f5f3ff] text-[#8b5cf6] border border-[#ede9fe] rounded font-bold">MRN: {{ $branch->mrn_prefix }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-span-2 text-[11px] pt-1">
                            <span class="text-slate-400 font-medium">Valid till:</span><br>
                            <span class="font-bold {{ \Carbon\Carbon::parse($branch->exp_date)->isPast() ? 'text-red-500' : 'text-slate-800' }}">
                                {{ \Carbon\Carbon::parse($branch->exp_date)->format('n/j/Y') }}
                            </span>
                        </div>

                        <div class="col-span-2 pt-2">
                            <span class="{{ $branch->is_active ? 'status-active' : 'status-suspended' }}">{{ $branch->is_active ? 'Active' : 'Suspended' }}</span>
                        </div>

                        <div class="col-span-2 flex justify-end space-x-4 pr-4 pt-1 text-slate-400 items-center">
                            
                            <button @click="openMrnModal({{ $branch->toJson() }})" class="hover:text-[#8b5cf6] transition-colors" title="Set MRN Prefix">
                                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </button>

                            <button @click="openEditBranchModal({{ $branch->toJson() }}, '{{ $branch->contacts->first()->phone ?? '' }}')" class="hover:text-[#3b82f6] transition-colors" title="Edit Branch">
                                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            
                            <form action="{{ route('superadmin.clinics.toggle-status', $branch->id) }}" method="POST" class="m-0 p-0">
                                @csrf @method('PUT')
                                <button type="submit" class="hover:text-green-500 transition-colors" title="{{ $branch->is_active ? 'Suspend Branch' : 'Activate Branch' }}">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </button>
                            </form>

                            @if($branch->is_main_branch)
                                <button type="button" class="text-slate-200 cursor-not-allowed" title="Main Hubs cannot be deleted directly. Delete the Organization instead.">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            @else
                                <form action="{{ route('superadmin.clinics.destroy', $branch->id) }}" method="POST" class="m-0 p-0" onsubmit="return confirm('Are you sure you want to delete this branch? This action cannot be undone.');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-300 hover:text-red-500 transition-colors" title="Delete Branch">
                                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @empty
                    <div class="px-8 py-16 text-center text-slate-500">
                        <p class="font-bold text-lg text-slate-700">No organizations found.</p>
                        <p class="text-sm mt-1">Click "+ Register New Group" to get started.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <div x-show="mrnModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="mrnModal = false"></div>
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-bold mb-2 text-slate-800">Set MRN Prefix</h2>
            <p class="text-[11px] text-slate-500 mb-6 font-medium">Define the record prefix for <span x-text="activeBranch.name" class="font-bold text-slate-700"></span>.</p>
            <form :action="'/superadmin/clinics/' + activeBranch.id + '/mrn'" method="POST">
                @csrf @method('PUT')
                <div>
                    <label class="text-[11px] font-bold text-slate-500 uppercase">Prefix Identifier</label>
                    <input type="text" name="mrn_prefix" x-model="activeBranch.mrn_prefix" class="input-field mt-1 mb-6" placeholder="e.g., IVF-DEL-">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="mrnModal = false" class="px-4 py-2 font-bold text-slate-500 text-sm">Cancel</button>
                    <button type="submit" class="bg-[#8b5cf6] text-white px-6 py-2 rounded-lg font-bold text-sm shadow-sm">Save Prefix</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="openModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="openModal = false"></div>
        <div class="relative bg-white w-full max-w-4xl rounded-2xl shadow-2xl flex flex-col overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center space-x-6 bg-slate-50">
                <div class="flex items-center space-x-2 text-[#3b82f6]">
                    <span class="w-7 h-7 rounded-full border-2 flex items-center justify-center font-bold text-xs border-[#3b82f6]">1</span>
                    <span class="font-bold text-sm">Create Organization & Hub</span>
                </div>
                <button @click="openModal = false" class="ml-auto text-slate-400 hover:text-red-500 font-bold">&times; Close</button>
            </div>
            <div class="p-8">
                <form action="{{ route('superadmin.clinics.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-5 mb-6">
                        <div class="col-span-2"><label class="text-[11px] font-bold text-slate-500 uppercase">Organization Name</label><input type="text" name="org_name" required class="input-field mt-1"></div>
                        <div class="col-span-2 border-t pt-4"><h3 class="font-bold text-[#3b82f6]">Main Hub Details</h3></div>
                        <div><label class="text-[11px] font-bold text-slate-500 uppercase">Hub Branch Name</label><input type="text" name="clinic_name" required class="input-field mt-1"></div>
                        <div><label class="text-[11px] font-bold text-slate-500 uppercase">Hub Expiry Date <span class="text-red-500">*</span></label><input type="date" name="hub_exp_date" required class="input-field mt-1 text-slate-600"></div>
                        <div class="col-span-2"><label class="text-[11px] font-bold text-slate-500 uppercase">Address Line 1</label><input type="text" name="address_line_1" class="input-field mt-1"></div>
                        <div class="col-span-2"><label class="text-[11px] font-bold text-slate-500 uppercase">Hub Email (Admin login)</label><input type="email" name="admin_email" required class="input-field mt-1"></div>
                        <div><label class="text-[11px] font-bold text-slate-500 uppercase">Hub Password</label><input type="password" name="admin_password" required class="input-field mt-1"></div>
                        <div><label class="text-[11px] font-bold text-slate-500 uppercase">Confirm Password</label><input type="password" name="admin_password_confirmation" required class="input-field mt-1"></div>
                    </div>
                    <div class="flex justify-end pt-4 border-t"><button type="submit" class="bg-[#10b981] text-white px-6 py-2.5 rounded-lg font-bold text-sm shadow-sm">Register Group</button></div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="editBranchModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="editBranchModal = false"></div>
        <div class="relative bg-white w-full max-w-2xl rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-bold mb-6 text-slate-800">Edit Branch Details</h2>
            <form :action="'/superadmin/clinics/' + activeBranch.id" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="col-span-2"><label class="text-[11px] font-bold text-slate-500 uppercase">Branch Name</label><input type="text" name="name" x-model="activeBranch.name" required class="input-field mt-1"></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase">Contact Phone</label><input type="text" name="branch_phone" x-model="activeBranchPhone" class="input-field mt-1"></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase">Login Email (If applicable)</label><input type="email" name="email" x-model="activeBranch.email" class="input-field mt-1"></div>
                    <div class="col-span-2"><label class="text-[11px] font-bold text-slate-500 uppercase">Address Line 1</label><input type="text" name="address_line_1" x-model="activeBranch.address_line_1" class="input-field mt-1"></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase">State/Province</label><input type="text" name="state" x-model="activeBranch.state" class="input-field mt-1"></div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase">License Expiry Date <span class="text-red-500">*</span></label>
                        <input type="date" name="exp_date" x-model="activeBranch.exp_date" required class="input-field mt-1 text-slate-600">
                    </div>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="editBranchModal = false" class="px-4 py-2 font-bold text-slate-500">Cancel</button>
                    <button type="submit" class="bg-[#3b82f6] text-white px-6 py-2 rounded-lg font-bold">Update Details</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="addBranchModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="addBranchModal = false"></div>
        <div class="relative bg-white w-full max-w-2xl rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-bold mb-6 text-slate-800">Add New Branch to <span x-text="activeOrg.org_name" class="text-[#3b82f6]"></span></h2>
            <form :action="'/superadmin/organizations/' + activeOrg.id + '/branches'" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="col-span-2"><label class="text-[11px] font-bold text-slate-500 uppercase">Branch Name <span class="text-red-500">*</span></label><input type="text" name="clinic_name" required class="input-field mt-1" placeholder="E.g. Southside Hub"></div>
                    
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase">Login Email (ID)</label><input type="email" name="branch_email" class="input-field mt-1" placeholder="admin@branch.com"></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase">Login Password (PW)</label><input type="text" name="branch_password" class="input-field mt-1" placeholder="Branch Password"></div>
                    
                    <div class="col-span-2"><label class="text-[11px] font-bold text-slate-500 uppercase">Branch Phone</label><input type="text" name="branch_phone" class="input-field mt-1" placeholder="+1 234 567 8900"></div>
                    
                    <div class="col-span-2"><label class="text-[11px] font-bold text-slate-500 uppercase">Street Address <span class="text-red-500">*</span></label><input type="text" name="address_line_1" required class="input-field mt-1 mb-2"></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase">State/Province</label><input type="text" name="state" placeholder="State/Province" class="input-field mt-1"></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase">Expiry Date <span class="text-red-500">*</span></label><input type="date" name="exp_date" required class="input-field mt-1 text-slate-600"></div>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="addBranchModal = false" class="px-4 py-2 font-bold text-slate-500">Cancel</button>
                    <button type="submit" class="bg-[#3b82f6] text-white px-6 py-2 rounded-lg font-bold shadow-sm">Create Branch</button>
                </div>
            </form>
        </div>
    </div>
    <div x-show="editOrgModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="editOrgModal = false"></div>
        <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-bold mb-4 text-slate-800">Edit Organization Name</h2>
            <form :action="'/superadmin/organizations/' + activeOrg.id" method="POST">
                @csrf @method('PUT')
                <label class="text-[11px] font-bold text-slate-500 uppercase">Organization Name</label>
                <input type="text" name="org_name" x-model="activeOrg.org_name" required class="input-field mt-1 mb-6">
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="editOrgModal = false" class="px-4 py-2 font-bold text-slate-500">Cancel</button>
                    <button type="submit" class="bg-[#f59e0b] text-white px-6 py-2 rounded-lg font-bold">Update Name</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="createAdminModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="createAdminModal = false"></div>
        <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-bold mb-6 text-slate-800">Create Admin for <span x-text="activeOrg.org_name" class="text-[#8b5cf6]"></span></h2>
            <form :action="'/superadmin/organizations/' + activeOrg.id + '/admins'" method="POST">
                @csrf
                <div class="space-y-4 mb-6">
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase">Admin Full Name</label><input type="text" name="name" required class="input-field mt-1"></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase">Login Email</label><input type="email" name="email" required class="input-field mt-1"></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase">Password</label><input type="password" name="password" required class="input-field mt-1"></div>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="createAdminModal = false" class="px-4 py-2 font-bold text-slate-500">Cancel</button>
                    <button type="submit" class="bg-[#8b5cf6] text-white px-6 py-2 rounded-lg font-bold">Create Admin</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="viewAdminsModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="viewAdminsModal = false"></div>
        <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-bold mb-4 text-slate-800">Active Administrators</h2>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                <template x-for="admin in orgAdmins" :key="admin.id">
                    <div class="p-4 border border-slate-100 rounded-lg bg-slate-50 flex justify-between items-center">
                        <div>
                            <p class="font-bold text-slate-800 text-sm" x-text="admin.name"></p>
                            <p class="text-xs text-slate-500" x-text="admin.email"></p>
                        </div>
                        <span class="text-[10px] bg-purple-100 text-purple-700 font-bold px-2 py-1 rounded">Admin</span>
                    </div>
                </template>
                <div x-show="orgAdmins.length === 0" class="text-sm text-slate-500 py-4 text-center">No admins found.</div>
            </div>
            <div class="mt-6 text-right">
                <button type="button" @click="viewAdminsModal = false" class="px-6 py-2 bg-slate-200 text-slate-700 rounded-lg font-bold">Close</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('setupForm', () => ({
                openModal: false,
                editOrgModal: false,
                addBranchModal: false,
                createAdminModal: false,
                viewAdminsModal: false,
                editBranchModal: false,
                mrnModal: false,
                
                activeOrg: {},
                orgAdmins: [],
                activeBranch: {},
                activeBranchPhone: '',
                
                openEditOrgModal(org) {
                    this.activeOrg = org;
                    this.editOrgModal = true;
                },
                openAddBranchModal(org) {
                    this.activeOrg = org;
                    this.addBranchModal = true;
                },
                openCreateAdminModal(org) {
                    this.activeOrg = org;
                    this.createAdminModal = true;
                },
                openViewAdminsModal(admins) {
                    this.orgAdmins = admins;
                    this.viewAdminsModal = true;
                },
                openMrnModal(branch) {
                    this.activeBranch = branch;
                    this.mrnModal = true;
                },
                openEditBranchModal(branch, phone) {
                    this.activeBranch = branch;
                    if(this.activeBranch.exp_date) {
                        this.activeBranch.exp_date = this.activeBranch.exp_date.split('T')[0];
                    }
                    this.activeBranchPhone = phone;
                    this.editBranchModal = true;
                }
            }))
        })
    </script>
</body>
</html>