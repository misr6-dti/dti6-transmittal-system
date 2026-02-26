@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-navy hover:text-navy-light">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-slate-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">Account Settings</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-extrabold text-navy">My Profile</h2>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <!-- Profile Information -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100">
                <h5 class="font-bold text-slate-800">Profile Information</h5>
                <p class="text-xs text-slate-500 mt-1">Update your account's profile information and email address.</p>
            </div>
            <div class="p-6 md:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100">
                <h5 class="font-bold text-slate-800">Update Password</h5>
                <p class="text-xs text-slate-500 mt-1">Ensure your account is using a long, random password to stay secure.</p>
            </div>
            <div class="p-6 md:p-8">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        @if(Auth::user()->role && Auth::user()->role->slug !== 'admin')
        <div class="bg-white rounded-2xl shadow-sm border border-red-200">
            <div class="px-6 py-4 border-b border-red-100 bg-red-50 rounded-t-2xl">
                <h5 class="font-bold text-red-600">Extreme Action</h5>
                <p class="text-xs text-red-500 mt-1">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            </div>
            <div class="p-6 md:p-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
        @endif
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="text-center py-4">
                <div class="w-24 h-24 mx-auto bg-slate-100 rounded-full flex items-center justify-center text-navy mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h4 class="text-xl font-bold text-slate-800">{{ Auth::user()->name }}</h4>
                <div class="mt-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-navy text-white">
                        {{ Auth::user()->getRoleNames()->first() ?? 'User' }}
                    </span>
                </div>
            </div>
            
            <div class="h-px bg-slate-100 w-full my-4"></div>
            
            <div class="space-y-4 text-sm">
                <div class="flex justify-between items-center">
                    <span class="text-slate-500">Email:</span>
                    <span class="font-medium text-slate-700 truncate max-w-[180px]" title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500">Office:</span>
                    <span class="font-medium text-slate-700">{{ Auth::user()->office->code ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500">Office Type:</span>
                    <span class="font-medium text-slate-700 uppercase">{{ Auth::user()->office->type ?? 'N/A' }}</span>
                </div>
                
                <div class="h-px bg-slate-100 w-full my-2"></div>
                
                <div class="flex justify-between items-center">
                    <span class="text-slate-500">Total Logins:</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-blue-50 text-blue-700">
                        {{ Auth::user()->login_count ?? 0 }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500">Last Login:</span>
                    <span class="font-medium text-slate-700">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('M d, Y') : 'Never' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500">Member Since:</span>
                    <span class="font-medium text-slate-700">{{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
