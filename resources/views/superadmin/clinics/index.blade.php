<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Management - IVF APP</title>
    
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

        /* Modal Glass */
        .modal-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 25px 50px -12px rgba(57, 87, 150, 0.25);
        }

        /* Form Inputs */
        .input-field {
            width: 100%;
            padding: 0.625rem 1rem;
            border-radius: 0.75rem;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: 0.875rem;
            color: #1e293b;
            outline: none;
            transition: all 0.2s;
        }
        .input-field:focus {
            border-color: #395796;
            box-shadow: 0 0 0 3px rgba(57, 87, 150, 0.1);
            background-color: #ffffff;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800" x-data="clinicForm()">

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
            
            <a href="{{ route('superadmin.clinics.index') }}" class="flex items-center px-4 py-3.5 bg-[#395796] text-white rounded-xl shadow-md shadow-[#395796]/30 font-semibold">
                <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Clinic Directory
            </a>
            
            <a href="{{ route('password.change') }}" class="flex items-center px-4 py-3.5 text-slate-600 hover:bg-[#395796]/10 hover:text-[#395796] rounded-xl transition-all font-medium group">
                <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-[#395796] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Security Settings
            </a>
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

        <div class="flex flex-col md:flex-row justify-between items-end mb-8">
            <div>
                <h1 class="text-4xl font-light text-slate-900 tracking-tight">
                    Clinic <span class="font-semibold text-[#395796]">Management</span>
                </h1>
                <p class="text-sm text-slate-500 mt-2">Manage all registered environments, branches, and system AMC statuses.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <button @click="openModal = true" class="px-6 py-3 bg-[#395796] text-white font-semibold text-sm rounded-xl hover:bg-[#2a3d66] transition-all shadow-lg shadow-[#395796]/30 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Register New Clinic
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6 shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl mb-6 shadow-sm">
                <ul class="list-disc pl-5 text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bento-card p-8 min-h-[500px] flex flex-col">
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[11px] text-slate-400 uppercase tracking-widest border-b border-slate-200">
                            <th class="pb-4 font-semibold">Cust ID</th>
                            <th class="pb-4 font-semibold">Clinic Detail</th>
                            <th class="pb-4 font-semibold text-center">Branches</th>
                            <th class="pb-4 font-semibold">AMC Status</th>
                            <th class="pb-4 font-semibold">Expiry Date</th>
                            <th class="pb-4 font-semibold text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($clinics ?? [] as $clinic)
                            <tr class="group hover:bg-[#395796]/5 transition-colors">
                                <td class="py-5 text-xs font-bold text-[#395796]">{{ $clinic->customer_id ?? 'N/A' }}</td>
                                <td class="py-5">
                                    <p class="text-sm font-bold text-slate-800">{{ $clinic->name }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $clinic->email }}</p>
                                </td>
                                <td class="py-5 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-md bg-white border border-slate-200 text-xs font-bold text-slate-600 shadow-sm">
                                        {{ $clinic->branches->count() }} / {{ $clinic->max_branches }}
                                    </span>
                                </td>
                                <td class="py-5">
                                    @if($clinic->is_active)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-bold bg-[#E97F95]/10 text-[#E97F95] border border-[#E97F95]/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#E97F95] mr-1.5 animate-pulse"></span> ACTIVE
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mr-1.5"></span> INACTIVE
                                        </span>
                                    @endif
                                </td>
                                <td class="py-5 text-sm font-medium text-slate-600">
                                    {{ $clinic->exp_date ? \Carbon\Carbon::parse($clinic->exp_date)->format('M d, Y') : 'N/A' }}
                                </td>
                                <td class="py-5 text-right">
                                    <button class="opacity-0 group-hover:opacity-100 text-[#395796] hover:text-[#1e2e4f] text-xs font-bold transition-all bg-white px-4 py-2 border border-slate-200 rounded-lg shadow-sm">
                                        MANAGE
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-24 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mb-5 border border-slate-200 shadow-sm">
                                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <p class="text-lg font-bold text-slate-700">No clinics registered yet.</p>
                                        <p class="text-sm mt-1">Use the button above to add the first environment.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <div x-show="openModal" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4" x-cloak style="display: none;">
        
        <div x-show="openModal" x-transition.opacity class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="openModal = false"></div>

        <div x-show="openModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 scale-95"
             class="relative w-full max-w-5xl modal-glass rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            
            <div class="px-8 py-5 border-b border-slate-200 flex justify-between items-center bg-white/50">
                <h2 class="text-xl font-bold text-[#395796] flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Register New Clinic
                </h2>
                <button @click="openModal = false" class="text-slate-400 hover:text-[#E97F95] transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-8 overflow-y-auto custom-scrollbar">
                <form id="clinicForm" action="{{ route('superadmin.clinics.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div>
                        <h3 class="text-sm font-bold text-[#395796] uppercase tracking-widest mb-4 border-b border-slate-200/60 pb-2">Clinic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Clinic Name <span class="text-red-500">*</span></label>
                                <input type="text" name="clinic_name" required class="input-field" placeholder="E.g., Hope Fertility Center">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Clinic AMC Status <span class="text-red-500">*</span></label>
                                <select name="amc_status" class="input-field">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Address Line 1 <span class="text-red-500">*</span></label>
                                <input type="text" name="address_line_1" required class="input-field" placeholder="123 Medical Plaza">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Address Line 2</label>
                                <input type="text" name="address_line_2" class="input-field" placeholder="Suite / Floor (Optional)">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Country <span class="text-red-500">*</span></label>
                                <select name="country" required class="input-field">
                                    <option value="US">United States</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="IN">India</option>
                                    <option value="AU">Australia</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">State/Province <span class="text-red-500">*</span></label>
                                <input type="text" name="state" required class="input-field" placeholder="State">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">ZIP/Postal Code <span class="text-red-500">*</span></label>
                                <input type="text" name="zip_code" required class="input-field" placeholder="10001">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center border-b border-slate-200/60 pb-2 mb-4">
                            <h3 class="text-sm font-bold text-[#395796] uppercase tracking-widest">Clinic Contact Numbers</h3>
                            <button type="button" @click="addContact('clinic')" class="text-xs font-bold text-[#395796] bg-[#395796]/10 px-3 py-1.5 rounded-lg hover:bg-[#395796]/20 transition-colors shadow-sm">+ Add Contact</button>
                        </div>
                        
                        <div class="space-y-3">
                            <template x-for="(contact, index) in clinicContacts" :key="contact.id">
                                <div class="flex gap-3 items-end bg-slate-50 p-4 rounded-xl border border-slate-200 shadow-sm">
                                    <div class="flex-1">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase">Contact Name</label>
                                        <input type="text" :name="'clinic_contacts['+index+'][name]'" class="input-field py-2 mt-1" placeholder="John Doe">
                                    </div>
                                    <div class="w-1/4">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase">Position</label>
                                        <select :name="'clinic_contacts['+index+'][position]'" class="input-field py-2 mt-1">
                                            <option value="Reception">Reception</option>
                                            <option value="Doctor">Doctor</option>
                                            <option value="Embryologist">Embryologist</option>
                                            <option value="Admin">Admin</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase">Phone No.</label>
                                        <input type="text" :name="'clinic_contacts['+index+'][phone]'" class="input-field py-2 mt-1" placeholder="+1 234 567 8900">
                                    </div>
                                    <button type="button" @click="removeContact('clinic', index)" x-show="clinicContacts.length > 1" class="p-2 mb-0.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-[#395796] uppercase tracking-widest mb-4 border-b border-slate-200/60 pb-2">System & Credentials</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Email ID (Login) <span class="text-red-500">*</span></label>
                                <input type="email" name="admin_email" required class="input-field" placeholder="admin@clinic.com">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Password <span class="text-red-500">*</span></label>
                                <input type="password" name="admin_password" required class="input-field" placeholder="••••••••">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                                <input type="password" name="admin_password_confirmation" required class="input-field" placeholder="••••••••">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Max Branches Allowed <span class="text-red-500">*</span></label>
                                <input type="number" name="max_branches" value="1" min="0" class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Subscription Expiry Date</label>
                                <input type="date" name="exp_date" class="input-field text-slate-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">1st Warning Date</label>
                                <input type="date" name="first_warning_date" class="input-field text-slate-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">2nd Warning Date</label>
                                <input type="date" name="second_warning_date" class="input-field text-slate-500">
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" name="has_branch" value="1" x-model="hasBranch" class="w-5 h-5 text-[#395796] rounded border-gray-300 focus:ring-[#395796]">
                            <span class="text-sm font-bold text-[#395796]">Register First Branch Now?</span>
                        </label>

                        <div x-show="hasBranch" x-collapse class="mt-6 pt-6 border-t border-blue-200/60 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Branch Name <span class="text-red-500" x-show="hasBranch">*</span></label>
                                    <input type="text" name="branch_name" :required="hasBranch" class="input-field" placeholder="E.g., Downtown Branch">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Branch Address Line 1 <span class="text-red-500" x-show="hasBranch">*</span></label>
                                    <input type="text" name="branch_address_line_1" :required="hasBranch" class="input-field" placeholder="456 Branch St">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Branch Address Line 2</label>
                                    <input type="text" name="branch_address_line_2" class="input-field">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Country <span class="text-red-500" x-show="hasBranch">*</span></label>
                                    <select name="branch_country" :required="hasBranch" class="input-field">
                                        <option value="US">United States</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="IN">India</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">State/Province <span class="text-red-500" x-show="hasBranch">*</span></label>
                                    <input type="text" name="branch_state" :required="hasBranch" class="input-field">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">ZIP/Postal Code <span class="text-red-500" x-show="hasBranch">*</span></label>
                                    <input type="text" name="branch_zip_code" :required="hasBranch" class="input-field">
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between items-center border-b border-blue-200/60 pb-2 mb-4">
                                    <h3 class="text-xs font-bold text-[#395796] uppercase">Branch Contacts</h3>
                                    <button type="button" @click="addContact('branch')" class="text-[10px] font-bold text-[#E97F95] bg-[#E97F95]/10 px-3 py-1.5 rounded-lg hover:bg-[#E97F95]/20 shadow-sm">+ Add Contact</button>
                                </div>
                                
                                <div class="space-y-3">
                                    <template x-for="(contact, index) in branchContacts" :key="contact.id">
                                        <div class="flex gap-3 items-end bg-white p-4 rounded-xl border border-blue-100 shadow-sm">
                                            <div class="flex-1">
                                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Name</label>
                                                <input type="text" :name="'branch_contacts['+index+'][name]'" class="input-field py-2 mt-1" placeholder="Jane Doe">
                                            </div>
                                            <div class="w-1/4">
                                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Position</label>
                                                <select :name="'branch_contacts['+index+'][position]'" class="input-field py-2 mt-1">
                                                    <option value="Branch Manager">Manager</option>
                                                    <option value="Reception">Reception</option>
                                                    <option value="Doctor">Doctor</option>
                                                </select>
                                            </div>
                                            <div class="flex-1">
                                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Phone No.</label>
                                                <input type="text" :name="'branch_contacts['+index+'][phone]'" class="input-field py-2 mt-1" placeholder="+1 234 567 8900">
                                            </div>
                                            <button type="button" @click="removeContact('branch', index)" x-show="branchContacts.length > 1" class="p-2 mb-0.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg border border-transparent hover:border-red-100">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="px-8 py-5 border-t border-slate-200 bg-slate-50/80 flex justify-end space-x-4">
                <button type="button" @click="openModal = false" class="px-6 py-2.5 bg-white text-slate-600 font-bold text-sm rounded-xl border border-slate-300 hover:bg-slate-100 transition-all shadow-sm">
                    Cancel
                </button>
                <button type="submit" form="clinicForm" class="px-8 py-2.5 bg-[#395796] text-white font-bold text-sm rounded-xl hover:bg-[#2a3d66] transition-all shadow-lg shadow-[#395796]/30">
                    Save Clinic Setup
                </button>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('clinicForm', () => ({
                openModal: false,
                hasBranch: false,
                clinicContacts: [{ id: 1 }],
                branchContacts: [{ id: 1 }],
                
                addContact(type) {
                    if (type === 'clinic') {
                        this.clinicContacts.push({ id: Date.now() });
                    } else {
                        this.branchContacts.push({ id: Date.now() });
                    }
                },
                removeContact(type, index) {
                    if (type === 'clinic') {
                        this.clinicContacts.splice(index, 1);
                    } else {
                        this.branchContacts.splice(index, 1);
                    }
                }
            }))
        })
    </script>
</body>
</html>