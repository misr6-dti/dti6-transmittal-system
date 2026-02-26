@extends('layouts.app')

@section('content')
<div class="mb-8 print:hidden">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-navy hover:text-navy-light">
                            User Management
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-slate-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">Edit User</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-extrabold text-navy">Edit User Account</h2>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6">
            <div class="p-6 md:p-8">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Full Name</label>
                            <input type="text" name="name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @error('name') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Email Address</label>
                            <input type="email" name="email" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @error('email') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Role</label>
                            <select name="role" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @error('role') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role', $user->hasRole($role->name) ? $role->name : '') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Office Assignment</label>
                            <select name="office_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @error('office_id') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" required>
                                @foreach($offices as $office)
                                    <option value="{{ $office->id }}" {{ old('office_id', $user->office_id) == $office->id ? 'selected' : '' }}>{{ $office->name }} ({{ $office->code }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Division (Optional)</label>
                            <select name="division_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @error('division_id') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror">
                                <option value="">Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" {{ old('division_id', $user->division_id) == $division->id ? 'selected' : '' }}>{{ $division->name }} ({{ $division->code }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <h6 class="font-bold text-slate-800 mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Change Password <span class="text-xs font-normal text-slate-500 ml-2">(Leave blank if no change)</span>
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">New Password</label>
                                <input type="password" name="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all @error('password') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" placeholder="••••••••">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-navy/20 focus:border-navy text-sm transition-all" placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-slate-100 pt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 font-medium transition-colors text-sm">Cancel</a>
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-navy text-white text-sm font-medium rounded-xl hover:bg-navy-light shadow-lg shadow-navy/20 transition-all transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Update Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-1">
        <div class="bg-slate-50 border-l-4 border-navy rounded-r-xl p-6 shadow-sm">
            <div class="flex items-center mb-4">
                <div class="bg-white rounded-lg p-2 mr-3 text-navy shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h6 class="font-bold text-slate-800 mb-0">System Log</h6>
            </div>
            <div class="text-xs text-slate-500 space-y-3">
                <div>
                    <span class="block text-slate-400 uppercase tracking-wider font-bold text-[10px]">Created On</span>
                    <strong class="text-slate-700">{{ $user->created_at->format('F d, Y') }}</strong>
                </div>
                <div class="border-t border-slate-200 pt-2">
                    <span class="block text-slate-400 uppercase tracking-wider font-bold text-[10px]">Last Updated</span>
                    <strong class="text-slate-700">{{ $user->updated_at->diffForHumans() }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
