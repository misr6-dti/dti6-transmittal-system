@props([
    'name',
    'show' => false,
    'maxWidth' => 'md'
])

@php
$maxWidthClass = [
    'sm' => 'modal-sm',
    'md' => '',
    'lg' => 'modal-lg',
    'xl' => 'modal-xl',
    '2xl' => 'modal-xl',
][$maxWidth];
@endphp

<div
    x-data="{
        show: @js($show),
        focusables() {
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)].filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.style.overflow = 'hidden';
            {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
        } else {
            document.body.style.overflow = null;
        }
    })"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="modal fade show"
    style="display: block; background: rgba(0,0,0,0.5);"
    tabindex="-1"
    role="dialog"
>
    <div class="modal-dialog modal-dialog-centered {{ $maxWidthClass }}" role="document" x-show="show" x-transition>
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem;">
            {{ $slot }}
        </div>
    </div>
</div>
