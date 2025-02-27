<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-400 to-blue-500 hover:from-green-500 hover:to-blue-600 border border-transparent rounded-md font-semibold text-xs text-white tracking-wide focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300']) }}>
    {{ $slot }}
</button>
