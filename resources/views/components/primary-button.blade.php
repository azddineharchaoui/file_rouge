<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-emerald-500 text-white px-6 py-3 rounded-md font-medium hover:bg-emerald-600 transition']) }}>
    {{ $slot }}
</button>