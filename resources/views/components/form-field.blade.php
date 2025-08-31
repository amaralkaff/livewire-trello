@props(['name', 'label', 'type' => 'text', 'value' => '', 'required' => false, 'wireModel' => null])

<div {{ $attributes->only('class') }}>
    <x-input-label for="{{ $name }}" :value="__($label)" />
    <x-text-input 
        id="{{ $name }}" 
        name="{{ $name }}" 
        type="{{ $type }}"
        :value="old($name, $value)"
        @if($wireModel) wire:model="{{ $wireModel }}" @endif
        @if($required) required @endif
        class="block mt-1 w-full"
        {{ $attributes->except(['class', 'name', 'label', 'type', 'value', 'required', 'wireModel']) }}
    />
    <x-input-error :messages="$errors->get($wireModel ?? $name)" class="mt-2" />
</div>