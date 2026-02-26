<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-navy border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-navy-light focus:bg-navy-dark active:bg-navy-dark focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
