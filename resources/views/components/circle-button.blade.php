@props(['radius' => '50'])
<div {{ $attributes->merge(['class' => "flex justify-center bg-white rounded-full border drop-shadow-xl"]) }}>
    {{ $slot }}
</div>