@extends('layouts.app')

@section('content')
<div class="mb-8" x-data="{ 
    search: '',
    expanded: null,
    categories: [
        {
            name: 'System Basics',
            icon: '<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z\'></path></svg>',
            items: [
                {
                    id: 1,
                    q: 'Why was the Microsoft Access–based system replaced?',
                    a: 'The previous system, built on Microsoft Access, had limitations in scalability, multi-office access, and real-time collaboration. It required local installations, was prone to data inconsistencies, and lacked advanced tracking and audit features. The upgraded web-based system provides centralized access, real-time status updates, enhanced security, and seamless integration across all DTI Region VI offices.'
                },
                {
                    id: 2,
                    q: 'What are the key benefits of the web-based system?',
                    a: 'Centralized access from any office, real-time tracking with status updates, comprehensive audit logs for accountability, and an Excel-like interface for familiarity. It also ensures printable outputs comply with official DTI formats and is scalable for future features.'
                },
                {
                    id: 3,
                    q: 'Can multiple users access the system at the same time?',
                    a: 'Yes. The web-based system supports concurrent multi-user access, allowing staff from different offices to create, track, and update transmittals simultaneously without connectivity conflicts common in legacy database files.'
                }
            ]
        },
        {
            name: 'Tracking & Security',
            icon: '<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z\'></path></svg>',
            items: [
                {
                    id: 4,
                    q: 'How does the system improve document tracking?',
                    a: 'Each transmittal has a unique reference number. The system logs all actions (creation, updates, and receiving) with timestamps and user IDs, enabling real-time monitoring of document flow and reducing the risk of lost or delayed documents.'
                },
                {
                    id: 5,
                    q: 'Is the system secure?',
                    a: 'Yes. The system includes user authentication, role-based access control (RBAC), and comprehensive audit logs. Regular backups and secure hosting ensure data integrity. We also include VAPT-compliant features like sensitive data advisories.'
                }
            ]
        },
        {
            name: 'Operations & Support',
            icon: '<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z\'></path></svg>',
            items: [
                {
                    id: 6,
                    q: 'Can I print transmittals in official DTI formats?',
                    a: 'Absolutely. The system generates transmittals in PDF formats that comply with official DTI documentation standards, ready for professional printing and physical filing.'
                },
                {
                    id: 7,
                    q: 'What should I do if I encounter issues?',
                    a: 'Users can contact the IT Support team at r06.mis@dti.gov.ph, or refer to the online help section/user manual within the system for step-by-step guides and troubleshooting tips.'
                }
            ]
        }
    ],
    get filteredCategories() {
        if (!this.search) return this.categories;
        const s = this.search.toLowerCase();
        return this.categories.map(cat => ({
            ...cat,
            items: cat.items.filter(item => 
                item.q.toLowerCase().includes(s) || 
                item.a.toLowerCase().includes(s)
            )
        })).filter(cat => cat.items.length > 0);
    }
}">
    <!-- Breadcrumbs & Header -->
    <div class="mb-8">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-navy hover:text-navy-light font-medium text-sm flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">FAQs</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <h2 class="text-3xl font-extrabold text-navy tracking-tight">Frequently Asked Questions</h2>
                <p class="text-slate-500 mt-1">Everything you need to know about the TMS platform.</p>
            </div>
            
            <div class="relative w-full md:w-80 group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-navy transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" 
                       x-model="search"
                       placeholder="Search questions or keywords..." 
                       class="block w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-xl leading-5 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-navy/10 focus:border-navy text-sm transition-all shadow-sm">
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div x-show="filteredCategories.length === 0" x-cloak class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-slate-200">
        <div class="bg-slate-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-navy">No results found</h3>
        <p class="text-slate-500">We couldn't find anything matching "<span x-text="search" class="font-medium text-navy"></span>". Try different keywords.</p>
        <button @click="search = ''" class="mt-4 text-navy font-bold hover:underline">Clear Search</button>
    </div>

    <!-- FAQ Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Sidebar Navigation (Desktop) -->
        <div class="lg:col-span-3 space-y-2 hidden lg:block sticky top-24">
            <template x-for="cat in categories" :key="cat.name">
                <button @click="search = ''; $nextTick(() => document.getElementById('cat-' + cat.name.replace(/\s+/g, '-')).scrollIntoView({behavior: 'smooth', block: 'center'}))"
                        class="w-full flex items-center px-4 py-3 rounded-xl text-left transition-all font-medium border border-transparent hover:bg-white hover:border-slate-100 group"
                        :class="search === '' ? 'text-slate-600' : 'opacity-50'">
                    <span class="mr-3 text-slate-400 group-hover:text-navy transition-colors" x-html="cat.icon"></span>
                    <span x-text="cat.name"></span>
                </button>
            </template>
        </div>

        <!-- Scrollable Questions -->
        <div class="lg:col-span-9 space-y-12">
            <template x-for="category in filteredCategories" :key="category.name">
                <div :id="'cat-' + category.name.replace(/\s+/g, '-')" class="scroll-mt-24">
                    <div class="flex items-center mb-6 px-1">
                        <div class="w-10 h-10 bg-navy bg-opacity-10 rounded-xl flex items-center justify-center text-navy mr-4">
                            <span x-html="category.icon"></span>
                        </div>
                        <h3 class="text-xl font-bold text-navy" x-text="category.name"></h3>
                    </div>

                    <div class="space-y-4">
                        <template x-for="item in category.items" :key="item.id">
                            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition-all duration-300"
                                 :class="expanded === item.id ? 'ring-2 ring-navy/5 border-navy/20' : 'hover:border-slate-300 shadow-sm'">
                                <button @click="expanded = (expanded === item.id ? null : item.id)"
                                        class="w-full px-6 py-5 text-left flex justify-between items-center group">
                                    <span class="text-[15px] font-bold text-slate-700 group-hover:text-navy transition-colors"
                                          :class="expanded === item.id ? 'text-navy' : ''"
                                          x-text="item.q"></span>
                                    <svg class="w-5 h-5 text-slate-400 transition-transform duration-300 flex-shrink-0 ml-4"
                                         :class="expanded === item.id ? 'rotate-180 text-navy' : ''" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="expanded === item.id" 
                                     x-collapse
                                     class="px-6 pb-6 text-slate-500 text-[15px] leading-relaxed border-t border-slate-50 pt-4"
                                     x-text="item.a">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
    
    <!-- Support Footer -->
    <div class="mt-20 p-8 bg-navy rounded-[2.5rem] text-white overflow-hidden relative shadow-2xl shadow-navy/20">
        <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-center md:text-left">
                <h4 class="text-2xl font-extrabold mb-2">Still have questions?</h4>
                <p class="text-navy-lighter opacity-80 max-w-md">Our technical team is ready to assist you with any system-related concerns or feature requests.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="mailto:r06.mis@dti.gov.ph" class="bg-white text-navy px-8 py-3.5 rounded-2xl font-bold hover:bg-slate-50 transition-all flex items-center justify-center shadow-lg shadow-black/10">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Contact IT Support
                </a>
                <a href="{{ route('manual') }}" class="bg-navy-dark text-white px-8 py-3.5 rounded-2xl font-bold hover:bg-navy-darker transition-all border border-white/10 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Read User Manual
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
