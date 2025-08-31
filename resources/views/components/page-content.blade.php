@props(['maxWidth' => '7xl', 'background' => 'bg-white'])

<div class="py-12">
    <div class="max-w-{{ $maxWidth }} mx-auto sm:px-6 lg:px-8">
        <div class="{{ $background }} overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>