@props(['radius' => '50'])
<div {{ $attributes->merge(['class' => "flex justify-center rounded-full border drop-shadow-xl"]) }}>
    {{ $slot }}
</div>