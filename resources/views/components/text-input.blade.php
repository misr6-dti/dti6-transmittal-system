@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-slate-300 focus:border-navy focus:ring-navy rounded-xl shadow-sm']) !!}>
