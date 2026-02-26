{{-- Global Toast Notification Container --}}
<div
    x-data
    class="fixed top-5 right-5 z-[60] flex flex-col items-end space-y-3 pointer-events-none"
    style="max-width: 420px;"
>
    <template x-for="toast in $store.toast.items" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-8"
            class="pointer-events-auto w-full min-w-[320px] rounded-xl shadow-2xl border overflow-hidden backdrop-blur-sm"
            :class="{
                'bg-green-50 border-green-200 text-green-800': toast.type === 'success',
                'bg-red-50 border-red-200 text-red-800': toast.type === 'error',
                'bg-blue-50 border-blue-200 text-blue-800': toast.type === 'info',
                'bg-amber-50 border-amber-200 text-amber-800': toast.type === 'warning'
            }"
        >
            <div class="flex items-start gap-3 px-4 py-3">
                {{-- Icon --}}
                <div class="flex-shrink-0 mt-0.5">
                    {{-- Success --}}
                    <template x-if="toast.type === 'success'">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </template>
                    {{-- Error --}}
                    <template x-if="toast.type === 'error'">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </template>
                    {{-- Info --}}
                    <template x-if="toast.type === 'info'">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </template>
                    {{-- Warning --}}
                    <template x-if="toast.type === 'warning'">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </template>
                </div>

                {{-- Message --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold capitalize" x-text="toast.type"></p>
                    <p class="text-sm mt-0.5 opacity-90" x-text="toast.message"></p>
                </div>

                {{-- Close --}}
                <button
                    @click="$store.toast.dismiss(toast.id)"
                    class="flex-shrink-0 rounded-lg p-1 opacity-60 hover:opacity-100 transition-opacity"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- Auto-dismiss progress bar --}}
            <div class="h-1 w-full opacity-30"
                :class="{
                    'bg-green-500': toast.type === 'success',
                    'bg-red-500': toast.type === 'error',
                    'bg-blue-500': toast.type === 'info',
                    'bg-amber-500': toast.type === 'warning'
                }"
            >
                <div
                    class="h-full rounded-r-full"
                    :class="{
                        'bg-green-600': toast.type === 'success',
                        'bg-red-600': toast.type === 'error',
                        'bg-blue-600': toast.type === 'info',
                        'bg-amber-600': toast.type === 'warning'
                    }"
                    x-init="$nextTick(() => { $el.style.width = '100%'; $el.style.transition = 'width 5s linear'; requestAnimationFrame(() => $el.style.width = '0%'); })"
                ></div>
            </div>
        </div>
    </template>
</div>
